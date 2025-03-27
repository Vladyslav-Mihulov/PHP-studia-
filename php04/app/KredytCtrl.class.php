<?php
// W skrypcie definicji kontrolera nie trzeba dołączać problematycznego skryptu config.php,
// ponieważ będzie on użyty w miejscach, gdzie config.php zostanie już wywołany.

require_once $conf->root_path.'/lib/smarty/libs/Smarty.class.php';
use Smarty\Smarty;
require_once $conf->root_path.'/lib/Messages.class.php';
require_once $conf->root_path.'/app/KredytForm.class.php';
require_once $conf->root_path.'/app/KredytResult.class.php';
include $conf->root_path.'/app/security/check.php';

class KredytCtrl {

	private $msgs;   //wiadomości dla widoku
	private $form;   //dane formularza (do obliczeń i dla widoku)
	private $result; //inne dane dla widoku

	/** 
	 * Konstruktor - inicjalizacja właściwości
	 */
	public function __construct(){
		//stworzenie potrzebnych obiektów
		$this->msgs = new Messages();
		$this->form = new KredytForm();
		$this->result = new KredytResult();
	}
	
	/** 
	 * Pobranie parametrów
	 */
	public function getParams(){
		$this->form->kwota = isset($_REQUEST ['kwota']) ? $_REQUEST ['kwota'] : null;
		$this->form->okres = isset($_REQUEST ['okres']) ? $_REQUEST ['okres'] : null;
		$this->form->oprocentowanie = isset($_REQUEST ['oprocentowanie']) ? $_REQUEST ['oprocentowanie'] : null;
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
			$this->msgs->addError('Nie podano kwoty');
		}
		if ($this->form->okres == "") {
			$this->msgs->addError('Nie podano okressu');
		}
                if ($this->form->oprocentowanie == "") {
			$this->msgs->addError('Nie podano oprocentowania');
		}
		
		// nie ma sensu walidować dalej gdy brak parametrów
		if (! $this->msgs->isError()) {
			
			// sprawdzenie, czy $x i $y są liczbami całkowitymi
			if (! is_numeric ( $this->form->kwota )) {
				$this->msgs->addError('Kwota nie jest liczbą całkowitą');
			}
			
			if (! is_numeric ( $this->form->okres )) {
				$this->msgs->addError('Okres nie jest liczbą całkowitą');
			}
                        if (! is_numeric ( $this->form->oprocentowanie )) {
				$this->msgs->addError('Oprocentowanie nie jest liczbą całkowitą');
			}
		}
		
		return ! $this->msgs->isError();
	}
	
	/** 
	 * Pobranie wartości, walidacja, obliczenie i wyświetlenie
	 */
	public function process(){

		$this->getparams();
		
		if ($this->validate()) {
				
			//konwersja parametrów na int
			$this->form->kwota = intval($this->form->kwota);
			$this->form->okres = intval($this->form->okres);
                        $this->form->oprocentowanie = floatval($this->form->oprocentowanie);
			$this->msgs->addInfo('Parametry poprawne.');
				
			//wykonanie operacji
			//$this->result->wynik = ( $this->form->kwota + ($this->form->kwota * ($this->form->oprocentowanie / 100) * $this->form->okres ) ) / ( $this->form->okres * 12 );
        
                          if ( $_SESSION['role']  == 'admin' || $this->form->kwota < 10000 && $$this->form->oprocentowanie > 5) {    
                            $this->result->wynik = ( $this->form->kwota + ($this->form->kwota * ($this->form->oprocentowanie / 100) * $this->form->okres ) ) / ( $this->form->okres * 12 );
                            $this->msgs->addInfo('Wykonano obliczenia.');
                          }
                         else {
                                if ($this->form->oprocentowanie <= 5 && $_SESSION['role']  != 'admin') {
                                $this->msgs->addError('Tylko admin może mieć oprocentowanie <= 5');
                            }
                
                         if ($this->form->kwota >= 10000 && $_SESSION['role']  != 'admin') {
                                $this->msgs->addError('Tylko admin może mieć kwotę >=  10 000');
                              } 
                         } 
                       
		}
		
		$this->generateView();
	}
	
	
	/**
	 * Wygenerowanie widoku
	 */
	public function generateView(){
		global $conf;
		
		$smarty = new Smarty();
		$smarty->assign('conf',$conf);
		
		$smarty->assign('page_title','Przykład 05');
		$smarty->assign('page_description','Twoja rola '.$_SESSION['role']);
		
		$smarty->assign('msgs',$this->msgs);
		$smarty->assign('form',$this->form);
		$smarty->assign('res',$this->result);
		
		$smarty->display($conf->root_path.'/app/kredyt_view.html');
	}
}
