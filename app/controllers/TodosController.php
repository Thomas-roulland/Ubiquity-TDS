<?php
namespace controllers;
use Ajax\JsUtils;
use Ubiquity\attributes\items\router\Get;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\attributes\items\router\Post;
use Ubiquity\controllers\Router;
use Ubiquity\utils\http\URequest;
use Ubiquity\utils\http\USession;

/**
  * Controller TodosController
  * @property JsUtils $jquery
  */
class TodosController extends \controllers\ControllerBase{


    const CACHE_KEY = 'datas/lists/';
    const EMPTY_LIST_ID='not saved';
    const LIST_SESSION_KEY='list';
    const ACTIVE_LIST_SESSION_KEY='active-list';

    #[Get(path: "/default/",name: "home")]
	public function index(){
        $list=USession::get('list', []);
        $this->jquery->click('._toEdit', 'let item=$(this).closest("div.item");
                                                            item.find("form").toggle();
                                                            item.find(".checkbox").toggle();');
        $this->jquery->getHref('a', parameters: ['hasLoader' =>false, 'historize'=>false]);
        $this->jquery->renderView('TodosController/index.html', ['list'=>$list]);
	}

	#[Get(path: "todos/add/",name: "todos.addElement")]
	public function addElement(){
        $this->jquery->postFormOnClick('button',Router::path('todos.loadListFromForm'), 'frm','._content', ['hasLoader'=>'internal']);
		$this->jquery->renderView('TodosController/addElement.html');

	}


	#[Get(path: "todos/delete/{index}",name: "todos.deleteElement")]
	public function deleteElement($index){

		$this->loadView('TodosController/deleteElement.html');

	}


	#[Post(path: "todos/edit/{index}",name: "todos.editElement")]
	public function editElement($index){

        USession::addValueToArray('list', URequest::post('items'));
		$this->loadView('TodosController/editElement.html');

	}


	#[Get(path: "/todos/loadList/{uniquid}",name: "todos.loadList")]
	public function loadList($uniquid){
		
		$this->loadView('TodosController/loadList.html');

	}


	#[Post(path: "/todos/loadList",name: "todos.loadListFromForm")]
	public function loadListFromForm(){

        USession::addValueToArray('list', URequest::post('items'));
        echo "listes ajoutées";

	}


	#[Get(path: "/todos/new/{force}",name: "todos.newList")]
	public function newList($force){
		
		$this->loadView('TodosController/newList.html');

	}


	#[Get(path: "/todos/saveList",name: "todos.saveList")]
	public function saveList(){
		
		$this->loadView('TodosController/saveList.html');

	}

}
