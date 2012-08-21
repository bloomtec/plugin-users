<?php
App::uses('UserControlAppController', 'UserControl.Controller');
/**
 * UserMailConfigs Controller
 *
 */
class UserMailConfigsController extends UserControlAppController {

	/**
	 * Cambiar la configuración de aplicaciones web para envío de correos
	 *
	 * @return void
	 */
	public function admin_edit() {
		$this -> UserMailConfig -> id = 1;
		if (!$this -> UserMailConfig -> exists()) {
			throw new NotFoundException(__('Error en la configuración de aplicaciones de envío de correos'));
		}
		if ($this -> request -> is('post') || $this -> request -> is('put')) {
			if ($this -> UserMailConfig -> saveAll($this -> request -> data)) {
				$this -> Session -> setFlash(__('Se guardaron los cambios en la configuración'));
			} else {
				$this -> Session -> setFlash(__('Error al tratar de guardar la configuración. Verifique los campos e intente de nuevo.'));
			}
		}
		$this -> request -> data = $this -> UserMailConfig -> read(null, 1);
		$this -> set('mailServices', $this -> UserMailConfig -> MailService -> find('list'));
	}

}
