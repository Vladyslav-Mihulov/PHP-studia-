<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller {
    
    public function submit(LoginRequest $req){
       
        session()->flash('success', 'Logowanie zakończone pomyślnie (tymczasowo bez sprawdzenia danych).');

        return redirect()->route('profile');
    }
    
    public function show(){
        return view('login');
    }
}
