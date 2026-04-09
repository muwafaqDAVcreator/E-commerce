<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('store.cart', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        
        $product = Product::findOrFail($request->product_id);
        
        if ($product->stock_quantity < 1) {
            return back()->with('error', 'This product is out of stock.');
        }

        $cart = session()->get('cart', []);

        if(isset($cart[$product->id])) {
            if ($cart[$product->id]['quantity'] >= $product->stock_quantity) {
                return back()->with('error', 'Not enough stock available.');
            }
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image_path' => $product->image_path
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        
        $cart = session()->get('cart');
        $product = Product::findOrFail($id);

        if(isset($cart[$id])) {
            if ($request->quantity > $product->stock_quantity) {
                return back()->with('error', 'Not enough stock available.');
            }
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return back()->with('success', 'Cart updated successfully.');
        }
        return back();
    }

    public function destroy($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Product removed from cart.');
    }
}
