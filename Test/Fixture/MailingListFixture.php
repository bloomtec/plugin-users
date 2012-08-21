<?php
/**
 * MailingListFixture
 *
 */
class MailingListFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'user_mail_config_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'list_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'list_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'user_mail_configs' => array('column' => 'user_mail_config_id', 'unique' => 0), 'lists' => array('column' => 'list_name', 'unique' => 0), 'list_ids' => array('column' => 'list_id', 'unique' => 0)),
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
			'user_mail_config_id' => 1,
			'list_name' => 'Lorem ipsum dolor sit amet',
			'list_id' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-05-24 00:44:15',
			'updated' => '2012-05-24 00:44:15'
		),
	);
}
