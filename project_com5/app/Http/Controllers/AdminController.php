<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 

class AdminController extends Controller
{
    public function show(){
        $users = User::with('roles')->get();
        return view('admin', compact('users'));
    }
}
