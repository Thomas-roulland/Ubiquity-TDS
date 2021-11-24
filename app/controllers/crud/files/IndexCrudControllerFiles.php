<?php
namespace controllers\crud\files;

use Ubiquity\controllers\crud\CRUDFiles;
 /**
  * Class IndexCrudControllerFiles
  */
class IndexCrudControllerFiles extends CRUDFiles{
	public function getViewIndex(){
		return "IndexCrudController/index.html";
	}

	public function getViewForm(){
		return "IndexCrudController/form.html";
	}

	public function getViewDisplay(){
		return "IndexCrudController/display.html";
	}

	public function getViewHome(){
		return "IndexCrudController/home.html";
	}

	public function getViewItemHome(){
		return "IndexCrudController/itemHome.html";
	}

	public function getViewNav(){
		return "IndexCrudController/nav.html";
	}


}
