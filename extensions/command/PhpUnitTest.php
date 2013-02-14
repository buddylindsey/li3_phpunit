<?php

namespace li3_phpunit\extensions\command;

require_once 'PHPUnit/Autoload.php';

use \lithium\console\Command;
use \PHPUnit_Framework_TestSuite;
use \PHPUnit_TextUI_TestRunner;

use \app\tests\functional\routes\TermsOfUseRouteTest;

class PhpUnitTest extends Command {
	public function run() {

		$suite = new PHPUnit_Framework_TestSuite('MyTest');

		PHPUnit_TextUI_TestRunner::run($suite);
	}
}