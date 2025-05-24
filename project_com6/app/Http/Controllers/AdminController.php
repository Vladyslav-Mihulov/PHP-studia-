<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 

class AdminController extends Controller
{
    public function show(Request $request)
    {
        $search = $request->input('search');

        $query = User::query();

        if ($search) {
            $query->where('login', 'like', "%{$search}%");
        }

        $users = $query->paginate(5)->withQueryString();

       
        if ($request->ajax()) {
            return view('admin', compact('users', 'search'))->renderSections()['content'];
        }


        return view('admin', compact('users', 'search'));
    }


}
