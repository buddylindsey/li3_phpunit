<?php

namespace li3_phpunit\tests\cases\extensions\adapter\data\source\command;

use li3_phpunit\extensions\adapter\data\source\command\Phpunit;
use lithium\test\Mocker;

class PhpunitTest extends \lithium\test\Unit {

	public $shellResponse = null;

	public function setUp() {
		Mocker::register();
		$this->testee = new Phpunit();
	}

	public function tearDown() {
		Mocker::overwriteFunction(false);
	}

	public function watchShellExec() {
		$shellResponse = null;
		$this->shellResponse =& $shellResponse;
		$fun = 'li3_phpunit\extensions\adapter\data\source\command\shell_exec';
		Mocker::overwriteFunction($fun, function($cmd) use(&$shellResponse) {
			$shellResponse = $cmd;
			return;
		});
	}

	public function testCallsPhpUnit() {
		$this->watchShellExec();

		$this->testee->read(null);

		$this->assertPattern('/^phpunit/', $this->shellResponse);
	}

	public function testSwitchesAfterPhpUnit() {
		$this->watchShellExec();

		$this->testee->read(null, array(
			'conditions' => array(
				'switches' => 'foobarbaz',
			),
		));

		$this->assertPattern('/^phpunit foobarbaz/', $this->shellResponse);
	}

	public function testRaw() {
		$this->watchShellExec();

		$this->testee->read(null, array(
			'conditions' => array(
				'raw' => 'foobarbaz',
			),
		));

		$this->assertPattern('/foobarbaz$/', $this->shellResponse);
	}

	public function testStandardOutputWithoutFile() {
		$this->watchShellExec();

		$this->testee->read(null, array(
			'conditions' => array(
				'output' => 'json',
			),
		));

		$this->assertPattern('/log\-json/', $this->shellResponse);
		$this->assertPattern('/data\.json/', $this->shellResponse);
	}

	public function testStandardOutputWithFile() {
		$this->watchShellExec();

		$this->testee->read(null, array(
			'conditions' => array(
				'output' => 'junit',
				'outputFile' => 'foo.xml',
			),
		));

		$this->assertPattern('/log\-junit/', $this->shellResponse);
		$this->assertPattern('/foo\.xml/', $this->shellResponse);
	}

	public function testNonStadardOutput() {
		$this->watchShellExec();

		$this->testee->read(null, array(
			'conditions' => array(
				'output' => 'foobaz',
			),
		));

		$this->assertNoPattern('/log/', $this->shellResponse);
	}

}

?>