<?php
App::uses('UserControlAppModel', 'UserControl.Model');
/**
 * MailingList Model
 *
 * @property UserMailConfig $UserMailConfig
 * @property List $List
 */
class MailingList extends UserControlAppModel {
	
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'user_mail_config_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'list_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'UserMailConfig' => array(
			'className' => 'UserControl.UserMailConfig',
			'foreignKey' => 'user_mail_config_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
}
