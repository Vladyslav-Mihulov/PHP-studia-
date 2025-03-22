<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';
//załaduj Smarty
require_once _ROOT_PATH.'/lib/smarty/libs/Smarty.class.php';

use Smarty\Smarty;

//include _ROOT_PATH.'/app/security/check.php';


//pobranie parametrów
function getParams(&$form){
	$form['kwota']= isset($_REQUEST['kwota']) ? $_REQUEST['kwota'] : null;
	$form['okres'] = isset($_REQUEST['okres']) ? $_REQUEST['okres'] : null;
	$form['oprocentowanie'] = isset($_REQUEST['oprocentowanie']) ? $_REQUEST['oprocentowanie'] : null;	
}

//walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$form,&$infos,&$messages,&$hide_intro){
	// sprawdzenie, czy parametry zostały przekazane
	if ( ! (isset($form['kwota']) && isset($form['okres']) && isset($form['oprocentowanie']))) {
		// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
		// teraz zakładamy, ze nie jest to błąd. Po prostu nie wykonamy obliczeń
		return false;
	}
        
        $hide_intro = true;

	$infos [] = 'Przekazano parametry.';

	// sprawdzenie, czy potrzebne wartości zostały przekazane
	if ( $form['kwota'] == "") {
		$messages [] = 'Nie podano kwoty';
	}
	if ( $form['okres'] == "") {
		$messages [] = 'Nie podano okresu';
	}
        if ( $form['oprocentowanie'] == "") {
		$messages [] = 'Nie podano oprocentowania';
	}

	//nie ma sensu walidować dalej gdy brak parametrów
	if (count ( $messages ) != 0) return false;
	
	// sprawdzenie, czy $x i $y są liczbami całkowitymi
	if (! is_numeric( $form['kwota'] )) {
		$messages [] = 'Kwota nie jest liczbą całkowitą';
	}
	
	if (! is_numeric( $form['okres'] )) {
		$messages [] = 'Okres nie jest liczbą całkowitą';
	}	

        if (!is_numeric( $form['oprocentowanie'] )) {
		$messages [] = 'Oprocentowanie nie jest liczbą ';
	}
        
        // sprawdzenie, czy kwota, okres, oprocentowanie >0
        if ($form['kwota'] <= 0) {
		$messages [] = 'Kwota <= 0 ';
	}
	
	if ($form['okres'] <= 0 ) {
		$messages [] = 'Okres <= 0 ';
	}	

        if ($form['oprocentowanie'] <= 0) {
		$messages [] = 'Oprocentowanie <= 0 ';
	}
        
	if (count ( $messages ) != 0) return false;
	else return true;
}

function process(&$form,&$messages,&$result,&$infos){
	global $role;
	
        $infos [] = 'Parametry poprawne. Wykonuję obliczenia.';
        
	//konwersja parametrów na int
	$form['kwota'] = intval($form['kwota']);
	$form['okres'] = intval($form['okres']);
        $form['oprocentowanie'] = floatval($form['oprocentowanie']);
	
	//wykonanie operacji
	
        $result = ( $form['kwota'] + ($form['kwota'] * ($form['oprocentowanie'] / 100) * $form['okres'] ) ) / ( $form['okres'] * 12 );
        
        /*if ( $role == 'admin' || $form['kwota'] < 10000 && $form['oprocentowanie'] > 5) {
            $result = ( $form['kwota'] + ($form['kwota'] * ($form['oprocentowanie'] / 100) * $form['okres'] ) ) / ( $form['okres'] * 12 );
        }
        else {
            if ($form['oprocentowanie'] <= 5 && $role != 'admin') {
                    $messages [] = 'Tylko admin może mieć oprocentowanie <= 5';
                }
                
            if ($form['kwota'] >= 10000 && $role != 'admin') {
                $messages [] = 'Tylko admin może mieć kwotę >=  10 000';
            } 
        } */
}

//definicja zmiennych kontrolera
$form = null;
$result = null;
$messages = array();
$infos = array();

//pobierz parametry i wykonaj zadanie jeśli wszystko w porządku
getParams($form);
if ( validate($form,$infos,$messages,$hide_intro) ) { // gdy brak błędów
	process($form,$messages,$result,$infos);
}

$smarty = new Smarty();

$smarty->assign('app_url',_APP_URL);
$smarty->assign('root_path',_ROOT_PATH);
$smarty->assign('page_title','Kalkulator kredytowy');
$smarty->assign('page_description','Profesjonalne szablonowanie oparte na bibliotece Smarty');

//pozostałe zmienne niekoniecznie muszą istnieć, dlatego sprawdzamy aby nie otrzymać ostrzeżenia
$smarty->assign('form',$form);
$smarty->assign('result',$result);
$smarty->assign('messages',$messages);
$smarty->assign('infos',$infos);

// 5. Wywołanie szablonu
$smarty->display(_ROOT_PATH.'/app/kredyt.html');