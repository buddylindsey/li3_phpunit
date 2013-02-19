<?php

namespace li3_phpunit\tests\cases\extensions\command;

use li3_phpunit\extensions\command\Test;
use li3_phpunit\tests\mocks\models\ResultsMock;

class TestTest extends \lithium\test\Unit {

	public function testSendsCorrectConditions() {
		$this->run = new Test(array(
			'classes' => array(
				'results' => 'li3_phpunit\tests\mocks\models\ResultsMock',
			),
		));

		$this->run->raw = 'foo_raw';
		$this->run->dir = 'foo_dir';

		ob_start();
		$this->run->run();
		ob_clean();
		$results = ResultsMock::$staticResults[0]['args']['options']['conditions'];

		$this->assert(isset($results['raw']));
		$this->assert(isset($results['dir']));
		$this->assert(!isset($results['switches']));
		$this->assert(!isset($results['outputFile']));
	}

}

?>