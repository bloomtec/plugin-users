<?php
App::uses('UserControlAppController', 'UserControl.Controller');
/**
 * Users Controller
 *
 */
class UsersController extends UserControlAppController {

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
	 * view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		$this -> User -> id = $id;
		if (!$this -> User -> exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this -> set('user', $this -> User -> read(null, $id));
	}

	/**
	 * edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		$this -> User -> id = $id;
		if (!$this -> User -> exists()) {
			throw new NotFoundException(__('Invalid user'));
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
	 * index method
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
			throw new NotFoundException(__('Invalid user'));
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
			throw new NotFoundException(__('Invalid user'));
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
		if ($this -> request -> is('post')) {
			if ($this -> Auth -> login()) {
				return $this -> redirect($this -> Auth -> redirect());
				$this -> Session -> setFlash(__('Has iniciado sesión.'), 'default', array(), 'auth');
			} else {
				$this -> Session -> setFlash(__('Usuario o contraseña incorrectos.'), 'default', array(), 'auth');
			}
		}
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
		
		// Get a key from https://www.google.com/recaptcha/admin/create
		$public_key = "6LfC5dESAAAAANQHI4pvu2S_wniSgHivoXFYuT5a";
		$private_key = "6LfC5dESAAAAAL-J0uwgmJMSxrBSwSd0uXXZ3Wqt";
		
		// the response from reCAPTCHA
		$resp = null;
		// the error code from reCAPTCHA, if any
		$error = null;
		
		/**
		 * Fin sección ReCaptcha
		 */
		
		if ($this -> request -> is('post')) {
			
			debug($this -> request -> data);
			
			// was there a reCAPTCHA response?
			//if (isset($_POST["recaptcha_response_field"])) {
			if (isset($this -> request -> data['User']['captcha_response']) && !empty($this -> request -> data['User']['captcha_response'])) {
				$resp = recaptcha_check_answer(
					$private_key, $_SERVER["REMOTE_ADDR"],
					$this -> request -> data['User']['captcha_challenge'],
					$this -> request -> data['User']['captcha_response']
				);
				
				// Verificar la respuesta de ReCaptcha
				if ($resp -> is_valid) {
					echo 'EXITO';
					// Proceder con la creación de usuario
					if(!isset($this -> request -> data['User']['username'])) {
						$this -> request -> data['User']['username'] = $this -> request -> data['User']['email'];
					}
					$this -> request -> data['User']['role_id'] = 4;
					$this -> User -> create();
					if ($this -> User -> save($this -> request -> data)) {
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
					echo 'ERROR';
					$error = $resp -> error;
				}
			}
		}
		
		$this -> set(compact('error', 'public_key'));
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
