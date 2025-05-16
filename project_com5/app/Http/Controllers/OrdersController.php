<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function show(){
        if (!Auth::check()) {
        return redirect()->route('login')->withErrors('Musisz być zalogowany, aby zobaczyć swoje zamówienia.');
    }
        
        $user = Auth::user();

        $orders = Order::with('productOrders.product')
            ->where('user_id_user', $user->id_user)
            ->get();

        return view('orders', ['ord' => $orders]);
    }
}
