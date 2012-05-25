<?php
/*DbAcl schema generated on: 2007-11-24 15:11:13 : 1195945453*/

/**
 * This is Acl Schema file
 *
 * Use it to configure database for ACL
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config.Schema
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/*
 *
 * Using the Schema command line utility
 * cake schema run create DbAcl
 *
 */
class DbUsersSchema extends CakeSchema {

	public $name = 'DbAcl';

	public function before($event = array()) {
		$db = ConnectionManager::getDataSource($this->connection);
		$db -> cacheSources = false;
		return true;
	}

	public function after($event = array()) {
		if (isset($event['create'])) {
	        switch ($event['create']) {
	        	case 'mail_services':
					$MailService = ClassRegistry::init('MailService');
					$MailService -> create();
	                $MailService -> save(
	                    array('MailService' =>
	                        array(
	                        	'name' => 'MailChimp'
							)
	                    )
	                );
	                break;
	        	case 'mailing_lists':
					$UserMailConfig = ClassRegistry::init('UserMailConfig');
					$mail_configs = $UserMailConfig -> find('all');
	                $MailingList = ClassRegistry::init('MailingList');
					foreach($mail_configs as $mail_config) {
						for ($i=0; $i < 5; $i++) { 
							$MailingList -> create();
			                $MailingList -> save(
			                    array('MailingList' =>
			                        array(
			                        	'user_mail_config_id' => $mail_config['UserMailConfig']['id'],
			                        	'list_name' => '',
			                        	'list_id' => ''
									)
			                    )
			                );
						}	
					}
	                break;
	        	case 'user_mail_configs':
					$MailService = ClassRegistry::init('MailService');
	                $UserMailConfig = ClassRegistry::init('UserMailConfig');
					$mail_services = $MailService -> find('all');
					foreach ($mail_services as $key => $mail_service) {
						$UserMailConfig -> create();
		                $UserMailConfig -> save(
		                    array('UserMailConfig' =>
		                        array(
		                        	'mail_service_id' => $mail_service['MailService']['id']
								)
		                    )
		                );
					}
	                break;
	        	/*case 'users':
	                $User = ClassRegistry::init('User');
	                $User -> create();
	                $User -> save(
	                    array('User' =>
	                        array(
	                        	'role_id' => 1,
	                        	'username' => 'admin',
	                        	'email' => 'admin@bloomweb.co',
	                        	'name' => 'app',
	                        	'lastname' => 'admin',
	                        	'password' => 'admin'
							)
	                    )
	                );
	                break;*/
	            case 'roles':
	                $Role = ClassRegistry::init('Role');
	                $Role -> create();
	                $Role -> save(
	                    array('Role' =>
	                        array('role' => 'Administrador')
	                    )
	                );
					$Role -> create();
	                $Role -> save(
	                    array('Role' =>
	                        array('role' => 'Supervisor')
	                    )
	                );
					$Role -> create();
	                $Role -> save(
	                    array('Role' =>
	                        array('role' => 'Cliente')
	                    )
	                );
	                break;
				case 'aros_acos':
					$this -> initAcl();
					break;
				default:
					break;
	        }
	    }
	}

