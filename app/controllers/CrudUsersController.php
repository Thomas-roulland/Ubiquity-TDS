<?php
namespace controllers;
use controllers\crud\datas\CrudUsersControllerDatas;
use models\Group;
use models\User;
use Ubiquity\controllers\crud\CRUDDatas;
use controllers\crud\viewers\CrudUsersControllerViewer;
use Ubiquity\controllers\crud\viewers\ModelViewer;
use controllers\crud\events\CrudUsersControllerEvents;
use Ubiquity\controllers\crud\CRUDEvents;
use controllers\crud\files\CrudUsersControllerFiles;
use Ubiquity\controllers\crud\CRUDFiles;
use Ubiquity\attributes\items\router\Route;

#[Route(path: "/users",inherited: true,automated: true)]
class CrudUsersController extends \Ubiquity\controllers\crud\CRUDController{

	public function __construct(){
		parent::__construct();
		\Ubiquity\orm\DAO::start();
		$this->model=User::class;
		$this->style='inverted';
	}

	public function _getBaseRoute() {
		return '/users';
	}
	
	protected function getAdminData(): CRUDDatas{
		return new CrudUsersControllerDatas($this);
	}

	protected function getModelViewer(): ModelViewer{
		return new CrudUsersControllerViewer($this,$this->style);
	}

	protected function getEvents(): CRUDEvents{
		return new CrudUsersControllerEvents($this);
	}

	protected function getFiles(): CRUDFiles{
		return new CrudUsersControllerFiles();
	}


}
