<?php
App::uses('UserControlAppModel', 'UserControl.Model');
App::uses('AuthComponent', 'Controller/Component');
/**
 * User Model
 *
 * @property Role $Role
 */
class User extends UserControlAppModel {
	
	public $actsAs = array('Acl' => array('type' => 'requester'));
	
	public $displayField = 'username';
	
	public $virtualFields = array(
		'full_name' => 'CONCAT(name, " ", lastname)'
	);
	
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'role_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'username' => array(
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'Ya existe ese nombre de usuario',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Ingrese un nombre de usuario',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'Ya existe ese correo electrónico',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'email' => array(
				'rule' => array('email'),
				'message' => 'Ingrese un correo electrónico',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'verify_email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Ingrese un correo electrónico',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'compareEmails' => array(
				'rule' => array('compareEmails'),
				'message' => 'Los correos electrónicos no son iguales',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Ingrese un nombre',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'lastname' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Ingrese un apellido',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Ingrese una contraseña',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'verify_password' => array(
			'comparePasswords' => array(
				'rule' => array('comparePasswords'),
				'message' => 'Las contraseñas no son iguales',
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
		),
	);
	
	public function compareEmails() {
		if(isset($this -> data['User']['email']) && isset($this -> data['User']['verify_email'])) {
			if($this -> data['User']['email'] == $this -> data['User']['verify_email']) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function comparePasswords() {
		if(isset($this -> data['User']['password']) && isset($this -> data['User']['verify_password'])) {
			if($this -> data['User']['password'] == $this -> data['User']['verify_password']) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function beforeSave() {
		if(!isset($this -> data['User']['role_id']) && isset($this -> data['User']['id'])) {
			$user = $this -> read(null, $this -> data['User']['id']);
			$this -> data['User']['role_id'] = $user['User']['role_id'];
		}
		if(isset($this -> data['User']['password']) && !empty($this -> data['User']['password'])) {
			$this -> data['User']['password'] = AuthComponent::password($this -> data['User']['password']);
			$this -> data['User']['verify_password'] = AuthComponent::password($this -> data['User']['verify_password']);
		}
	}

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Role' => array(
			'className' => 'UserControl.Role',
			'foreignKey' => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'DocumentType' => array(
			'className' => 'UserControl.DocumentType',
			'foreignKey' => 'document_type_id',
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
		'UserAddress' => array(
			'className' => 'UserControl.UserAddress',
			'foreignKey' => 'user_id',
			'dependent' => true,
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
	
	/**
	 * ACL method
	 */
	function parentNode() {
	    if (!$this -> id && empty($this -> data)) {
	        return null;
	    }
	    $data = $this -> data;
	    if (empty($data)) {
	        $data = $this -> read();
	    }
	    if (!$data['User']['role_id']) {
	        return null;
	    } else {
	        return array('Role' => array('id' => $data['User']['role_id']));
	    }
	}
	
}
