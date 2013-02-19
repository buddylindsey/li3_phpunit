<?php

namespace li3_phpunit\tests\cases\extensions\command;

use lithium\test\Mocker;
use li3_phpunit\extensions\command\Test;

class TestTest extends \lithium\test\Unit {

	public $shellResponse = null;

	public function setUp() {
		Mocker::register();
		$this->testee = new Test();
	}

	public function tearDown() {
		Mocker::overwriteFunction(false);
	}

	public function watchShellExec() {
		$shellResponse = null;
		$this->shellResponse =& $shellResponse;
		$fun = 'li3_phpunit\extensions\command\shell_exec';
		Mocker::overwriteFunction($fun, function($cmd) use(&$shellResponse) {
			$shellResponse = $cmd;
			return;
		});
	}

	public function testCallsPhpUnit() {
		$this->watchShellExec();
		$this->testee->run();

		$this->assertPattern('/^phpunit/', $this->shellResponse);
	}

	public function testSwitchesAfterPhpUnit() {
		$this->watchShellExec();

		$this->testee->switches = 'foobarbaz';
		$this->testee->run();

		$this->assertPattern('/^phpunit foobarbaz/', $this->shellResponse);
	}

	public function testRaw() {
		$this->watchShellExec();

		$this->testee->raw = 'foobarbaz';
		$this->testee->run();

		$this->assertPattern('/foobarbaz$/', $this->shellResponse);
	}

	public function testStandardOutputWithoutFile() {
		$this->watchShellExec();

		$this->testee->output = 'json';
		$this->testee->run();

		$this->assertPattern('/log\-json/', $this->shellResponse);
	}

	public function testStandardOutputWithFile() {
		$this->watchShellExec();

		$this->testee->output = 'junit';
		$this->testee->file = 'foo.xml';
		$this->testee->run();

		$this->assertPattern('/log\-junit/', $this->shellResponse);
		$this->assertPattern('/foo\.xml/', $this->shellResponse);
	}

	public function testNonStadardOutput() {
		$this->watchShellExec();

		$this->testee->output = 'foobaz';
		$this->testee->run();

		$this->assertNoPattern('/log/', $this->shellResponse);
	}

}

?>