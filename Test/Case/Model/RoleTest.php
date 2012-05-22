<?php
App::uses('Role', 'UserControl.Model');

/**
 * Role Test Case
 *
 */
class RoleTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('plugin.user_control.role', 'app.user');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Role = ClassRegistry::init('Role');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Role);

		parent::tearDown();
	}

}
