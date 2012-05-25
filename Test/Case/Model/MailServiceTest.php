<?php
App::uses('MailService', 'UserControl.Model');

/**
 * MailService Test Case
 *
 */
class MailServiceTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('plugin.user_control.mail_service', 'app.user_mail_config');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MailService = ClassRegistry::init('MailService');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MailService);

		parent::tearDown();
	}

}
