<?php

require_once dirname(__FILE__).'/../config.php';

require_once $conf->root_path.'/app/HomePageCtrl.class.php';

$home = new HomePageCtrl();
$home->process();
