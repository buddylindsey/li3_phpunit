<?php

namespace li3_phpunit\extensions\command;

class Test extends \lithium\console\Command {

	/**
	 * Dependencies.
	 *
	 * @param array
	 */
	protected $_classes = array(
		'results' => 'li3_phpunit\models\Results',
		'response' => 'lithium\console\Response',
	);

	/**
	 * Items we wish to automerge.
	 *
	 * @param array
	 */
	protected $_autoConfig = array('classes' => 'merge');

	/**
	 * If set, these items will automatically be set as conditions.
	 *
	 * @param array
	 */
	public $autoConfigConditions = array(
		'raw', 'switches', 'dir', 'configure',
		'path', 'output', 'outputFile',
	);

	/**
	 * Will create and run a command to execute the phpunit tests.
	 *
	 * @return void
	 */
	public function run($path = null) {
		$conditions = array(
			'configure' => __DIR__ . '/../../test/_phpunit.xml',
			'path' => getcwd() . '/' . $path,
		);
		foreach ($this->autoConfigConditions as $item) {
			if (!empty($this->$item)) {
				$conditions[$item] = $this->$item;
			}
		}
		$resultsClass = $this->_classes['results'];
		$results = $resultsClass::find('all', array(
			'conditions' => $conditions,
		));
		echo $results->result;
	}

}

?>