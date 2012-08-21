<?php
App::uses('UserControlAppController', 'UserControl.Controller');
/**
 * UserAddresses Controller
 *
 */
class UserAddressesController extends UserControlAppController {

	/**
	 * Declarar aquí lo que debe suceder siempre que se acceda a usuarios
	 * 
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();		
		$this -> Auth -> allow('get');
	}
	public function get(){
		if (!$this -> Auth -> user('id')) {
			return false;
		}
		$this -> UserAddress -> recursive=-1;
		return $this -> UserAddress -> find('all',array(
			'conditions'=>array(
				'UserAddress.user_id'=>$this -> Auth -> user('id')
			)
		));
	}
	
	/**
	 * Agregar una dirección
	 * 
	 * @return void
	 */
	public function add() {
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
			$user_id = $this -> Auth -> user('id');
			if ($this -> request -> is('post') || $this -> request -> is('put')) {
				$this -> request -> data['UserAddress']['user_id'] = $user_id;
				if ($this -> UserAddress -> save($this -> request -> data)) {
					$this -> Session -> setFlash(__('Se ha modificado la dirección'), 'crud/success');
					$this -> redirect(array('action' => 'profile', 'controller' => 'users', 'plugin' => 'user_control'));
				} else {
					$this -> Session -> setFlash(__('No se pudo modificar la dirección. Por favor, intente de nuevo.'), 'crud/error');
				}
			}
		}
	}
	
	/**
	 * Modificar una dirección
	 * 
	 * @param int $id ID de la dirección
	 * @return void
	 */
	public function edit($id) {
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
			$this -> UserAddress -> id = $id;
			if (!$this -> UserAddress -> exists()) {
				throw new NotFoundException(__('Esta dirección no existe'));
			}
			$user_id = $this -> Auth -> user('id');
			if ($this -> request -> is('post') || $this -> request -> is('put')) {
				$this -> request -> data['UserAddress']['user_id'] = $user_id;
				if ($this -> UserAddress -> save($this -> request -> data)) {
					$this -> Session -> setFlash(__('Se ha modificado la dirección'), 'crud/success');
					$this -> redirect(array('action' => 'profile', 'controller' => 'users', 'plugin' => 'user_control'));
				} else {
					$this -> Session -> setFlash(__('No se pudo modificar la dirección. Por favor, intente de nuevo.'), 'crud/error');
				}
			} else {
				$this -> request -> data = $this -> UserAddress -> read(null, $id);
				if($this -> request -> data['UserAddress']['user_id'] != $user_id) {
					$this -> redirect(array('plugin' => 'user_control', 'controller' => 'users', 'action' => 'profile'));
				}
			}
		}
	}
	
	/**
	 * Eliminar una dirección
	 *
	 * @param int $id ID de la dirección
	 * @return void
	 */
	public function delete($id = null) {
		if (!$this -> request -> is('post')) {
			throw new MethodNotAllowedException();
		}
		$this -> UserAddress -> id = $id;
		if (!$this -> UserAddress -> exists()) {
			throw new NotFoundException(__('Esta dirección no existe'));
		}
		if ($this -> UserAddress -> delete()) {
			$this -> Session -> setFlash(__('Se eliminó la dirección.'), 'crud/success');
			$this -> redirect(array('action' => 'profile', 'controller' => 'users', 'plugin' => 'user_control'));
		}
		$this -> Session -> setFlash(__('No se pudo eliminar la dirección.'), 'crud/error');
		$this -> redirect(array('action' => 'profile', 'controller' => 'users', 'plugin' => 'user_control'));
	}

}
