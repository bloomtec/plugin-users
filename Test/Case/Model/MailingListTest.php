<?php
App::uses('MailingList', 'UserControl.Model');

/**
 * MailingList Test Case
 *
 */
class MailingListTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('plugin.user_control.mailing_list', 'app.user_mail_config', 'app.list');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MailingList = ClassRegistry::init('MailingList');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MailingList);

		parent::tearDown();
	}

}
