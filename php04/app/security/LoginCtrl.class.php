<?php
// W skrypcie definicji kontrolera nie trzeba dołączać problematycznego skryptu config.php,
// ponieważ będzie on użyty w miejscach, gdzie config.php zostanie już wywołany.

require_once $conf->root_path.'/lib/smarty/libs/Smarty.class.php';
use Smarty\Smarty;
require_once $conf->root_path.'/lib/Messages.class.php';
require_once $conf->root_path.'/app/security/LoginForm.class.php';


class LoginCtrl {

	private $msgs;   //wiadomości dla widoku
	private $form;//inne dane dla widoku

	/** 
	 * Konstruktor - inicjalizacja właściwości
	 */
	public function __construct(){
		//stworzenie potrzebnych obiektów
		$this->msgs = new Messages();
		$this->form = new LoginForm();
	}
	
	/** 
	 * Pobranie parametrów
	 */
	public function getParams(){
		$this->form->login = isset($_REQUEST ['login']) ? $_REQUEST ['login'] : null;
		$this->form->password = isset($_REQUEST ['password']) ? $_REQUEST ['password'] : null;
	}
	
	/** 
	 * Walidacja parametrów
	 * @return true jeśli brak błedów, false w przeciwnym wypadku 
	 */
	public function validate() {
		// sprawdzenie, czy parametry zostały przekazane
		if (! (isset ( $this->form->login ) && isset ( $this->form->password ) ) ) {
			// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
			return false; //zakończ walidację z błędem
		}
		
		// sprawdzenie, czy potrzebne wartości zostały przekazane
		if ($this->form->login == "") {
			$this->msgs->addError('Nie podano loginu');
		}
		if ($this->form->password == "") {
			$this->msgs->addError('Nie podano hasła');
		}
		
                // sprawdzenie, czy dane logowania są poprawne
                // - takie informacje najczęściej przechowuje się w bazie danych
                //   jednak na potrzeby przykładu sprawdzamy bezpośrednio
                if ($this->form->login == "admin" && $this->form->password == "admin") {
                        if (session_status() == PHP_SESSION_NONE) {
                                session_start(); 
                                $_SESSION['role'] = 'admin';
                        } else {
                            $_SESSION['role'] = 'admin';
                        }
                        
                        return true;
                } 
                else if ($this->form->login == "user" && $this->form->password == "user") {
                        
                        if (session_status() == PHP_SESSION_NONE) {
                                session_start(); // Запускаем сессию
                                $_SESSION['role'] = 'user';
                        } else {
                            $_SESSION['role'] = 'user';
                        }
                        
                        return true;
                 } else $this->msgs->addError('Niepoprawny login lub hasło');
	
		
		return ! $this->msgs->isError();
	}
	
	/** 
	 * Pobranie wartości, walidacja, obliczenie i wyświetlenie
	 */
	public function process(){

		$this->getparams();
		
		if ($this->validate()) {
				
                    $this->msgs->addInfo('Jestes zalogowany');
		}
		
		$this->generateView();
	}
	
	
	/**
	 * Wygenerowanie widoku
	 */
	public function generateView(){
		global $conf;

		$login = new Smarty();
		$login->assign('conf',$conf);
		
		$login->assign('page_title','Przykład 05');
                
		if (session_status() == PHP_SESSION_NONE || empty($role) ) {
                            $login->assign('page_description','Twoja rola Unknown');
                 } else $smarty->assign('page_description','Twoja rola '.$_SESSION['role']);
		
		$login->assign('msgs',$this->msgs);
		$login->assign('form',$this->form);
		
		$login->display($conf->root_path.'/app/security/login_view.html');
	}
}
