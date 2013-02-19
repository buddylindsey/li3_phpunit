<?php

namespace li3_phpunit\extensions\adapter\data\source\command;

class Phpunit extends \lithium\data\source\Mock {

	/**
	 * Default entity and set classes used by subclasses of `Source`.
	 *
	 * @var array
	 */
	protected $_classes = array(
		'entity' => 'lithium\data\Entity',
		'set' => 'lithium\data\Collection',
		'relationship' => 'lithium\data\model\Relationship',
		'test' => 'li3_phpunit\extensions\command\Test',
	);

	/**
	 * The list of object properties to be automatically assigned from configuration passed to
	 * `__construct()`.
	 *
	 * @var array
	 */
	protected $_autoConfig = array('classes' => 'merge');

	/**
	 * Abstract. Must be defined by child classes.
	 *
	 * @param mixed $query
	 * @param array $options
	 * @return boolean Returns true if the operation was a success, otherwise false.
	 */
	public function read($query, array $options = array()) {
		$test = new $this->_classes['test'];
		$params = compact('query', 'options', 'test');
		return $this->_filter(__METHOD__, $params, function($self, $params) {
			$params['test']->output = "json";
			$params['test']->file = "php://stdout";
			$params['test']->switches = "--stderr";
			$params['test']->raw = "2>/dev/null";

			ob_start();
			$params['test']->run();
			return json_decode(ob_get_clean(), true);
		});
	}

}

?>