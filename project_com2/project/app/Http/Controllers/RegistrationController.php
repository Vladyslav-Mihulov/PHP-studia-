<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    
        public function submit(RegistrationRequest $req){
       
        $validatedData = $req->validated();    
            
        session()->flash('success', 'Rejestracja przebiegła pomyślnie!');

        return redirect()->route('login');
    }
    
    public function show(){
        return view('registration');
    }
}
