<?php
namespace services\ui;

 use Ajax\bootstrap\html\HtmlForm;
 use Ajax\php\ubiquity\UIService;
 use Ajax\semantic\widgets\dataform\DataForm;
 use models\Group;
 use models\User;
 use Ubiquity\controllers\Controller;
 use Ubiquity\controllers\Router;
 use Ubiquity\orm\DAO;
 use Ubiquity\utils\http\URequest;
 use Ubiquity\utils\models\UArrayModels;

 /**
  * Class UIGroups
  */
 class UIGroups extends UIService {
     public function __construct(Controller $controller) {
         parent::__construct($controller);
         if(!URequest::isAjax()) {
             $this->jquery->getHref('a[data-target]', '', ['hasLoader' => 'internal', 'historize' => false,'listenerOn'=>'body']);
         }
     }


     private function addFormBehavior(string $formName,HtmlForm|DataForm $frm,string $responseElement,string $postUrlName){
         $frm->setValidationParams(["on"=>"blur","inline"=>true]);
         $this->jquery->click("#$formName-div ._validate",'$("#'.$formName.'").form("submit");');
         $this->jquery->click("#$formName-div ._cancel",'$("#'.$formName.'-div").hide();');
         $frm->setSubmitParams(Router::path($postUrlName),'#'.$responseElement,['hasLoader'=>'internal']);
     }



     public function newGroup($formName){
         $frm=$this->semantic->dataForm($formName,new Group());
         $frm->addClass('inline');
         $frm->setFields(['name','email','aliases']);
         $frm->setCaptions(['nom','Email','aliases']);
         $frm->fieldAsLabeledInput('name',['rules'=>'empty']);
         $frm->fieldAsLabeledInput('email',['rules'=>'empty']);
         $this->addFormBehavior($formName,$frm,'new-group','new.groupPost');
     }

     public function addUser(){
         $users=new User();
         $grp=new Group();
         $ids = \array_map(function ($user){
             return $user->getId ();
         }, $grp->getUsers());
         $grp->userIds=implode(',',$ids);
         $dd=$this->semantic->htmlDropdown('dd-group','Ajouter des utilisateurs au groupe ...', UArrayModels::asKeyValues(DAO::getAll(Group::class)));
         $dd->asButton();
         $dd->setIcon("users");
         $frm=$this->semantic->dataForm('frm-user',new User());
         $frm->setActionTarget(Router::path('group.addPost'), '');
         $frm->setFields([ 'usersIds', 'submit',]);
         $frm->setProperty('method', 'post');
         $frm->fieldAsSubmit('submit', 'green', '');
         $frm->fieldAsDropDown('usersIds', UArrayModels::asKeyValues(DAO::getAll(User::class), 'getId'), true);
     }
 }
