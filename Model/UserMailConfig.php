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
			'validarMailChimp' => array(
				'rule' => array('validarMailChimp'),
				'message' => 'Debe de haber ingresado una llave de API para usar MailChimp',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	
	public function validarMailChimp() {
		if($this -> data['UserMailConfig']['is_mailchimp_active'] && (!isset($this -> data['UserMailConfig']['mailchimp_api_key']) || empty($this -> data['UserMailConfig']['mailchimp_api_key']))) {
			return false;
		} else {
			return true;
		}
	}
	
}
