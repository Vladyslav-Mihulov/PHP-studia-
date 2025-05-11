<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    
        public function submit(RegistrationRequest $req){
                
        $reg = new User();
        $reg->login = $req-> input('login');
        $reg->email = $req-> input('email');
        $reg->first_name = $req-> input('fname');
        $reg->last_name = $req-> input('lname');
        $reg->password = Hash::make($req->input('password1'));    
        
        $reg->save();        

        return redirect()->route('login')->with('success','Rejestracja przebiegła pomyślnie!');
    }
    
    public function show(){
        return view('registration');
    }
}
