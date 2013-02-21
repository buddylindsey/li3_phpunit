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

	protected function getFiles($path){
		$iterator = new \DirectoryIterator($path);
		foreach($iterator as $file){
			if($file->isDir() && $file->getFilename() != ".." && $file->getFilename() != "."){
				$filepath = explode('../', $file->getPathname());
				array_push($this->files, $filepath[1]);
				$this->getFiles($file->getPathname());
			}

			if($file->isFile()){
				if(strpos($file->getFilename(), 'php') !== false){
					$filepath = explode('../', $file->getPathname());
					array_push($this->files, $filepath[1]);
				}
			}
		}
	}

	public function index() {
		$this->files = array();
		$this->getFiles(getcwd() . '/../tests/');

		if ($this->request->url === 'test') {
			$url = '';
		} else {
			$url = substr($this->request->url, 5);
		}

		$results = Results::find('all', array(
			'conditions' => array(
				'output' => 'json',
				'switches' => '--stderr',
				'outputFile' => 'php://stdout',
				'raw' => '2>/dev/null',
				'configure' => __DIR__ . '/../test/_phpunit.xml',
				'path' => getcwd() . '/../tests/'.$url,
			),
		));

		$final = $results->data();

		$files = $this->files;
		return compact('files', 'final');
	}

}