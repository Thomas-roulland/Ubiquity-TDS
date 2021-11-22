<?php
namespace controllers;
use Ubiquity\attributes\items\router\Post;
use Ajax\JsUtils;
use Ubiquity\attributes\items\router\Get;
 use models\Groupe;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\controllers\Router;
use Ubiquity\orm\repositories\ViewRepository;

/**
  * Controller GroupController
  * @property JsUtils $jquery
  */
class GroupController extends \controllers\ControllerBase{

    private ViewRepository $repo;

    public function initialize() {
        parent::initialize();
        $this->repo??=new ViewRepository($this,Groupe::class);
    }

    #[Route('/grp')]
	public function index(){
        $this->repo->all();
		$this->loadView("GroupController/index.html");
	}

	#[Get(path: "Group/addGroupe",name: "group.addGroupe")]
	public function addGroupe(){
		$grp=new Groupe();
        $frm=$this->jquery->semantic()->dataForm('frm-grp',$grp);
        $frm->setActionTarget(Router::path('group.postGroupe'), '');
        $frm->setProperty('method','post');
        $frm->setFields(['name','email', 'aliases', 'organization', 'submit']);
        $frm->fieldAsDropDown('organization');
        $frm->fieldAsSubmit('submit', 'green','');
		$this->jquery->renderView('GroupController/addGroupe.html');

	}


	#[Post(path: "Group/postGroupe",name: "group.postGroupe")]
	public function postGroupe(){
		
	}

}
