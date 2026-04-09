<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('status', '!=', 'Pending')->sum('total_amount');
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', 'Customer')->count();
        $lowStockProducts = Product::where('stock_quantity', '<', 5)->get();

        return view('admin.dashboard', compact('totalRevenue', 'totalOrders', 'totalCustomers', 'lowStockProducts'));
    }
}
