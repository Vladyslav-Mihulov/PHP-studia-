<?php
//Skrypt uruchamiający akcję wykonania obliczeń kalkulatora
// - należy zwrócić uwagę jak znacząco jego rola uległa zmianie
//   po wstawieniu funkcjonalności do klasy kontrolera

require_once dirname(__FILE__).'/../../config.php';

//załaduj kontroler
require_once $conf->root_path.'/app/security/LoginCtrl.class.php';
//utwórz obiekt i użyj
$logCtrl = new LoginCtrl();
$logCtrl->process();
