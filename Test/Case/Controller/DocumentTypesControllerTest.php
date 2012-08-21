<?php
App::uses('DocumentTypesController', 'UserControl.Controller');

/**
 * TestDocumentTypesController *
 */
class TestDocumentTypesController extends DocumentTypesController {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * DocumentTypesController Test Case
 *
 */
class DocumentTypesControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.document_type');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->DocumentTypes = new TestDocumentTypesController();
		$this->DocumentTypes->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DocumentTypes);

		parent::tearDown();
	}

}
