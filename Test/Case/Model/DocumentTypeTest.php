<?php
App::uses('DocumentType', 'UserControl.Model');

/**
 * DocumentType Test Case
 *
 */
class DocumentTypeTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('plugin.user_control.document_type', 'app.user');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->DocumentType = ClassRegistry::init('DocumentType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DocumentType);

		parent::tearDown();
	}

}
