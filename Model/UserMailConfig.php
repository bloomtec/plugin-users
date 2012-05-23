<?php
App::uses('UserControlAppModel', 'UserControl.Model');
/**
 * UserMailConfig Model
 *
 */
class UserMailConfig extends UserControlAppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'is_mailchimp_active' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
