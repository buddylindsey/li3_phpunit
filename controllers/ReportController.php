<?php

namespace li3_phpunit\controllers;

use lithium\core\Libraries;
use li3_phpunit\models\Results;
use lithium\template\View;

use li3_phpunit\extensions\adapter\data\source\command\Phpunit;

class ReportController extends \lithium\action\Controller {

	/**
	 * Define application view paths
	 */
	protected function _init() {
		$this->_render['renderer'] = 'File';
		$this->_render['paths']['template'] = '{:library}/views/{:controller}/';
		$this->_render['paths']['template'] .= '{:template}.{:type}.php';
		$this->_render['paths']['layout'] = '{:library}/views/layouts/default.{:type}.php';
		$this->_render['paths']['element'] = '{:library}/views/elements/{:template}.html.php';
		parent::_init();
	}

	public function index() {
		$files = Libraries::locate('phpunit', null, array('filter' => '/tests\\\.*Test/'));

		$unit = new Phpunit();

		$query = new \lithium\data\model\Query;
		$query->model($model);


		$unit->read($query, array(
			'conditions' => array(
				'output' => 'json',
			),
		));

		return compact('files', 'results');
	}

}