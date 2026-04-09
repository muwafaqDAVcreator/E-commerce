<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        return view('store.checkout', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $request->validate([
            'shipping_address' => 'required|string|max:1000',
            'payment_method' => 'required|in:stripe,cod',
        ]);

        $user = Auth::user();
        $user->update(['shipping_address' => $request->shipping_address]);

        $total = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
                'status' => 'Pending',
                'payment_status' => $request->payment_method === 'cod' ? 'COD (Unpaid)' : 'Unpaid',
            ]);

            $lineItems = [];

            foreach ($cart as $id => $details) {
                $product = Product::lockForUpdate()->find($id);
                if (!$product || $product->stock_quantity < $details['quantity']) {
                    throw new \Exception('Product ' . $details['name'] . ' is out of stock.');
                }

                $product->decrement('stock_quantity', $details['quantity']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price_at_purchase' => $details['price']
                ]);

                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $details['name'],
                        ],
                        'unit_amount' => (int)($details['price'] * 100),
                    ],
                    'quantity' => $details['quantity'],
                ];
            }

            DB::commit();

            // Handle Cash on Delivery (COD) Bypass
            if ($request->payment_method === 'cod') {
                return redirect()->route('checkout.success', ['order' => $order->id])
                    ->with('success', 'Order placed! You will pay cash upon delivery.');
            }

            // Handle Stripe Flow
            $stripeSecret = env('STRIPE_SECRET');
            
            if (empty($stripeSecret)) {
                // MOCK MODE: Bypass Stripe entirely for demo purposes if no API key is provided
                return redirect()->route('checkout.success', ['order' => $order->id])
                    ->with('success', 'Development Mode: Stripe checkout skipped. Order marked as paid locally.');
            }

            Stripe::setApiKey($stripeSecret);

            $checkoutSession = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success', ['order' => $order->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel', ['order' => $order->id]),
                'client_reference_id' => $order->id,
            ]);

            return redirect($checkoutSession->url);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }

    public function success(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Only mark as Paid if the order was originally expecting a Stripe Payment 
        if ($order->payment_status === 'Unpaid') {
            $order->update(['payment_status' => 'Paid']);
        }

        session()->forget('cart');

        return view('store.checkout-success', compact('order'));
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->payment_status === 'Unpaid') {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock_quantity', $item->quantity);
                }
            }
            $order->delete();
        }

        return redirect()->route('cart.index')->with('error', 'Payment cancelled. Your order was not completed.');
    }
}
