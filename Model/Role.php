<?php
App::uses('UserControlAppModel', 'UserControl.Model');
/**
 * Role Model
 *
 * @property User $User
 */
class Role extends UserControlAppModel {
	
	//public $actsAs = array('Acl' => array('type' => 'requester'), 'Ez.Auditable');
	public $actsAs = array('Acl' => array('type' => 'requester'));
	
	public $displayField = 'role';
	
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'role' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Ingrese un nombre',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'El nombre ingresado ya existe',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	 */	
	public $hasMany = array(
		'User' => array(
			'className' => 'UserControl.User',
			'foreignKey' => 'role_id',
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
	
	/**
	 * ACL method
	 */
	public function parentNode() {
		return null;
	}

}
