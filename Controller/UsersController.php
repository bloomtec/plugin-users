<?php
App::uses('UserControlAppController', 'UserControl.Controller');
/**
 * Users Controller
 *
 */
class UsersController extends UserControlAppController {
	
	/**
	 * Llaves de ReCaptcha
	 */
	private $public_key = "6LfC5dESAAAAANQHI4pvu2S_wniSgHivoXFYuT5a";
	private $private_key = "6LfC5dESAAAAAL-J0uwgmJMSxrBSwSd0uXXZ3Wqt";

	public function beforeFilter() {
		parent::beforeFilter();
		$this -> User -> bindModel(
			array(
				'belongsTo' => array(
					'Role' => array(
						'className' => 'UserControl.Role',
						'foreignKey' => 'role_id',
						'conditions' => '',
						'fields' => '',
						'order' => ''
					)
				)
			)
		);
		$this -> Auth -> allow('register');
	}

	/**
	 * profile method
	 *
	 * @return void
	 */
	public function profile() {		
		if (!$this -> Auth -> user('id')) {
			$this -> redirect(
				array(
					'action' => 'login',
					'controller' => 'users',
					'plugin' => 'user_control'
				)
			);
		} else {
			$this -> set('user', $this -> User -> read(null, $this -> Auth -> user('id')));
		}
	}

	/**
	 * edit method
	 *
	 * @return void
	 */
	public function edit() {
		if (!$this -> Auth -> user('id')) {
			$this -> redirect(
				array(
					'action' => 'login',
					'controller' => 'users',
					'plugin' => 'user_control'
				)
			);
		} else {
			if ($this -> request -> is('post') || $this -> request -> is('put')) {
				if ($this -> User -> save($this -> request -> data)) {
					$this -> Session -> setFlash(__('The user has been saved'));
					$this -> redirect(array('action' => 'index'));
				} else {
					$this -> Session -> setFlash(__('The user could not be saved. Please, try again.'));
				}
			}
			$this -> request -> data = $this -> User -> read(null, $this -> Auth -> user('id'));
			$roles = $this -> User -> Role -> find('list');
			$this -> set(compact('roles'));
		}
	}
	
	/**
	 * editPassword method
	 *
	 * @return void
	 */
	public function editPassword() {
		if (!$this -> Auth -> user('id')) {
			$this -> redirect(
				array(
					'action' => 'login',
					'controller' => 'users',
					'plugin' => 'user_control'
				)
			);
		} else {
			if ($this -> request -> is('post') || $this -> request -> is('put')) {
				if ($this -> User -> save($this -> request -> data)) {
					$this -> Session -> setFlash(__('Se ha modificado la contraseña'));
					$this -> redirect(
						array(
							'action' => 'profile',
							'controller' => 'users',
							'plugin' => 'user_control'
						)
					);
				} else {
					$this -> Session -> setFlash(__('No se pudo modificar la contraseña. Por favor, intente de nuevo.'));
				}
			}
			$this -> request -> data = $this -> User -> read(null, $this -> Auth -> user('id'));
			$roles = $this -> User -> Role -> find('list');
			$this -> set(compact('roles'));
		}
	}
	
