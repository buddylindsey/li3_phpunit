<?php

namespace li3_phpunit\controllers;

use lithium\core\Libraries;
use li3_phpunit\models\Results;

class ReportController extends \lithium\action\Controller {

	public function index() {

		print_r($this);die;
		$files = Libraries::locate('phpunit', null, array('filter' => '/tests\\\.*Test/'));

		return array('files' => $files);
	}

}