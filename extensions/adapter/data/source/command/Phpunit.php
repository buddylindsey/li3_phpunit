<?php

namespace li3_phpunit\extensions\adapter\data\source\command;

use lithium\util\String;

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
	 * Command templates
	 */
	public $templates = array(
		'read' => 'phpunit {:switches} -c {:configure} {:output} {:path} {:raw}',
	);

	/**
	 * List of available output formats
	 *
	 * @param array
	 */
	public $outputFormats = array(
		'json' => '--log-json {:outputFile}',
		'junit' => '--log-junit {:outputFile}',
		'default' => '',
	);

	/**
	 * List of available output file formats
	 *
	 * @param array
	 */
	public $outputFile = array(
		'json' => 'data.json',
		'junit' => 'data.xml',
	);

	/**
	 * Abstract. Must be defined by child classes.
	 *
	 * @param mixed $query
	 * @param array $options
	 * @return boolean Returns true if the operation was a success, otherwise false.
	 */
	public function read($query, array $options = array()) {
		$options += array(
			'conditions' => array(),
		);
		$options['conditions'] += array(
			'raw' => null,
			'switches' => null,
			'configure' => __DIR__ . '/../../test/_phpunit.xml',
			'path' => getcwd() . '/tests',
			'output' => null,
			'outputFile' => null,
		);
		$params = compact('query', 'options');
		return $this->_filter(__METHOD__, $params, function($self, $params) {
			$options = $params['options']['conditions'];
			if (!isset($self->outputFormats[$options['output']])) {
				$options['output'] = 'default';
			} elseif (is_null($options['outputFile'])) {
				$options['outputFile'] = $self->outputFile[$options['output']];
			}
			$options['output'] = String::insert($self->outputFormats[$options['output']], array(
				'outputFile' => $options['outputFile'],
			));

			return shell_exec(String::insert($self->templates['read'], $options));
		});
	}

}

?>