	/**
	 * addresses method
	 *
	 * @return void
	 */
	public function addresses() {
		if (!$this -> Auth -> user('id')) {
			$this -> redirect(
				array(
					'action' => 'login',
					'controller' => 'users',
					'plugin' => 'user_control'
				)
			);
		} else {
			if ($this -> request -> is('post') || $this -> request -> is('put')) {
				if ($this -> User -> save($this -> request -> data)) {
					$this -> Session -> setFlash(__('The user has been saved'));
					$this -> redirect(array('action' => 'profile'));
				} else {
					$this -> Session -> setFlash(__('The user could not be saved. Please, try again.'));
				}
			}
			$this -> request -> data = $this -> User -> read(null, $this -> Auth -> user('id'));
			$roles = $this -> User -> Role -> find('list');
			$this -> set(compact('roles'));
		}
	}
	
	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this -> User -> recursive = 0;
		$this -> set('users', $this -> paginate());
	}

	/**
	 * view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		$this -> User -> id = $id;
		if (!$this -> User -> exists()) {
			throw new NotFoundException(__('Usuario no válido'));
		}
		$this -> set('user', $this -> User -> read(null, $id));
	}

	/**
	 * edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		$this -> User -> id = $id;
		if (!$this -> User -> exists()) {
			throw new NotFoundException(__('Usuario no válido'));
		}
		if ($this -> request -> is('post') || $this -> request -> is('put')) {
			if ($this -> User -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('The user has been saved'));
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$this -> request -> data = $this -> User -> read(null, $id);
		}
		$roles = $this -> User -> Role -> find('list');
		$this -> set(compact('roles'));
	}
	
	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this -> request -> is('post')) {
			$this -> User -> create();
			if ($this -> User -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('The user has been saved'));
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$roles = $this -> User -> Role -> find('list');
		$this -> set(compact('roles'));
	}

	public function admin_setActive($id) {
		
	}
	
	public function admin_setInactive($id) {
		
	}
	
	/**
	 * Inicio de sesión
	 *
	 * @return void
	 */
	public function login() {
		
		/**
		 * Llevar un registro de cuantos inicios de sesión se tienen
		 */
		$login_attempts = $this -> Cookie -> read('User.login_attempts');
		if(!$login_attempts) {
			$login_attempts = 1;
			$this -> Cookie -> write('User.login_attempts', $login_attempts);
			$login_attempts = $this -> Cookie -> read('User.login_attempts');
		}
		
		// Variable que contiene el error del captcha
		$error = null;
		
		if(!$login_attempts || $login_attempts > 3) {
			/**
			 * Sección ReCaptcha
			 */
			 
			// ReCaptcha Lib
			$lib_path = APP . 'Plugin/UserControl/Lib/ReCaptcha/recaptchalib.php';
			require_once ($lib_path);
			
			/**
			 * Fin sección ReCaptcha
			 */
			
			if ($this -> request -> is('post')) {
				// was there a reCAPTCHA response?
				if (isset($_POST['recaptcha_challenge_field']) && isset($_POST['recaptcha_response_field'])) {
					$resp = recaptcha_check_answer(
						$this -> private_key, $_SERVER["REMOTE_ADDR"],
						$_POST['recaptcha_challenge_field'],
						$_POST['recaptcha_response_field']
					);
					
					// Verificar la respuesta de ReCaptcha
					if ($resp -> is_valid) {
						if($this -> request -> is('post')) {
							if ($this -> Auth -> login()) {
								$this -> Cookie -> delete('User.login_attempts');
								return $this -> redirect($this -> Auth -> redirect());
								$this -> Session -> setFlash(__('Has iniciado sesión.'), 'default', array(), 'auth');
							} else {
								$login_attempts += 1;
								$this -> Cookie -> write('User.login_attempts', $login_attempts);
								$this -> Session -> setFlash(__('Usuario o contraseña incorrectos.'), 'default', array(), 'auth');
							}
						}
					} else {
						// Asignar el error para llevar a la vista
						$this -> Session -> setFlash(__('Debes ingresar los datos correctos al captcha'));
						$error = $resp -> error;
					}
				}
			}
		} else {
			if($this -> request -> is('post')) {
				if ($this -> Auth -> login()) {
					$this -> Cookie -> delete('User.login_attempts');
					return $this -> redirect($this -> Auth -> redirect());
					$this -> Session -> setFlash(__('Has iniciado sesión.'), 'default', array(), 'auth');
				} else {
					$login_attempts += 1;
					$this -> Cookie -> write('User.login_attempts', $login_attempts);
					$this -> Session -> setFlash(__('Usuario o contraseña incorrectos.'), 'default', array(), 'auth');
				}
			}
		}
		
		$this -> set('login_attempts', $login_attempts);
		$this -> set('error', $error);
		$this -> set('public_key', $this -> public_key);
	}

	/**
	 * Cerrar la sesión de usuario activa
	 *
	 * @return void
	 */
	public function logout() {
		$this -> redirect($this -> Auth -> logout());
	}
	
	/**
	 * Registro de usuario
	 * 
	 * @return void
	 */
	public function register() {
		
		/**
		 * Sección ReCaptcha
		 */
		 
		// ReCaptcha Lib
		$lib_path = APP . 'Plugin/UserControl/Lib/ReCaptcha/recaptchalib.php';
		require_once ($lib_path);
		
		$error = null;
		
		/**
		 * Fin sección ReCaptcha
		 */
		
		if ($this -> request -> is('post')) {
			// was there a reCAPTCHA response?
			if (isset($_POST['recaptcha_challenge_field']) && isset($_POST['recaptcha_response_field'])) {
				$resp = recaptcha_check_answer(
					$this -> private_key, $_SERVER["REMOTE_ADDR"],
					$_POST['recaptcha_challenge_field'],
					$_POST['recaptcha_response_field']
				);
				
				// Verificar la respuesta de ReCaptcha
				if ($resp -> is_valid) {
					// Proceder con la creación de usuario
					if(!isset($this -> request -> data['User']['username'])) {
						$this -> request -> data['User']['username'] = $this -> request -> data['User']['email'];
					}
					$clientRole = $this -> User -> Role -> find('first', array('order' => array('id' => 'DESC'), 'recursive' => -1));
					$this -> request -> data['User']['role_id'] = $clientRole['Role']['id'];
					$this -> User -> create();
					if ($this -> User -> save($this -> request -> data)) {
						$user_id = $this -> User -> id;
						$user_alias = $this -> request -> data['User']['username'];
						$this -> User -> query("UPDATE `aros` SET `alias`='$user_alias' WHERE `model`='User' AND `foreign_key`=$user_id");
						
						// Enviar el correo de registro
						$result = $this -> sendRegistrationEmail($this -> request -> data);
						if($result) {
							$this -> Session -> setFlash(__('Registro Exitoso. Se te ha enviado un correo a la dirección registrada'));
						} else {
							$this -> Session -> setFlash(__('Registro Exitoso'));
						}
						$this -> redirect('/');
					} else {
						$this -> Session -> setFlash(__('Falló el registro. Verifique los datos e intente de nuevo.'));
					}
				} else {
					// Asignar el error para llevar a la vista
					$this -> Session -> setFlash(__('Debes ingresar los datos correctos al captcha'));
					$error = $resp -> error;
				}
			}
		}
		$this -> set('error', $error);
		$this -> set('public_key', $this -> public_key);
	}
	
	/**
	 * Verificar los posibles medios de envío de correo y proceder acorde
	 * 
	 * @var $user arreglo con los datos del usuario
	 * 
	 * @return true o false dependiendo de si fue exitoso el envío
	 */
	private function sendRegistrationEmail($user = null) {
		if($user) {
			$this -> loadModel('UserMailConfig');
			$user_mail_config = $this -> UserMailConfig -> read(null, 1);
			
			// Verificar si se está usando un servicio
			if($user_mail_config['UserMailConfig']['is_active']) {
				// Verificar el servicio que se esta usando
				switch($user_mail_config['UserMailConfig']['mail_service_id']) {
					// MailChimp
					case 1:
						return $this -> mailChimpRegistrationEmail($user, $user_mail_config['UserMailConfig']['api_key']);
						break;
					// No hay servicios configurados
					default:
						// TODO : que hacer aqui?
						return false;
						break;
				}
			}
		} else {
			return false;
		}
	}
	
	/**
	 * Envío de correo mediante mailchimp
	 * 
	 * @var $user arreglo con los datos del usuario
	 * @var $api_key llave de acceso de la cuenta de mailchimp
	 * 
	 * @return true o false dependiendo de si fue exitoso el envío 
	 */
	private function mailChimpRegistrationEmail($user = null, $api_key = null) {
		if($user && $api_key) {
			$lib_path = APP . 'Plugin/UserControl/Lib/MailChimp/MCAPI.class.php';
			require_once($lib_path);
			$api = new MCAPI($api_key);
			
			$list_id = '0ae21abae4'; // ID único de la lista de clientes registrados
			$merge_vars = array();
			
			return $api -> listSubscribe($list_id, $user['User']['email'], $merge_vars);
			
		} else {
			return false;
		}
	}
	
	/**
	 * Enviar correo para confirmar solicitud de 'reset' de contraseña
	 */
	public function sendResetPasswordRequestedEmail() {
		
	}
	
	/**
	 * Enviar correo con la nueva contraseña al usuario
	 */
	public function sendResetPasswordConfirmationEmail() {
		
	}

}
