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
	        	case 'user_mail_configs':
	                $user_mail_config = ClassRegistry::init('UserMailConfig');
	                $user_mail_config -> create();
	                $user_mail_config -> save(
	                    array('User' =>
	                        array(
	                        	
							)
	                    )
	                );
	                break;
	        	case 'users':
	                $user = ClassRegistry::init('User');
	                $user -> create();
	                $user -> save(
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
	                break;
	            case 'roles':
	                $role = ClassRegistry::init('Role');
	                $role -> create();
	                $role -> save(
	                    array('Role' =>
	                        array('role' => 'admin')
	                    )
	                );
					$role -> create();
	                $role -> save(
	                    array('Role' =>
	                        array('role' => 'supervisor')
	                    )
	                );
					$role -> create();
	                $role -> save(
	                    array('Role' =>
	                        array('role' => 'assistant')
	                    )
	                );
					$role -> create();
	                $role -> save(
	                    array('Role' =>
	                        array('role' => 'client')
	                    )
	                );
	                break;
				default:
					break;
	        }
	    }
	}

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
		'username' => array('type' => 'string', 'null' => false, 'length' => 20, 'key' => 'index'),
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
	
	public $user_mail_configs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'mailchimp_api_key' => array('type' => 'string', 'default' => NULL, 'length' => 36),
		'is_mailchimp_active' => array('type' => 'boolean', 'null' => false, 'length' => 1, 'default' => 0),
		'created' => array('type' => 'datetime', 'null' => true),
		'updated' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		)
	);

}