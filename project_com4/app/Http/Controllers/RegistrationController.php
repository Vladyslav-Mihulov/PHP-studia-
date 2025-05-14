<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class RegistrationController extends Controller
{
    
        public function submit(RegistrationRequest $req){
        
        if (User::where('login', $req->input('login'))->exists()) {
            return Redirect::back()->withErrors(['login' => 'Ten login jest już zajęty.'])->withInput();
        }

        if (User::where('email', $req->input('email'))->exists()) {
            return Redirect::back()->withErrors(['email' => 'Ten adres email jest już zajęty.'])->withInput();
        } 
        $reg = new User();
        $reg->login = $req-> input('login');
        $reg->email = $req-> input('email');
        $reg->first_name = $req-> input('fname');
        $reg->last_name = $req-> input('lname');
        $reg->password = Hash::make($req->input('password1')); 
        $reg->who_created = 0; 
        $reg->who_modify = 0; 
        $reg->save();
        
        $reg->who_created = $reg->id_user;  
        $reg->who_modify = $reg->id_user;   

        $reg->save();
        
        $role = Role::where('role_name', 'user')->where('active', '1')->first();
        
        if ($role) {
            UserRole::create([
                'user_id_user' => $reg->id_user,
                'role_id_role' => $role->id_role,
                'date_start1' => now(),
                'date_end1' => null,
            ]);
        }
        return redirect()->route('login')->with('success','Rejestracja przebiegła pomyślnie!');
    }
    
    public function show(){
        return view('registration');
    }
}
