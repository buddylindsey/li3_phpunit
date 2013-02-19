<?php

namespace li3_phpunit\extensions\command;

use lithium\console\Command;
use lithium\util\String;

class Test extends Command {

	/**
	 * Path provided by user
	 *
	 * @param string
	 */
	public $path;

	/**
	 * Stored output
	 *
	 * @param string
	 */
	public $output;

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
		'default' => '',
	);

	/**
	 * Will create and run a command to execute the phpunit tests.
	 *
	 * @return void
	 */
	public function run() {
		$output = isset($this->outputFormats[$this->output]) ? $this->output : 'default';
		$outputFile = isset($this->file) ? $this->file : $this->outputFile[$output];
		$tpl = "phpunit {:switches} -c {:dir}/../../test/_phpunit.xml {:output} {:dir}/../../../../{:path} {:raw}";
		echo shell_exec(String::insert($tpl, array(
			'raw' => isset($this->raw) ? $this->raw : null,
			'switches' => isset($this->switches) ? $this->switches : null,
			'dir' => __DIR__,
			'path' => $this->path,
			'output' => String::insert($this->outputFormats[$output], array(
				'outputFile' => $outputFile,
			)),
		)));
	}

}

?>