<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookModel;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function addToCart($bookId)
    {
        $book = BookModel::findOrFail($bookId);

        $cart = session()->get('cart', []);

        if (isset($cart[$bookId])) {
            $cart[$bookId]['qty']++;
        } else {
            $cart[$bookId] = [
                'title' => $book->title,
                'price' => $book->price,
                'qty'   => 1,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'เพิ่มเข้าตะกร้าแล้ว');
    }

    public function clearCart()
    {
        session()->forget('cart');
        return back()->with('success', 'ลบตะกร้าแล้ว');
    }
}
