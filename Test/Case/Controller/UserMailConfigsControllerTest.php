<?php
App::uses('UserMailConfigsController', 'UserControl.Controller');

/**
 * TestUserMailConfigsController *
 */
class TestUserMailConfigsController extends UserMailConfigsController {
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
 * UserMailConfigsController Test Case
 *
 */
class UserMailConfigsControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.user_mail_config');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UserMailConfigs = new TestUserMailConfigsController();
		$this->UserMailConfigs->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UserMailConfigs);

		parent::tearDown();
	}

}
