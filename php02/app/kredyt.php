<?php
require_once dirname(__FILE__).'/../config.php';

// KONTROLER strony kalkulatora

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

//ochrona kontrolera - poniższy skrypt przerwie przetwarzanie w tym punkcie gdy użytkownik jest niezalogowany
include _ROOT_PATH.'/app/security/check.php';

//pobranie parametrów
function getParams(&$kwota,&$okres,&$oprocentowanie){
	$kwota = isset($_REQUEST['kwota']) ? $_REQUEST['kwota'] : null;
	$okres = isset($_REQUEST['okres']) ? $_REQUEST['okres'] : null;
	$oprocentowanie = isset($_REQUEST['oprocentowanie']) ? $_REQUEST['oprocentowanie'] : null;	
}

//walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$kwota,&$okres,&$oprocentowanie,&$messages){
	// sprawdzenie, czy parametry zostały przekazane
	if ( ! (isset($kwota) && isset($okres) && isset($oprocentowanie))) {
		// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
		// teraz zakładamy, ze nie jest to błąd. Po prostu nie wykonamy obliczeń
		return false;
	}

	// sprawdzenie, czy potrzebne wartości zostały przekazane
	if ( $kwota == "") {
		$messages [] = 'Nie podano kwoty';
	}
	if ( $okres == "") {
		$messages [] = 'Nie podano okresu';
	}
        if ( $oprocentowanie == "") {
		$messages [] = 'Nie podano oprocentowania';
	}

	//nie ma sensu walidować dalej gdy brak parametrów
	if (count ( $messages ) != 0) return false;
	
	// sprawdzenie, czy $x i $y są liczbami całkowitymi
	if (! is_numeric( $kwota )) {
		$messages [] = 'Kwota nie jest liczbą całkowitą';
	}
	
	if (! is_numeric( $okres )) {
		$messages [] = 'Okres nie jest liczbą całkowitą';
	}	

        if (!is_numeric( $oprocentowanie )) {
		$messages [] = 'Oprocentowanie nie jest liczbą ';
	}
        
        // sprawdzenie, czy kwota, okres, oprocentowanie >0
        if ($kwota <= 0) {
		$messages [] = 'Kwota <= 0 ';
	}
	
	if ($okres  <= 0 ) {
		$messages [] = 'Okres <= 0 ';
	}	

        if ($oprocentowanie <= 0) {
		$messages [] = 'Oprocentowanie <= 0 ';
	}
        
	if (count ( $messages ) != 0) return false;
	else return true;
}

function process(&$kwota,&$okres,&$oprocentowanie,&$messages,&$result){
	global $role;
	
	//konwersja parametrów na int
	$kwota = intval($kwota);
	$okres = intval($okres);
        $oprocentowanie = floatval($oprocentowanie);
	
	//wykonanie operacji
	
      
        if ( $role == 'admin' || $kwota < 10000 && $oprocentowanie > 5) {
            $result = ( $kwota + ($kwota * ($oprocentowanie / 100) * $okres ) ) / ( $okres * 12 );
        }
        else {
            if ($oprocentowanie <= 5 && $role != 'admin') {
                    $messages [] = 'Tylko admin może mieć oprocentowanie <= 5';
                }
                
            if ($kwota >= 10000 && $role != 'admin') {
                $messages [] = 'Tylko admin może mieć kwotę >=  10 000';
            } 
        }
}

//definicja zmiennych kontrolera
$kwota = null;
$okres = null;
$oprocentowanie = null;
$result = null;
$messages = array();

//pobierz parametry i wykonaj zadanie jeśli wszystko w porządku
getParams($kwota,$okres,$oprocentowanie);
if ( validate($kwota,$okres,$oprocentowanie,$messages) ) { // gdy brak błędów
	process($kwota,$okres,$oprocentowanie,$messages,$result);
}

// Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$kwota,$okres,$oprocentowanie,$result)
//   będą dostępne w dołączonym skrypcie
include 'kredyt_view.php';