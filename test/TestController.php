<?php

namespace li3_phpunit\test;

use lithium\template\View;

class TestController extends \lithium\action\Controller {

	protected function getFiles($path){
		$iterator = new \DirectoryIterator($path);
		foreach($iterator as $file){
			if($file->isDir() && $file->getFilename() != ".." && $file->getFilename() != "."){
				echo($file->getPathname()."<br />");
				$this->getFiles($file->getPathname());
			}

			if($file->isFile()){
				echo($file->getPathname()."<br />");
			}
		}
	}

	public function index() {

		$directory = dirname(__FILE__) . "/../../../tests/";
		$this->getFiles($directory);

		die;

		$view = new View(array(
			'paths' => array(
				'template' => '{:library}/views/{:controller}/{:template}.{:type}.php',
				'layout'   => '{:library}/views/layouts/{:layout}.{:type}.php',
			),
		));	
		echo $view->render('all', compact('content'), compact('template') + array(
			'controller' => 'errors',
			'layout' => 'default',
			'type' => 'html'
		));
	}
}