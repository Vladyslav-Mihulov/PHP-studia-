<?php
namespace app\controllers;

use app\forms\KredytForm;
use app\transfer\KredytResult;
class KredytCtrl {

	private $form;   //dane formularza (do obliczeń i dla widoku)
	private $result; //inne dane dla widoku

	/** 
	 * Konstruktor - inicjalizacja właściwości
	 */
	public function __construct(){
		//stworzenie potrzebnych obiektów
		$this->form = new KredytForm();
		$this->result = new KredytResult();
	}
	
	/** 
	 * Pobranie parametrów
	 */
	public function getParams(){
		$this->form->kwota = getFromRequest('kwota');
		$this->form->okres = getFromRequest('okres');
		$this->form->oprocentowanie = getFromRequest('oprocentowanie');
	}
	
	/** 
	 * Walidacja parametrów
	 * @return true jeśli brak błedów, false w przeciwnym wypadku 
	 */
	public function validate() {
		// sprawdzenie, czy parametry zostały przekazane
		if (! (isset ( $this->form->kwota ) && isset ( $this->form->okres ) && isset ( $this->form->oprocentowanie ))) {
			// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
			return false; //zakończ walidację z błędem
		}
		
		// sprawdzenie, czy potrzebne wartości zostały przekazane
		if ($this->form->kwota == "") {
			getMessages()->addError('Nie podano kwoty');
		}
		if ($this->form->okres == "") {
			getMessages()->addError('Nie podano okressu');
		}
                if ($this->form->oprocentowanie == "") {
			getMessages()->addError('Nie podano oprocentowania');
		}
		
		// nie ma sensu walidować dalej gdy brak parametrów
		if (! getMessages()->isError()) {
			
			// sprawdzenie, czy $x i $y są liczbami całkowitymi
			if (! is_numeric ( $this->form->kwota )) {
				getMessages()->addError('Kwota nie jest liczbą całkowitą');
			}
			
			if (! is_numeric ( $this->form->okres )) {
				getMessages()->addError('Okres nie jest liczbą całkowitą');
			}
                        if (! is_numeric ( $this->form->oprocentowanie )) {
				getMessages()->addError('Oprocentowanie nie jest liczbą całkowitą');
			}
		}
		
		return ! getMessages()->isError();
	}
	
	public function action_kredytCompute(){

		$this->getParams();
		
		if ($this->validate()) {
				
			//konwersja parametrów na int
			$this->form->kwota = intval($this->form->kwota);
			$this->form->okres = intval($this->form->okres);
                        $this->form->oprocentowanie = floatval($this->form->oprocentowanie);
			getMessages()->addInfo('Parametry poprawne.');
				
			//wykonanie operacji
			 if ( inRole('admin') || ( $this->form->kwota < 10000 && $$this->form->oprocentowanie > 5) ) {    
                            $this->result->wynik = ( $this->form->kwota + ($this->form->kwota * ($this->form->oprocentowanie / 100) * $this->form->okres ) ) / ( $this->form->okres * 12 );
                            getMessages()->addInfo('Wykonano obliczenia.');
                          }
                         else {
                                if ($this->form->oprocentowanie <= 5 && inRole('user')) {
                                getMessages()->addError('Tylko admin może mieć oprocentowanie <= 5');
                            }
                
                         if ($this->form->kwota >= 10000 && inRole('user')) {
                                getMessages()->addError('Tylko admin może mieć kwotę >=  10 000');
                              } 
                         } 
                         
		}
		
		$this->generateView();
	}
        
	
	public function action_kredytShow(){
		getMessages()->addInfo('Witaj w kalkulatorze');
		$this->generateView();
	}
	/**
	 * Wygenerowanie widoku
	 */
	public function generateView(){
            
                getSmarty()->assign('user',unserialize($_SESSION['user']));
		getSmarty()->assign('page_title','Przykład 06b');
		getSmarty()->assign('page_description','');

					
		getSmarty()->assign('form',$this->form);
		getSmarty()->assign('res',$this->result);
		
		getSmarty()->display('kredyt_view.html');
	}
}
