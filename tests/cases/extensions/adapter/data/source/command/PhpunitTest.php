<?php

namespace li3_phpunit\tests\cases\extensions\adapter\data\source\command;

use li3_phpunit\extensions\adapter\data\source\command\Phpunit;
use lithium\test\Mocker;

class PhpunitTest extends \lithium\test\Unit {

	public $testName = 'li3_phpunit\extensions\command\test\Mock';

	public function setUp() {
		Mocker::register();
		$this->testee = new Phpunit(array(
			'classes' => array(
				'entity' => 'lithium\data\Entity',
				'set' => 'lithium\data\Collection',
				'relationship' => 'lithium\data\model\Relationship',
				'test' => $this->testName,
			),
		));
	}

	public function filterTestOutput($out) {
		$this->testee->applyFilter('read', function($self, $params, $chain) use($out) {
			$params['test']->applyFilter('run', function($self, $params, $chain) use($out) {
				echo $out;
			});
			return $chain->next($self, $params, $chain);
		});
	}

	public function testHasNoOutput() {
		$response = '{"event":"suiteStart","suite":"\/var\/www\/app\/libraries';
		$response .= '\/li3_phpunit\/extensions\/command\/..\/..\/..\/..\/","tests":0}';
		$this->filterTestOutput($response);

		ob_start();
		$this->testee->read(null);
		$buffer = ob_get_clean();

		$this->assertPattern('/^$/', $buffer);
	}

	public function testResponseIsArray() {
		$response = '{"event":"suiteStart","suite":"\/var\/www\/app\/libraries';
		$response .= '\/li3_phpunit\/extensions\/command\/..\/..\/..\/..\/","tests":0}';
		$this->filterTestOutput($response);

		$response = $this->testee->read(null);

		$this->assertInternalType('array', $response);
	}

}

?>