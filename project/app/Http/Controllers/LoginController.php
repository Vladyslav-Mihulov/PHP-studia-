<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller {
    
    public function submit(LoginRequest $req)
    {
        $log = $req->input('login');
        $pass = $req->input('password');


        if (
                Auth::attempt(['login' => $log, 'password' => $pass]) ||
                Auth::attempt(['email' => $log, 'password' => $pass])
            ) {
             $user = Auth::user();   
             /*session([
                'user_id' => $user->user_id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'login' => $user->login,
            ]); */
             
            return redirect()->route('profile')->with('success', 'Logowanie zakończone pomyślnie.');
            }
            
            

     
            
        return redirect()->back()
            ->withErrors(['login' => 'Nieprawidłowy login lub hasło'])
            ->withInput();
    }
    
    public function show()
    {
        if (Auth::check()) {
        return redirect()->route('profile');
    }

        return view('login');
    }
    
    public function showProfile()
    {
        
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    $user = Auth::user();
    return view('profile', compact('user'));
    }
    
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
