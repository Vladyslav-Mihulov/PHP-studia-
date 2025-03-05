<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

// 1. pobranie parametrów

$kwota = $_REQUEST ['kwota'];
$okres = $_REQUEST ['okres'];
$Oprocentowanie = $_REQUEST ['op'];

// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane
if ( ! (isset($kwota) && isset($okres) && isset($Oprocentowanie))) {
	//sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
	$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

// sprawdzenie, czy potrzebne wartości zostały przekazane
if ( $kwota == "") {
	$messages [] = 'Nie podano Kwoty';
}
if ( $okres == "") {
	$messages [] = 'Nie podano Okresu';
}

//nie ma sensu walidować dalej gdy brak parametrów
if (empty( $messages )) {
	
	// sprawdzenie, czy $x i $y są liczbami całkowitymi
	if (! is_numeric( $kwota )) {
		$messages [] = 'Kwota nie jest liczbą całkowitą';
	}
	
	if (! is_numeric( $okres )) {
		$messages [] = 'Okres nie jest liczbą całkowitą';
	}	

}

// 3. wykonaj zadanie jeśli wszystko w porządku

if (empty ( $messages )) { // gdy brak błędów
	
	//konwersja parametrów na int
	$kwota = intval($kwota);
	$okres = intval($okres);
	
	//wykonanie operacji
	switch ($Oprocentowanie) {
		case '1%' :
			$result = ( $kwota + ($kwota * 0.01 * $okres ) ) / ( $okres * 12 );
			break;
		case '1,5%' :
			$result = ( $kwota + ($kwota * 0.015 * $okres ) ) / ( $okres * 12 );
			break;
		case '2%' :
			$result = ( $kwota + ($kwota * 0.02 * $okres ) ) / ( $okres * 12 );
			break;
		default :
			$result = ( $kwota + ($kwota * 0.025 * $okres ) ) / ( $okres * 12 );
			break;
	}
}

// 4. Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$x,$y,$operation,$result)
//   będą dostępne w dołączonym skrypcie
include 'kredyt_view.php';