## Description

Use phpunit with lithium projects


## Installation

~~~bash
cd app/
git clone https://github.com/buddylindsey/li3_phpunit.git libraries/li3_phpunit`
~~~

Add `Libraries::add('li3_phpunit');` to your `config/bootstrap/libraries.php`

## Usage

To run the tests do from the root of your application.

~~~bash
../libraries/lithium/console/li3 test --path=/path/to/tests
~~~

## Notes

### Lithium
This takes away using the lithium test runner and you are dependent upon PHPUnit now.

### Your Tests
All of your tests need to extend directly one of PHPUnits base test classes. One of the most common you will use is `PHPUnit_Framework_TestCase`.

Here is an example test testing that a route works.

~~~php
<?php 
use \lithium\net\http\Router;
use \PHPUnit_Framework_TestCase;

class TermsOfUseRouteTest extends PHPUnit_Framework_TestCase {
	public function testReverseUrlLookup(){
		$url = Router::match(array('controller' => 'TermsOfUse', 'action' => 'index'));
		$this->assertEquals('/terms-of-use', $url);
	}
}
?>
~~~
