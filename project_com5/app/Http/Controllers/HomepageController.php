<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class HomepageController extends Controller
{
    public function submit(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = max(1, (int) $request->input('quantity', 1));

        $userId = Auth::user()?->id_user;
        if (!$userId) {
            return redirect()->route('login')->withErrors('Musisz być zalogowany, aby dodać produkt do koszyka.');
        }

        $product = Product::find($productId);

        $order = Order::firstOrCreate(
            ['user_id_user' => $userId, 'status' => 0],
            ['date_order' => now()]
        );

        $productOrder = ProductOrder::where('order_id_order', $order->id_order)
            ->where('product_id_product', $productId)
            ->first();

        if ($productOrder) {
            $newQuantity = $productOrder->quantity + $quantity;
            $newPrice = $newQuantity * $product->price;

            ProductOrder::where('order_id_order', $order->id_order)
                ->where('product_id_product', $productId)
                ->update([
                    'quantity' => $newQuantity,
                    'price' => $newPrice,
                ]);
        } else {
            ProductOrder::create([
                'order_id_order' => $order->id_order,
                'product_id_product' => $productId,
                'quantity' => $quantity,
                'price' => $quantity * $product->price,
            ]);
        }
        $totalPrice = ProductOrder::where('order_id_order', $order->id_order)->sum('price');
        $order->total_price = $totalPrice;
        $order->save();
        return redirect()->route('home')->with('success', 'Produkt dodany do koszyka.');
    }  
    
    public function cart()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->withErrors('Musisz być zalogowany, aby zobaczyć koszyk.');
        }
        
        $order = Order::where('user_id_user', $user->id_user)
                      ->where('status', 0)
                      ->first();

        $items = [];

        if ($order) {
            $items = ProductOrder::with('product')
                        ->where('order_id_order', $order->id_order)
                        ->get();
        }

        return view('cart', ['items' => $items]);
    }
    
    public function submitCart()
    {
        $userId = Auth::user()?->id_user;

    if (!$userId) {
        return redirect()->route('login')->withErrors('Musisz być zalogowany, aby złożyć zamówienie.');
    }

    $order = Order::where('user_id_user', $userId)
                  ->where('status', 0)
                  ->first();

    if (!$order) {
        return redirect()->route('cart')->withErrors('Nie masz żadnego aktywnego zamówienia.');
    }

    $order->status = 1;
    $order->date_order = now();
    $order->save();

    return redirect()->route('cart')->with('success', 'Zamówienie zostało złożone pomyślnie.');
    }
    
    public function show(){
        $products = Product::where('if_active', 1)->get();
        return view('home',['products' => $products]);
    }
}
