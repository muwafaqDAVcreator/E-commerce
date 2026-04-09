<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\Wishlist;
use App\Models\Review;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $orders = Order::with('items.product')->where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $tickets = Ticket::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $wishlists = Wishlist::with('product')->where('user_id', $user->id)->get();
        $reviews = Review::with('product')->where('user_id', $user->id)->get();

        return view('store.dashboard', compact('orders', 'tickets', 'wishlists', 'reviews', 'user'));
    }
}
