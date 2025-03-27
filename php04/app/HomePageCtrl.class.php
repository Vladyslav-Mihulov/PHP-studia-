<?php
require_once $conf->root_path.'/lib/smarty/libs/Smarty.class.php';
use Smarty\Smarty;

class HomePageCtrl {
    
    public function process(){
		$this->generateView();
	}
    
    public function generateView(){
		global $conf;
		
		$home = new Smarty();
		$home->assign('conf',$conf);
		
		$home->assign('page_title','HomePage');
		$home->assign('page_description','Witam na stronie głównej');

		
		$home->display($conf->root_path.'/app/homepage_view.html');
	}
}