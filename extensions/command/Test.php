<?php

namespace li3_phpunit\extensions\command;

use \lithium\console\Command;

class Test extends Command {

	public $path;
	public $output;

	public function run() {

		$command = "phpunit";
		$current = __DIR__;
		$config = "-c {$current}/../../test/_phpunit.xml";

		$output = "";

		switch($this->output){
			case "json":
				$output = "--log-json data.json";
				break;
			case "junit":
				$output = "--log-junit data.xml";
				break;
			default:
				$output = "";
				break;
		}

		$output = shell_exec("{$command} {$config} {$output} {$current}/../../../../{$this->path}");

		echo $output;
	}
}