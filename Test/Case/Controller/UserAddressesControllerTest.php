<?php
App::uses('UserAddressesController', 'UserControl.Controller');

/**
 * TestUserAddressesController *
 */
class TestUserAddressesController extends UserAddressesController {
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
 * UserAddressesController Test Case
 *
 */
class UserAddressesControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.user_address');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UserAddresses = new TestUserAddressesController();
		$this->UserAddresses->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UserAddresses);

		parent::tearDown();
	}

}