	private function initAcl() {			
		$path = APP . 'Console/cake -app ' . APP . ' AclExtras.AclExtras aco_sync';
		exec($path);
		
		/**
		 * Inicializar modelos requeridos
		 */
		 
		App::uses('User', 'UserControl.Model');
		App::uses('Role', 'UserControl.Model');
		
		$this -> User =& new User();
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
		
		/**
		 * Agregar Aro's
		 */
		$Aro = ClassRegistry::init('Aro');
		$Role =& ClassRegistry::init('Role');
		$db_roles = $Role -> find('all');
		
		$roles = array();
		foreach ($db_roles as $key => $role) {
			$roles[$key] = array(
				'foreign_key' => $role['Role']['id'],
				'model' => 'Role',
				'alias' => $role['Role']['role']
			);
		}

		// Iterate and create ARO groups
		foreach ($roles as $data) {
			$Aro -> create();
			$Aro -> save($data);
		}

		/**
		 * Crear el usuario admin
		 */

		// Administrador
		$this -> User -> create();
		$usuario = array(
			'User' => array(
				'username' => 'admin',
				'email' => 'admin@bloomweb.co',
				'verify_email' => 'admin@bloomweb.co',
				'password' => 'admin',
				'verify_password' => 'admin',
				'name' => 'app',
				'lastname' => 'admin',
				'role_id' => 1
			)
		);
		
		$pedirInput = true;
		
		do {
			fwrite(STDOUT, "\n¿Usar email como username?\n[n] > "); // Output - prompt user
			$answer = fgets(STDIN);
			$answer = trim($answer);
			$answer = strtolower($answer);
			if(strlen($answer) == 0) {
				$pedirInput = false;
			} elseif($answer == 'y' || $answer == 'n') {
				$pedirInput = false;
			}
		} while((bool) $pedirInput);
		
		if($answer == 'y') { $usuario['User']['username'] = $usuario['User']['email']; }
		
		$this -> User -> save($usuario);
		
		// tratando de arreglar lo del alias en la tabla aros
		$id_usuario = $this -> User -> id;
		$alias_usuario = $usuario['User']['username'];
		$this -> User -> query("UPDATE `aros` SET `alias`='$alias_usuario' WHERE `model`='User' AND `foreign_key`=$id_usuario");
		
		// Se permite acceso total a los administradores y se le niega totalmente a los demás
		foreach ($db_roles as $key => $role) {
			$path = null;
			$alias = $role['Role']['role'];
			if($role['Role']['id'] == 1) {
				$path = APP . 'Console/cake -app ' . APP . " acl grant $alias controllers";
			} else {
				$path = APP . 'Console/cake -app ' . APP . " acl deny $alias controllers";
			}
			exec($path);
		}
		/*foreach($roles as $data) {
			$path = null;
			$alias = $data['alias']; 
			if($alias == 'administrator') {
				//$this -> Acl -> allow($data['alias'], 'controllers');
				$path = APP . 'Console/cake -app ' . APP . " acl grant $alias controllers";
			} else {
				//$this -> Acl -> deny($data['alias'], 'controllers');
				$path = APP . 'Console/cake -app ' . APP . " acl deny $alias controllers";
			}
			exec($path);
		}*/
	}
	
	public $roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'role' => array('type' => 'string', 'null' => false, 'length' => 20, 'key' => 'index'),
		'description' => array('type'=>'text', 'null' => true),
		'created' => array('type'=>'datetime', 'null' => true),
		'updated' => array('type'=>'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'roles' => array('column' => 'role')
		)
	);
	
	public $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'role_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'username' => array('type' => 'string', 'null' => false, 'length' => 100, 'key' => 'index'),
		'email' => array('type' => 'string', 'null' => false, 'length' => 100, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 20, 'key' => 'index'),
		'lastname' => array('type' => 'string', 'null' => false, 'length' => 20, 'key' => 'index'),
		'password' => array('type' => 'string', 'null' => false, 'length' => 40),
		'is_active' => array('type' => 'boolean', 'null' => false, 'length' => 1, 'default' => 1, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true),
		'updated' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'usernames' => array('column' => 'username'),
			'emails' => array('column' => 'email'),
			'names' => array('column' => 'name'),
			'lastnames' => array('column' => 'lastname'),
			'actives' => array('column' => 'is_active'),
		)
	);

	public $acos = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'model' => array('type' => 'string', 'null' => true),
		'foreign_key' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'alias' => array('type' => 'string', 'null' => true),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	public $aros = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'model' => array('type' => 'string', 'null' => true),
		'foreign_key' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'alias' => array('type' => 'string', 'null' => true),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	public $aros_acos = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'aro_id' => array('type' => 'integer', 'null' => false, 'length' => 10, 'key' => 'index'),
		'aco_id' => array('type' => 'integer', 'null' => false, 'length' => 10),
		'_create' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2),
		'_read' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2),
		'_update' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2),
		'_delete' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'ARO_ACO_KEY' => array('column' => array('aro_id', 'aco_id'), 'unique' => 1))
	);
	
	public $mail_services = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true),
		'updated' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'names' => array('column' => 'name')
		)
	);
	
	public $user_mail_configs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'mail_service_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'api_key' => array('type' => 'string', 'default' => NULL, 'length' => 100),
		'is_active' => array('type' => 'boolean', 'null' => false, 'length' => 1, 'default' => 0),
		'created' => array('type' => 'datetime', 'null' => true),
		'updated' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'mail_services' => array('column' => 'mail_service_id')
		)
	);
	
	public $mailing_lists = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'user_mail_config_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'list_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'key' => 'index'),
		'list_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true),
		'updated' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_mail_configs' => array('column' => 'user_mail_config_id'),
			'lists' => array('column' => 'list_name'),
			'list_ids' => array('column' => 'list_id'),
		)
	);

}