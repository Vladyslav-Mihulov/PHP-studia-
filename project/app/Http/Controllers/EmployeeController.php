<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
class EmployeeController extends Controller
{
    public function show(){
        $orders = Order::with('productOrders.product')->get();

        return view('employee', compact('orders'));
    }
    
    public function showOrd(){
        $orders = Order::with('productOrders.product')
                   ->where('status', '<', 3)
                   ->where('status', '>', 0)
                   ->get();

        return view('employee', compact('orders'));
    }
    
    public function submit(Request $request)
    {
        $id = $request->input('id');
    $order = Order::findOrFail($id);

    if ($order->status < 3) {
        $order->status++;
        if ($order->status == 3) {
            $order->date_end_order = now();
        }
        $order->save();
    }

    $orders = Order::with('productOrders.product')->get();

    return redirect()->back()->with('success', 'Status zamówienia został zmieniony.');
    }
}
