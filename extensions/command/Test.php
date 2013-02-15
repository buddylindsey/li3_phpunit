<?php

namespace li3_phpunit\extensions\command;

use \lithium\console\Command;

class Test extends Command {

	public $path;

	public function run() {

		$command = "phpunit";
		$current = __DIR__;
		$config = "-c {$current}/../../test/_phpunit.xml";


		$output = shell_exec("{$command} {$config} {$current}/../../../../{$this->path}");

		echo $output;
	}
}