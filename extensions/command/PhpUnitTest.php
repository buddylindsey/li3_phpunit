<?php

namespace li3_phpunit\extensions\command;

require_once 'PHPUnit/Autoload.php';

use app\tests\functional\routes\TermsOfUseRouteTest;
use \PHPUnit_Framework_TestSuite;

class PhpUnitTest extends \lithium\console\Command {
	public function run() {

		$suite = new PHPUnit_Framework_TestSuite('TermsOfUseRouteTest');

		\PHPUnit_TextUI_TestRunner::run($suite);
	}
}