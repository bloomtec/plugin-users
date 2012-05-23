<?php
App::uses('UserControlAppController', 'UserControl.Controller');
/**
 * Users Controller
 *
 */
class UsersController extends UserControlAppController {

	public function beforeFilter() {
		parent::beforeFilter();
		$this -> Auth -> allow('inicializarAcl', 'register');
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
		$user = $this -> User -> read(null, 1);
		debug($user);
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
	 * login method
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
	 * logout method
	 *
	 * @return void
	 */
	public function logout() {
		$this -> redirect($this -> Auth -> logout());
	}
	
	/**
	 * Registro de usuario
	 */
	public function register() {
		if ($this -> request -> is('post')) {
			$this -> request -> data['User']['role_id'] = 4;
			$this -> User -> create();
			if ($this -> User -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('Registro Exitoso'));
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('Falló el registro. Verifique los datos e intente de nuevo.'));
			}
		}
	}
	
	/**
	 * Enviar correo de confirmación de registro
	 */
	public function sendRegistrationEmail() {
		
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
	
	/**
	 * initAcl method
	 *
	 * @return void
	 */
	public function inicializarAcl() {
		$this -> autoRender = false;

		/**
		 * Limpiar las tablas
		 */

		// Limpiar ARO's vs ACO's
			$this -> User -> query('TRUNCATE TABLE aros_acos;');
		// Limpiar ARO's
			$this -> User -> query('TRUNCATE TABLE aros;');
		// Limpiar ACO's
			$this -> User -> query('TRUNCATE TABLE acos;');
		// Limpiar Usuarios
			$this -> User -> query('TRUNCATE TABLE users;');
			
		$path = APP . 'Console/cake -app ' . APP . ' AclExtras.AclExtras aco_sync';
		exec($path);

		/**
		 * Agregar Aro's
		 */
		$aro = &$this -> Acl -> Aro;

		// Here's all of our group info in an array we can iterate through
		$roles = array(
			0 => array(
				'foreign_key' => 1,
				'model' => 'Role',
				'alias' => 'admin'
			),
			1 => array(
				'foreign_key' => 2,
				'model' => 'Role',
				'alias' => 'supervisor'
			),
			2 => array(
				'foreign_key' => 3,
				'model' => 'Role',
				'alias' => 'assistant'
			),
			3 => array(
				'foreign_key' => 4,
				'model' => 'Role',
				'alias' => 'client'
			)
		);

		// Iterate and create ARO groups
		foreach ($roles as $data) {
			// Remember to call create() when saving in loops...
			$aro -> create();

			// Save data
			$aro -> save($data);
		}

		/**
		 * Usuarios
		 */

		// Administrador
		$this -> User -> create();
		$usuario = array();
		$usuario['User']['username'] = 'admin';
		$usuario['User']['email'] = 'admin@bloomweb.co';
		$usuario['User']['password'] = 'admin';
		$usuario['User']['name'] = 'app';
		$usuario['User']['lastname'] = 'admin';
		$usuario['User']['role_id'] = 1;
		$this -> User -> save($usuario);
		
		// tratando de arreglar lo del alias en la tabla aros
		$id_usuario = $this -> User -> id;
		$alias_usuario = $usuario['User']['username'];
		$this -> User -> query("UPDATE `aros` SET `alias`='$alias_usuario' WHERE `model`='User' AND `foreign_key`=$id_usuario");
		
		// Se permite acceso total a los administradores
		$this -> Acl -> allow('admin', 'controllers');

		// Se le niega totalmente el acceso a los operadores e inspectores de manera inicial
		$this -> Acl -> deny('supervisor', 'controllers');
		$this -> Acl -> deny('assistant', 'controllers');
		$this -> Acl -> deny('client', 'controllers');
		
		/**
		 * Finished
		 */
		echo 'Usuario Administrativo Y Permisos Inicializados';
		exit ;
	}

}
