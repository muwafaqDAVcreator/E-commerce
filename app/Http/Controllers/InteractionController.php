<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Wishlist;
use App\Models\Ticket;
use App\Models\Product;

class InteractionController extends Controller
{
    public function storeReview(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000'
        ]);

        Review::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $product->id],
            ['rating' => $request->rating, 'comment' => $request->comment]
        );

        return back()->with('success', 'Your review has been submitted.');
    }

    public function toggleWishlist(Product $product)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->where('product_id', $product->id)->first();
        
        if ($wishlist) {
            $wishlist->delete();
            return back()->with('success', 'Removed from wishlist.');
        } else {
            Wishlist::create(['user_id' => Auth::id(), 'product_id' => $product->id]);
            return back()->with('success', 'Added to wishlist.');
        }
    }

    public function removeWishlist(Wishlist $wishlist)
    {
        if ($wishlist->user_id === Auth::id()) {
            $wishlist->delete();
            return back()->with('success', 'Removed from wishlist.');
        }
        abort(403);
    }

    public function storeTicket(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'product_id' => 'nullable|exists:products,id'
        ]);

        Ticket::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'Open'
        ]);

        return redirect()->route('dashboard')->with('success', 'Support ticket submitted successfully.');
    }
}
