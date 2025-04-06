<?php
namespace app\controllers;

class HomePageCtrl {
    
    public function process(){
		$this->generateView();
	}
    
    public function generateView(){
		
		
		getSmarty()->assign('page_title','HomePage');
		getSmarty()->assign('page_description','Witam na stronie głównej');

		
		getSmarty()->display('homepage_view.html');
	}
}