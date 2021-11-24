<?php
namespace controllers\crud\files;

use Ubiquity\controllers\crud\CRUDFiles;
 /**
  * Class CrudUsersControllerFiles
  */
class CrudUsersControllerFiles extends CRUDFiles{
	public function getViewIndex(){
		return "CrudUsersController/index.html";
	}

	public function getViewForm(){
		return "CrudUsersController/form.html";
	}

	public function getViewDisplay(){
		return "CrudUsersController/display.html";
	}


}
