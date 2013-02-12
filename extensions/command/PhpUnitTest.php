<?php

namespace li3_phpunit\extensions\command;

$app_root = __DIR__."/../../../../";

require_once $app_root . "tests/functional/routes/TermsOfUseRouteTest.php";

include $app_root . "../libraries/lithium/core/Libraries.php";

use \li3_phpunit\app\SimpleTestListener;

\lithium\core\Libraries::add('lithium');
\lithium\core\Libraries::add('app', array( 'path' => $app_root ));


class PhpUnitTest extends \lithium\console\Command {
	public function run() {

		$suite = new PHPUnit_Framework_TestSuite('TermsOfUseRouteTest');
		$result = new PHPUnit_Framework_TestResult;
		$result->addListener(new SimpleTestListener);
		
		$suite->run($result);

	}
}