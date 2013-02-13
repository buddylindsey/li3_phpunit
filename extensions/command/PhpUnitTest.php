<?php

namespace li3_phpunit\extensions\command;

require_once 'PHPUnit/Autoload.php';

$app_root = __DIR__."/../../../../";

require_once $app_root . "tests/functional/routes/TermsOfUseRouteTest.php";

use \PHPUnit_Framework_TestSuite;
use \PHPUnit_Framework_TestResult;


class PhpUnitTest extends \lithium\console\Command {
	public function run() {

		$suite = new PHPUnit_Framework_TestSuite('TermsOfUseRouteTest');
		
		\PHPUnit_TextUI_TestRunner::run($suite);
	}
}