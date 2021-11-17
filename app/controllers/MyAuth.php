<?php
namespace controllers;
use Ubiquity\attributes\items\router\Get;
use Ubiquity\attributes\items\router\Post;
use Ubiquity\cache\CacheManager;
use Ubiquity\utils\flash\FlashMessage;
use Ubiquity\utils\http\UResponse;
use Ubiquity\utils\http\USession;
use Ubiquity\utils\http\URequest;
use controllers\auth\files\MyAuthFiles;
use Ubiquity\controllers\auth\AuthFiles;
use Ubiquity\attributes\items\router\Route;

#[Route(path: "/login",inherited: true,automated: true)]
class MyAuth extends \Ubiquity\controllers\auth\AuthController{


    protected $footerView = "@activeTheme/main/vFooter.html";
    protected $headerView = "@activeTheme/main/vHeader.html";

    private function showMessage(string $header, string $message, string $type = '', string $icon = 'info circle',array $buttons=[]) {
        $this->loadView('main/message.html', compact('header', 'type', 'icon', 'message','buttons'));
    }

	protected function onConnect($connected) {
		$urlParts=$this->getOriginalURL();
		USession::set($this->_getUserSessionKey(), $connected);
		if(isset($urlParts)){
			$this->_forward(implode("/",$urlParts));
		}else{
			UResponse::header('location', '/');
		}
	}

	protected function _connect() {
		if(URequest::isPost()){
			$email=URequest::post($this->_getLoginInputName());
			$password=URequest::post($this->_getPasswordInputName());
			$key='datas/users'.md5($email);
            if(CacheManager::$cache->exists($key)){
                $userInfos=CacheManager::$cache->fetch($key);
                if ($userInfos['login']===$email && URequest::password_verify($this->_getPasswordInputName(), $userInfos['password'] )){
                    return $email;
                }
            }
		}
		return;
	}
	
	/**
	 * {@inheritDoc}
	 * @see \Ubiquity\controllers\auth\AuthController::isValidUser()
	 */
	public function _isValidUser($action=null) {
		return USession::exists($this->_getUserSessionKey());
	}

	public function _getBaseRoute() {
		return '/login';
	}
	
	protected function getFiles(): AuthFiles{
		return new MyAuthFiles();
	}


    protected function finalizeAuth()
    {
        if (! URequest::isAjax()) {
            $this->loadView($this->footerView);
        }
    }

    protected function initializeAuth()
    {
        if (! URequest::isAjax()) {
            $this->loadView($this->headerView);
        }
    }

	#[Get(path: "newUser",name: "myAuth.newUserForm")]
	public function newUserForm(){
		
		$this->loadView('MyAuth/newUserForm.html');

	}

    protected function terminateMessage(FlashMessage $fMessage)
    {
        $fMessage->setIcon("checkmark");
        $fMessage->setTitle("Déconnexion");
        $fMessage->setContent("vous avez été déconnecté de l'application");
    }




    public function _displayInfoAsString()
    {
        return true;
    }

    #[Post(path: "newUser",name: "myAuth.newUser")]
	public function newUser(){
        $email=URequest::post('email');
        $key='datas/users'.md5($email);
		if (!CacheManager::$cache->exists($key)){
            CacheManager::$cache->store($key,['login'=>$email,'password'=>URequest::password_hash('password')]);
            $this->showMessage('Création de compte', "votre compte a été créé avec l'email <b>$email</b>", 'succes');
        }else{
            $this->showMessage('Création de compte', "Compte déjà associé a l'email : <b>$email</b>", 'error', 'user');
        }
	}

}
