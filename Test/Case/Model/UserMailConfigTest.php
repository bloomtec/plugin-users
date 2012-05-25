<?php
App::uses('UserMailConfig', 'UserControl.Model');

/**
 * UserMailConfig Test Case
 *
 */
class UserMailConfigTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('plugin.user_control.user_mail_config', 'app.mail_service', 'app.mailing_list');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UserMailConfig = ClassRegistry::init('UserMailConfig');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UserMailConfig);

		parent::tearDown();
	}

}
