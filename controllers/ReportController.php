<?php

namespace li3_phpunit\controllers;

use lithium\core\Libraries;
use li3_phpunit\models\Results;
use lithium\template\View;
class ReportController extends \lithium\action\Controller {

	public function index() {
		error_reporting(-1);
		echo "Hi";
		return array("foo" => "bar");

		$files = Libraries::locate('phpunit', null, array('filter' => '/tests\\\.*Test/'));

		$view = new View(array(
			'paths' => array(
				'template' => '{:library}/views/{:controller}/{:template}.{:type}.php',
				'layout'   => '{:library}/views/layouts/{:layout}.{:type}.php',
			)
		));

		return $view->render('all', compact('content'), compact('template') + array(
			'data' => array('files' => $files),
			'library' => 'li3_phpunit',
			'controller' => 'report',
			'layout' => 'default',
			'template' => 'index',
			'type' => 'html'
		));
	}

}