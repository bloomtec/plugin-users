<?php

class UserControlAppController extends AppController {
	
	/**
	 * Declarar aquí lo que debe suceder siempre que se acceda a usuarios
	 * 
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();
		
		// Verificación ACL
		$this -> aclVerification();
	}
	
	/**
	 * Vericar el acceso de un usuario a una función mediante ACL
	 * 
	 * @param string $username El nombre de usuario
	 * @param string $controlador Nombre del controlador; i.e.: Users
	 * @param string $accion Nombre de la función
	 * @return true o false acorde si hay o no acceso 
	 */
	protected function verifyUserAccess($username, $controlador = null, $accion = null) {
		if(!$controlador || !$accion) {
			// Armar la ruta
			$ruta = '';
			for ($i = 0; $i < count($this -> params['ruta']); $i++) {
				$ruta .= $this -> params['ruta'][$i];
				if ($i != count($this -> params['ruta']) - 1) {
					$ruta .= '/';
				}
			}
			return $this -> Acl -> check($username, $ruta);
		} elseif(!$accion) {
			return $this -> Acl -> check($username, $controlador);
		} else {
			return $this -> Acl -> check($username, $controlador . '/' . $accion);
		}
	}
	
	/**
	 * Cuadrar accesos mediante ACL
	 * 
	 * @return void
	 */
	protected function aclVerification() {
		$this -> loadModel('Role');
		$roles = $this -> Role -> find('all');
		foreach ($roles as $key => $role) {
			if($role['Role']['role'] != 'Administrador') {
					
				// Permitir acceso total en ciertos controladores inicialmente si no se es admin
				$this -> Acl -> allow($role['Role']['role'], $this -> name);
				
				// Negar acceso a los siguientes métodos administrativos
				foreach($this -> methods as $key => $method) {
					if((!strstr($method, 'admin_')) && (!strstr($method, 'aclVerification'))  && (!strstr($method, 'verifyUserAccess'))) {
						if(!$this -> Acl -> check($role['Role']['role'], $this -> name . '/' . $method)) {
							$this -> Acl -> deny($role['Role']['role'], $this -> name . '/' . $method);
						}
					} elseif(strstr($method, 'admin_')) {
						if($this -> Acl -> check($role['Role']['role'], $this -> name . '/' . $method)) {
							$this -> Acl -> deny($role['Role']['role'], $this -> name . '/' . $method);
						}
					}
				}
				
			}
		}
	}
	
}

