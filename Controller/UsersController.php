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
	
	/**
	 * Declarar aquí lo que debe suceder siempre que se acceda a usuarios
	 * 
	 * @return void
	 */
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
		
		// Métodos que deben quedar públicos
		$this -> Auth -> allow('admin_login', 'login', 'register', 'registerEmail', 'resetPassword', 'createUser', 'logout', 'admin_logout');
		
	}
	
	/**
	 * Vericar el acceso de un usuario a una función mediante ACL
	 */
	public function verifyUserAccess() {
		if($this -> Auth -> user('id')) {
			// Armar la ruta
			$ruta = '';
			for ($i = 0; $i < count($this -> params['ruta']); $i++) {
				$ruta .= $this -> params['ruta'][$i];
				if ($i != count($this -> params['ruta']) - 1) {
					$ruta .= '/';
				}
			}
			return $this -> Acl -> check($this -> Session -> read('Auth.User.username'), $ruta);
		} else {
			return false;
		}
	}

	/**
	 * profile method
	 *
	 * @return void
	 */
	public function profile() {	
		$this -> layout='profile';
		if (!$this -> Auth -> user('id')) {
			$this -> redirect(
				array(
					'action' => 'login',
					'controller' => 'users',
					'plugin' => 'user_control'
				)
			);
		} else {
			$referer=split('/', $this -> referer());
			$user = $this -> User -> read(null, $this -> Auth -> user('id'));
			if( $referer[count($referer) -1 ] == "login" ) {
				$mensaje="Bienvenido ".$user['User']['name'].", tu ingreso ha sido exitoso";
				$this -> set('mensaje',$mensaje);
			}
			$this -> set('user', $user);
		}
	}

	/**
	 * edit method
	 *
	 * @return void
	 */
	public function edit() {
		$this -> layout='profile';
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
					$this -> Session -> setFlash(__('Se modificó el usuario'), 'crud/success');
					$this -> redirect(array('action' => 'profile'));
				} else {
					$this -> Session -> setFlash(__('No se pudo modificar el usuario. Por favor, intente de nuevo,'), 'crud/error');
				}
			}
			$this -> request -> data = $this -> User -> read(null, $this -> Auth -> user('id'));
			$documentTypes = $this -> User -> DocumentType -> find('list');
			$this -> set(compact('documentTypes'));
		}
	}
	
	/**
	 * editPassword method
	 *
	 * @return void
	 */
	public function editPassword() {
		$this -> layout='profile';
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
					$this -> Session -> setFlash(__('Se ha modificado la contraseña'), 'crud/success');
					$this -> redirect(
						array(
							'action' => 'profile',
							'controller' => 'users',
							'plugin' => 'user_control'
						)
					);
				} else {
					$this -> Session -> setFlash(__('No se pudo modificar la contraseña. Por favor, intente de nuevo.'), 'crud/error');
				}
			}
		}
	}
	
	public function orders() {
		$this -> layout='profile';
		if (!$this -> Auth -> user('id')) {
			$this -> redirect(
				array(
					'action' => 'login',
					'controller' => 'users',
					'plugin' => 'user_control'
				)
			);
		} 
		$orders = $this -> User -> Order -> find('all',array(
				'conditions'=>array(
					'Order.user_id'=>$this -> Auth -> user('id')
				),
				'contain'=>array('OrderState','UserAddress','OrderItem'=>array('Product','ProductSize'))
			)
		);
		$this -> set('orders',$orders);
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
		$this -> User -> recursive = 1;
		if (!$this -> User -> exists()) {
			throw new NotFoundException(__('Usuario no válido'));
		}
		$user = $this -> User -> read(null, $id);
		$this -> set('user', $user);
	}
	
	/**
	 * Asignar permisos (Seccion de manejo ACL)
	 *
	 * @param int $id ID del usuario al que se le asignarán permisos
	 * @return void
	 */
	public function admin_privileges($id) {
		$this -> User -> Behaviors -> attach('Containable');
		$this -> User -> contain('Role');
		$this -> User -> currentUsrId = $this -> Auth -> user('id');
		$this -> User -> id = $id;
		if (!$this -> User -> exists()) {
			throw new NotFoundException(__('Usuario no válido'));
		} else {
			$this -> userAliasFix($id);
		}
		if ($this -> request -> is('post') || $this -> request -> is('put')) {
			$user = $this -> User -> find('first', array('conditions' => array('User.id' => $id)));
			if ($user['User']['role_id'] == 2) {
				//debug($this -> request -> data);
				// Es supervisor. Asignar acorde los permisos seleccionados.
				$aro_id = $this -> User -> query("SELECT `id` FROM `aros` WHERE `model`='User' AND `foreign_key`=$id");
				$aro_id = $aro_id[0]['aros']['id'];
				$this -> User -> query("DELETE FROM `aros_acos` WHERE `aro_id`=$aro_id");
				$this -> setPrivilege($user, 'Categories', $this -> request -> data['Privilege']['Category']);
				$this -> setPrivilege($user, 'Colors', $this -> request -> data['Privilege']['Color']);
				$this -> setPrivilege($user, 'ProductSizes', $this -> request -> data['Privilege']['ProductSize']);
				$this -> setPrivilege($user, 'Products', $this -> request -> data['Privilege']['Product']);
				$this -> setPrivilege($user, 'Promotions', $this -> request -> data['Privilege']['Promotion']);
				$this -> setPrivilege($user, 'CouponBatches', $this -> request -> data['Privilege']['CouponBatch']);
				$this -> setPrivilege($user, 'Orders', $this -> request -> data['Privilege']['Order']);
				$this -> setPrivilege($user, 'Surveys', $this -> request -> data['Privilege']['Survey']);
				$this -> setPrivilege($user, 'Pages', $this -> request -> data['Privilege']['Page']);
				$this -> setPrivilege($user, 'Menus', $this -> request -> data['Privilege']['Menu']);
				$this -> setPrivilege($user, 'MenuItems', $this -> request -> data['Privilege']['MenuItem']);
				$this -> Acl -> allow($user['User']['username'], "controllers/UserControl/Users/admin_logout");
				$this -> Session -> setFlash(__('Se asigaron los permisos al usuario'), 'crud/success');
				$this -> redirect(array('action' => 'index'));
			} else {
				// Caso en que se es administrador o cliente.
				// Por el momento no se hace algo en estos casos. Admin con acceso a todo y clientes no tienen privilegios extra.
			}
		} else {
			$user = $this -> User -> read(null, $id);
			$user['Privilege']['Category'] = $this -> getPrivilege($user, 'Categories');
			$user['Privilege']['Color'] = $this -> getPrivilege($user, 'Colors');
			$user['Privilege']['ProductSize'] = $this -> getPrivilege($user, 'ProductSizes');
			$user['Privilege']['Product'] = $this -> getPrivilege($user, 'Products');
			$user['Privilege']['Promotion'] = $this -> getPrivilege($user, 'Promotions');
			$user['Privilege']['CouponBatch'] = $this -> getPrivilege($user, 'CouponBatches');
			$user['Privilege']['Order'] = $this -> getPrivilege($user, 'Orders');
			$user['Privilege']['Survey'] = $this -> getPrivilege($user, 'Surveys');
			$user['Privilege']['Page'] = $this -> getPrivilege($user, 'Pages');
			$user['Privilege']['Menu'] = $this -> getPrivilege($user, 'Menus');
			$user['Privilege']['MenuItem'] = $this -> getPrivilege($user, 'MenuItems');
			$this -> request -> data = $user;
		}
	}
	
	private function userAliasFix($user_id) {
		$user = $this -> User -> read(null, $user_id);
		$user_alias = $user['User']['username'];
		$this -> User -> query("UPDATE `aros` SET `alias`='$user_alias' WHERE `model`='User' AND `foreign_key`=$user_id");
		//$aro_id = $this -> User -> query("SELECT `id` FROM `aros` WHERE `model`='User' AND `foreign_key`=$user_id");
		//$aro_id = $aro_id[0]['aros']['id'];
		//$this -> User -> query("DELETE FROM `aros_acos` WHERE `aro_id`=$aro_id");
	}
	
	private function getControllerActions($controller) {
		App::uses($controller, 'Controller');
		$actions = get_class_methods($controller);
		foreach($actions as $key => $action) {
			if(!strstr($action, 'admin_')) {
				unset($actions[$key]);
			}
		}
		return $actions;
	}
	
	/**
	 * Asignar permisos de una clase especifica
	 *
	 * @param array $usuario Arreglo con la información del usuario al que se le está modificando acceso
	 * @param array $permisos Arreglo con las zonas especificas de la clase en cuestión
	 */
	private function setPrivilege($user = null, $controller = null, $access = false) {
		if($user && $controller && $access) {
			$actions = $this -> getControllerActions($controller . 'Controller');
			foreach ($actions as $key => $action) {
				$this -> Acl -> allow($user['User']['username'], "controllers/$controller/$action");
			}
		}
	}

	/**
	 * Obtener permisos de una clase especifica
	 *
	 * @param array $usuario Arreglo con la información del usuario al que se le está modificando acceso
	 * @return Arreglo con información de acceso de la clase correspondiente
	 */
	private function getPrivilege($user, $controller) {
		$actions = $this -> getControllerActions($controller . 'Controller');
		foreach ($actions as $key => $action) {
			if (!$this -> Acl -> check($user['User']['username'], "controllers/$controller/$action"))
				return false;
		}
		return true;
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
				$this -> Session -> setFlash(__('Se modificó el usuario'), 'crud/success');
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('No se pudo modificar el usuario. Por favor, intente de nuevo.'), 'crud/error');
			}
		} else {
			$this -> request -> data = $this -> User -> read(null, $id);
		}
		$roles = $this -> User -> Role -> find('list', array('fields' => array('Role.role')));
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
				$user = $this -> User -> read(null, $this -> User -> id);
				$user_id = $user['User']['id'];
				$user_alias = $user['User']['username'];
				$this -> User -> query("UPDATE `aros` SET `alias`='$user_alias' WHERE `model`='User' AND `foreign_key`=$user_id");
				$this -> Session -> setFlash(__('Se agregó el usuario'), 'crud/success');
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('No se pudo agregar el usuario. Por favor, intente de nuevo.'), 'crud/error');
			}
		}
		$roles = $this -> User -> Role -> find('list', array('fields' => array('Role.role')));
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
	public function admin_login() {
		
		$this -> layout="Ez.login";
		
		$this -> loadModel('Aro');
		$this -> Aro -> verify();
		$this -> Aro -> recover();
		
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
								return $this -> redirect(array(
									'controller' => 'users',
									'action' => 'index',
									'plugin' => 'user_control',
									'admin' => true
								));
								$this -> Session -> setFlash(__('Has iniciado sesión.'));
							} else {
								$login_attempts += 1;
								$this -> Cookie -> write('User.login_attempts', $login_attempts);
								$this -> Session -> setFlash(__('Usuario o contraseña incorrectos.'));
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
					if($this -> Auth -> user('role_id') == 1) {
						return $this -> redirect(array(
							'controller' => 'users',
							'action' => 'index',
							'plugin' => 'user_control',
							'admin' => true
						));
					} elseif($this -> Auth -> user('role_id') == 2) {
						$user = $this -> User -> read(null, $this -> Auth -> user('id'));
						if($this -> getPrivilege($user, 'Categories')) {
							return $this -> redirect(array(
								'controller' => 'categories',
								'action' => 'index',
								'plugin' => false,
								'admin' => true
							));
						} elseif($this -> getPrivilege($user, 'Colors')) {
							return $this -> redirect(array(
								'controller' => 'colors',
								'action' => 'index',
								'plugin' => false,
								'admin' => true
							));
						} elseif($this -> getPrivilege($user, 'ProductSizes')) {
							return $this -> redirect(array(
								'controller' => 'product_sizes',
								'action' => 'index',
								'plugin' => false,
								'admin' => true
							));
						} elseif($this -> getPrivilege($user, 'Products')) {
							return $this -> redirect(array(
								'controller' => 'products',
								'action' => 'index',
								'plugin' => false,
								'admin' => true
							));
						} elseif($this -> getPrivilege($user, 'Promotions')) {
							return $this -> redirect(array(
								'controller' => 'promotions',
								'action' => 'index',
								'plugin' => false,
								'admin' => true
							));
						} elseif($this -> getPrivilege($user, 'CouponBatches')) {
							return $this -> redirect(array(
								'controller' => 'coupon_batches',
								'action' => 'index',
								'plugin' => false,
								'admin' => true
							));
						} elseif($this -> getPrivilege($user, 'Orders')) {
							return $this -> redirect(array(
								'controller' => 'orders',
								'action' => 'index',
								'plugin' => false,
								'admin' => true
							));
						} elseif($this -> getPrivilege($user, 'Surveys')) {
							return $this -> redirect(array(
								'controller' => 'surveys',
								'action' => 'index',
								'plugin' => false,
								'admin' => true
							));
						} elseif($this -> getPrivilege($user, 'Pages')) {
							return $this -> redirect(array(
								'controller' => 'pages',
								'action' => 'index',
								'plugin' => false,
								'admin' => true
							));
						} elseif($this -> getPrivilege($user, 'Menus')) {
							return $this -> redirect(array(
								'controller' => 'menus',
								'action' => 'index',
								'plugin' => false,
								'admin' => true
							));
						} else {
							$this -> Session -> setFlash(__('El usuario no tiene privilegios asignados.'), 'crud/error');
							$this -> admin_logout();
						}
					}
					$this -> Session -> setFlash(__('Has iniciado sesión.'), 'crud/success');
				} else {
					$login_attempts += 1;
					$this -> Cookie -> write('User.login_attempts', $login_attempts);
					$this -> Session -> setFlash(__('Usuario o contraseña incorrectos.'), 'crud/error');
				}
			}
		}
		
		$this -> set('login_attempts', $login_attempts);
		$this -> set('error', $error);
		$this -> set('public_key', $this -> public_key);
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
								//$this -> Session -> setFlash(__('Has iniciado sesión.'), 'crud/success');
								return $this -> redirect($this -> Auth -> redirect());
							} else {
								$login_attempts += 1;
								$this -> Cookie -> write('User.login_attempts', $login_attempts);
								$this -> Session -> setFlash(__('Usuario o contraseña incorrectos.'));
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
					//$this -> Session -> setFlash(__('Has iniciado sesión.'), 'crud/success');
					return $this -> redirect($this -> Auth -> redirect());
				} else {
					$login_attempts += 1;
					$this -> Cookie -> write('User.login_attempts', $login_attempts);
					$this -> Session -> setFlash(__('Usuario o contraseña incorrectos.'), 'crud/error');
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
	 * Cerrar la sesión administrativa de usuario activa
	 *
	 * @return void
	 */
	public function admin_logout() {
		$this -> redirect($this -> Auth -> logout());
	}
	
	public function registerEmail() {
		$this -> autoRender = false;
		if($this -> request -> is('post') || $this -> request -> is('put')) {
			$this -> loadModel('UserMailConfig');
			$this -> loadModel('MailingList');
			$user_mail_config = $this -> UserMailConfig -> read(null, 1);
			$mailing_list = $this -> MailingList -> findByScenario('Registro De Correo');
			
			// Verificar si se está usando un servicio
			if($user_mail_config['UserMailConfig']['is_active']) {
				// Verificar el servicio que se esta usando
				switch($user_mail_config['UserMailConfig']['mail_service_id']) {
					// MailChimp
					case 1:
						if($this -> mailChimpRegisterEmail(
							$this -> request -> data['User']['email'],
							$user_mail_config['UserMailConfig']['api_key'],
							$mailing_list['MailingList']['list_unique_code']
						)) {
							$this -> Session -> setFlash('Por favor revisa tu correo para confirmar el registro', 'crud/success');
						} else {
							$this -> Session -> setFlash('Ha ocurrido un error al registrar el correo. Por favor verifica el dato ingresado e intenta de nuevo.', 'crud/error');
						}
						break;
					// No hay servicios configurados
					default:
						// TODO : que hacer aqui?
						break;
				}
			} else {
				$this -> Session -> setFlash('Actualmente nuestro servicio de lista de correos esta inactivo. Por favor, intenta más tarde.');
			}
		}
		$this -> redirect($this -> referer());
	}
	
	/**
	 * Envío de correo mediante mailchimp
	 * 
	 * @var $email correo del usuario
	 * @var $api_key llave de acceso de la cuenta de mailchimp
	 * 
	 * @return true o false dependiendo de si fue exitoso el envío 
	 */
	private function mailChimpRegisterEmail($email = null, $api_key = null, $list_id = null) {
		if($email && $api_key) {
			$lib_path = APP . 'Plugin/UserControl/Lib/MailChimp/MCAPI.class.php';
			require_once($lib_path);
			$api = new MCAPI($api_key);
			
			$merge_vars = array();
			
			return $api -> listSubscribe($list_id, $email, $merge_vars);
			
		} else {
			return false;
		}
	}
	
	public function internalCreateUser($email, $name, $lastname) {
		
		$clientRole = $this -> User -> Role -> find('first', array('order' => array('id' => 'DESC'), 'recursive' => -1));
		$password = $this -> generatePassword();
		$user = array(
			'User' => array(
				'email' => $email,
				'verify_email' => $email,
				'name' => $name,
				'lastname' => $lastname,
				'password' => $password,
				'verify_password' => $password,
				'role_id' => $clientRole['Role']['id']
			)
		);		
		
		// Proceder con la creación de usuario
		$this -> User -> create();
		if ($this -> User -> save($user)) {
			$user = $this -> User -> read(null, $this -> User -> id);
			$user_id = $user['User']['id'];
			$user_alias = $user['User']['username'];
			$this -> User -> query("UPDATE `aros` SET `alias`='$user_alias' WHERE `model`='User' AND `foreign_key`=$user_id");
			return array('user_id' => $user_id, 'password' => $password);
		} else {
			return array();
		}
		
	}
	
	public function internalLoginUser($user_id = null) {
		if($user_id) {
			$this -> User -> id = $user_id;
			if (!$this -> User -> exists()) {
				throw new NotFoundException(__('Usuario no válido'));
			}
			$user = $this -> User -> read(null, $user_id);
			if($this -> Auth -> login($user['User'])) {
				return true;
			} else {
				return false;
			}
		} else {
			// TODO : respuesta cuando no hay ID
		}
	}
	
	public function internalSendRegistrationData($user_id = null, $password = null) {
		$user = $this -> User -> read(null, $user_id);
		$email_address = Configure::read('email');
		$email_password = Configure::read('email_password');
		$site_name = Configure::read('site_name');
		$gmail = array(
			'host' => 'ssl://smtp.gmail.com',
			'port' => 465,
			'username' => $email_address,
			'password' => $email_password,
			'transport' => 'Smtp'
		);
		App::uses('CakeEmail', 'Network/Email');
		$email = new CakeEmail($gmail);
		$email -> from(array($email_address => $site_name));
		$email -> to($user['User']['email']);
		$email -> subject('Contraseña Generada :: ' . $site_name);
		$email -> send('La contraseña para su cuenta es :: ' . $password);
		$this -> sendRegistrationEmail($user);
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
					/* $clientRole = $this -> User -> Role -> find('first', array('order' => array('id' => 'DESC'), 'recursive' => -1));
					$this -> request -> data['User']['role_id'] = $clientRole['Role']['id']; */
					$user = array('User' => $this -> request -> data['User']); //debug($user);
					$address = array('UserAddress' => $this -> request -> data['UserAddress']); //debug($address);
					$this -> User -> create();
					if ($this -> User -> save($user)) {
					//if (User::save($user)) {
						$user = $this -> User -> read(null, $this -> User -> id);
						$user_id = $user['User']['id'];
						$user_alias = $user['User']['username'];
						$this -> User -> query("UPDATE `aros` SET `alias`='$user_alias' WHERE `model`='User' AND `foreign_key`=$user_id");
						
						$address['UserAddress']['user_id'] = $user_id;
						
						$this -> User -> UserAddress -> create();
						$this -> User -> UserAddress -> save($address);
						
						// Enviar el correo de registro
						$result = $this -> sendRegistrationEmail($this -> request -> data);
						if($result) {
							$this -> Session -> setFlash(__('Registro Exitoso. Se te ha enviado un correo a la dirección registrada.'), 'crud/success');
						} else {
							$this -> Session -> setFlash(__('Registro Exitoso.'), 'crud/success');
						}
						$this -> internalLoginUser($user['User']['id']);
						$this -> redirect(array('action' => 'profile'));
					} else {
						$this -> Session -> setFlash(__('Falló el registro. Verifique los datos e intente de nuevo.'), 'crud/error');
						//debug($this -> User -> validationErrors);
					}
				} else {
					// Asignar el error para llevar a la vista
					$this -> Session -> setFlash(__('Debes ingresar los datos correctos al captcha'), 'crud/error');
					$error = $resp -> error;
				}
			}
		}
		$this -> set('documentTypes', $this -> User -> DocumentType -> find('list', array('order' => array('id' => 'ASC'))));
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
			$this -> loadModel('MailingList');
			$user_mail_config = $this -> UserMailConfig -> read(null, 1);
			$mailing_list = $this -> MailingList -> findByScenario('Registro De Usuario');
			
			// Verificar si se está usando un servicio
			if($user_mail_config['UserMailConfig']['is_active']) {
				// Verificar el servicio que se esta usando
				switch($user_mail_config['UserMailConfig']['mail_service_id']) {
					// MailChimp
					case 1:
						return $this -> mailChimpRegistrationEmail(
							$user,
							$user_mail_config['UserMailConfig']['api_key'],
							$mailing_list['MailingList']['list_unique_code']
						);
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
	private function mailChimpRegistrationEmail($user = null, $api_key = null, $list_id = null) {
		if($user && $api_key) {
			$lib_path = APP . 'Plugin/UserControl/Lib/MailChimp/MCAPI.class.php';
			require_once($lib_path);
			$api = new MCAPI($api_key);
			
			$merge_vars = array(
				'FNAME' => $user['User']['name'],
				'LNAME' => $user['User']['lastname'],
				'EMAIL' => $user['User']['email']
			);
			
			return $api -> listSubscribe($list_id, $user['User']['email'], $merge_vars);
			
		} else {
			return false;
		}
	}
	
	/**
	 * Resetear contraseña de usuario
	 * 
	 * @return void
	 */
	public function resetPassword() {
		
		if($this -> request -> is('post') || $this -> request -> is('put')) {
			
			if(isset($this -> request -> data['User']['requestedEmail']) && !empty($this -> request -> data['User']['requestedEmail'])) {
				$this -> User -> recursive = -1;
				$test_user = $this -> User -> findByEmail($this -> request -> data['User']['requestedEmail']);
							
				if($test_user) {
					$password = $this -> generatePassword();
					$user = $this -> User -> read(null, $test_user['User']['id']);
					$user['User']['password'] = $password;
					$user['User']['verify_password'] = $password;
					if($this -> User -> save($user)) {
						$email_address = Configure::read('email');
						$email_password = Configure::read('email_password');
						$site_name = Configure::read('site_name');
						$gmail = array(
							'host' => 'ssl://smtp.gmail.com',
							'port' => 465,
							'username' => $email_address,
							'password' => $email_password,
							'transport' => 'Smtp'
						);
						App::uses('CakeEmail', 'Network/Email');
						$email = new CakeEmail($gmail);
						$email -> from(array($email_address => $site_name));
						$email -> to($user['User']['email']);
						$email -> subject('Renovación De Contraseña :: ' . $site_name);
						$email -> template('reset_password');
						$email -> emailFormat('html');
						$email -> viewVars(
							array(
								'user' => $user['User']['full_name'],
								'password' => $password
							)
						);
						$email -> send();
					}
				}
				
				$this -> Session -> setFlash('Si el correo ingresado está registrado proximamente le llegará un correo con su nueva contraseña');
			} else {
				$this -> Session -> setFlash('Debe ingresar un correo electrónico para utilizar esta función');
			}
			
		}

	}
	
	/**
	 * Generar una contraseña de manera automática
	 * 
	 * @return Una contraseña aleatoria
	 */
	private function generatePassword() {
		$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$cad = "";
		for ($i = 0; $i < 8; $i++) {
			$cad .= substr($str, rand(0, 62), 1);
		}
		return $cad;
	}

}
