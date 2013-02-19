<?php

namespace li3_phpunit\tests\mocks\models;

use stdClass;

class ResultsMock extends \li3_phpunit\models\Results {

	public static $staticResults = array();

	public static function find($type, array $options = array()) {
		static::$staticResults[] = array(
			'args' => compact('type', 'options'),
			'result' => false,
			'time' => microtime(true),
		);
		$foo = new stdClass;
		$foo->result = 'baz';
		return $foo;
	}

}

?>