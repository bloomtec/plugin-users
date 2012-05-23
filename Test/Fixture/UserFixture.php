<?php
/**
 * UserFixture
 *
 */
class UserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'role_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'username' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'lastname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'usernames' => array('column' => 'username', 'unique' => 0), 'emails' => array('column' => 'email', 'unique' => 0), 'names' => array('column' => 'name', 'unique' => 0), 'lastnames' => array('column' => 'lastname', 'unique' => 0), 'actives' => array('column' => 'is_active', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'role_id' => 1,
			'username' => 'Lorem ipsum dolor ',
			'email' => 'Lorem ipsum dolor sit amet',
			'name' => 'Lorem ipsum dolor ',
			'lastname' => 'Lorem ipsum dolor ',
			'password' => 'Lorem ipsum dolor sit amet',
			'is_active' => 1,
			'created' => '2012-05-23 15:55:10',
			'updated' => '2012-05-23 15:55:10'
		),
	);
}
