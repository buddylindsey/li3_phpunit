<?php

namespace li3_phpunit\tests\integration\models;

use li3_phpunit\extensions\adapter\data\source\command\Phpunit;
use li3_phpunit\models\Results;
use lithium\test\Mocker;

class ResultsTest extends \lithium\test\Unit {

	public function tearDown() {
		Mocker::overwriteFunction(false);
	}

	public function overwriteShell($output) {
		$fun = 'li3_phpunit\extensions\adapter\data\source\command\shell_exec';
		Mocker::overwriteFunction($fun, function($cmd) use($output) {
			return $output;
		});
	}

	public function testInstanceOfDocument() {
		$this->overwriteShell(json_encode(array(
			'event' => 'suiteStart',
			'suite' => '/vagrant/app/libraries/li3_phpunit/tests',
			'tests' => 0,
		)));
		$results = Results::find('all', array(
			'conditions' => array(
				'output'     => 'json',
				'switches'   => '--stderr',
				'outputFile' => 'php://stdout',
				'raw'        => '2>/dev/null',
			),
		));

		$this->assertInstanceOf('lithium\data\entity\Document', $results);
	}

	public function testReturnCorrectData() {
		$this->overwriteShell(json_encode(array(
			'event' => 'suiteStart',
			'suite' => '/vagrant/app/libraries/li3_phpunit/tests',
			'tests' => 0,
		)));
		$results = Results::find('all', array(
			'conditions' => array(
				'output'     => 'json',
				'switches'   => '--stderr',
				'outputFile' => 'php://stdout',
				'raw'        => '2>/dev/null',
			),
		));

		$this->assertIdentical('suiteStart', $results->event);
		$this->assertIdentical('/vagrant/app/libraries/li3_phpunit/tests', $results->suite);
		$this->assertIdentical(0, $results->tests);
	}

	public function testStringOutput() {
		$output = 'PHPUnit 3.7.13 by Sebastian Bergmann.';
		$this->overwriteShell($output);
		$results = Results::find('all', array(
			'conditions' => array(
				'output'     => 'json',
				'switches'   => '--stderr',
				'outputFile' => 'php://stdout',
				'raw'        => '2>/dev/null',
			),
		));

		$this->assertIdentical($output, $results->result);
	}

}

?>