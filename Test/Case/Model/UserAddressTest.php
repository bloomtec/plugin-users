<?php
App::uses('UserAddress', 'UserControl.Model');

/**
 * UserAddress Test Case
 *
 */
class UserAddressTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('plugin.user_control.user_address', 'app.user');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UserAddress = ClassRegistry::init('UserAddress');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UserAddress);

		parent::tearDown();
	}

}
