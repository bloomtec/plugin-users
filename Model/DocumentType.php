<?php
App::uses('UserControlAppModel', 'UserControl.Model');
/**
 * DocumentType Model
 *
 * @property User $User
 */
class DocumentType extends UserControlAppModel {
	
	public $displayField = 'document_type';
	
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'document_type' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
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
			'foreignKey' => 'document_type_id',
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
