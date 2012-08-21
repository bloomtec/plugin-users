<?php
App::uses('UserControlAppModel', 'UserControl.Model');
/**
 * UserMailConfig Model
 *
 * @property MailService $MailService
 * @property MailingList $MailingList
 */
class UserMailConfig extends UserControlAppModel {
	
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'mail_service_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'api_key' => array(
			'validarAPIKey' => array(
				'rule' => array('validarAPIKey'),
				'message' => 'La llave ingresada para usar el servicio no parece ser válida. Verifique e intente de nuevo.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_active' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'validarActivarServicio' => array(
				'rule' => array('validarActivarServicio'),
				'message' => 'Debe de haber ingresado una llave de API para usar el servicio',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	
	public function validarAPIKey() {
		if(isset($this -> data['UserMailConfig']['api_key']) && !empty($this -> data['UserMailConfig']['api_key'])) {
			$api_key = $this -> data['UserMailConfig']['api_key'];
			
			// Verificar la llave acorde el servicio
			switch($this -> data['UserMailConfig']['mail_service_id']) {
				
				// Caso para mailchimp
				case 1:
					$lib_path = APP . 'Plugin/UserControl/Lib/MailChimp/MCAPI.class.php';
					require_once($lib_path);
					$api = new MCAPI($api_key);
					$api_key_test = $api -> ping();
					if($api_key_test == "Everything's Chimpy!") {
						return true;
					} else {
						return false;
					}
					break;
					
				// En caso que no se ingrese un valor de servicios implementados
				default:
					return false;
					break;
			}
		} else {
			return true;
		}
	}
	
	public function validarActivarServicio() {
		if($this -> data['UserMailConfig']['is_active'] && (!isset($this -> data['UserMailConfig']['api_key']) || empty($this -> data['UserMailConfig']['api_key']))) {
			return false;
		} else {
			return true;
		}
	}

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'MailService' => array(
			'className' => 'UserControl.MailService',
			'foreignKey' => 'mail_service_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'MailingList' => array(
			'className' => 'UserControl.MailingList',
			'foreignKey' => 'user_mail_config_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
