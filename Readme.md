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
use \lithium\net\http\Router;
use \PHPUnit_Framework_TestCase;

class TermsOfUseRouteTest extends PHPUnit_Framework_TestCase {
	public function testReverseUrlLookup(){
		$url = Router::match(array('controller' => 'TermsOfUse', 'action' => 'index'));
		$this->assertEquals('/terms-of-use', $url);
	}
}
~~~

### Logging and Output
You can get output in several different formats which are built into phpunit right now we support `json`, `junit`. Just add `--output=<type>` to the command. This will right out to a file of `data.xml` or `data.json`.

~~~bash
li3 test --path=/path/to/tests --output=json
li3 test --path=/path/to/tests --output=junit
~~~

### Web-based Output
NOTE: This works, but is in rough condition. Its visual design is like a programmer designed it.

If you are used to lihtium's web based output we have that too, with our twist. All you need to do is add/replace test routes with what is below.

~~~php
Router::connect('/test/{:args}', array('controller' => 'li3_phpunit\controllers\ReportController'));                                                 
Router::connect('/test', array('controller' => 'li3_phpunit\controllers\ReportController')); 
~~~
