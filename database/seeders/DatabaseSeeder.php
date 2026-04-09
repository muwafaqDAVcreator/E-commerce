<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        $admin = User::firstOrCreate(['email' => 'admin@techparts.test'], [
            'name' => 'Admin User',
            'password' => Hash::make('password'),
            'role' => 'Admin',
            'email_verified_at' => now(),
            'shipping_address' => '123 Admin Lane, Cyber City, 99999'
        ]);

        $support = User::firstOrCreate(['email' => 'support@techparts.test'], [
            'name' => 'Support User',
            'password' => Hash::make('password'),
            'role' => 'Support',
            'email_verified_at' => now(),
            'shipping_address' => '404 Helpdesk Rd, Service Town, 88888'
        ]);

        $customer = User::firstOrCreate(['email' => 'customer@techparts.test'], [
            'name' => 'John Customer',
            'password' => Hash::make('password'),
            'role' => 'Customer',
            'email_verified_at' => now(),
            'shipping_address' => '123 Consumer Blvd, Market City, 11111'
        ]);

        // Categories
        $catCPU = Category::firstOrCreate(['name' => 'Processors (CPU)']);
        $catGPU = Category::firstOrCreate(['name' => 'Graphics Cards (GPU)']);
        $catMom = Category::firstOrCreate(['name' => 'Motherboards']);
        $catRAM = Category::firstOrCreate(['name' => 'Memory (RAM)']);

        // Brands
        $brandIntel = Brand::firstOrCreate(['name' => 'Intel']);
        $brandAMD = Brand::firstOrCreate(['name' => 'AMD']);
        $brandNvidia = Brand::firstOrCreate(['name' => 'NVIDIA']);
        $brandCorsair = Brand::firstOrCreate(['name' => 'Corsair']);
        $brandAsus = Brand::firstOrCreate(['name' => 'ASUS']);

        // Products
        $p1 = Product::firstOrCreate(['name' => 'Intel Core i9-14900K'], [
            'description' => "24 cores (8 P-cores + 16 E-cores) and 32 threads. Integrated Intel UHD Graphics 770 included.\nMax Turbo Frequency Up to 6.0 GHz.",
            'price' => 589.99,
            'stock_quantity' => 25,
            'category_id' => $catCPU->id,
            'brand_id' => $brandIntel->id,
            'image_path' => 'products/cpu_intel.png'
        ]);

        $p2 = Product::firstOrCreate(['name' => 'AMD Ryzen 7 7800X3D'], [
            'description' => "8 Cores & 16 Threads, 104MB Cache, Up to 5.0 GHz Max Boost.\nSocket AM5, PCIe 5.0.",
            'price' => 399.00,
            'stock_quantity' => 15,
            'category_id' => $catCPU->id,
            'brand_id' => $brandAMD->id,
            'image_path' => 'products/cpu_amd.png'
        ]);

        $p3 = Product::firstOrCreate(['name' => 'ASUS ROG Strix GeForce RTX 4090'], [
            'description' => "24GB GDDR6X, Up to 2550 MHz boost clock.\nThe ultimate GPU for 4K gaming.",
            'price' => 1999.99,
            'stock_quantity' => 5,
            'category_id' => $catGPU->id,
            'brand_id' => $brandAsus->id,
            'image_path' => 'products/gpu_asus.png'
        ]);

        $p4 = Product::firstOrCreate(['name' => 'Corsair Vengeance RGB 32GB (2x16GB) DDR5'], [
            'description' => "6000MHz C36 Desktop Memory. Dynamic multizone RGB lighting.",
            'price' => 114.99,
            'stock_quantity' => 50,
            'category_id' => $catRAM->id,
            'brand_id' => $brandCorsair->id,
            'image_path' => 'products/ram_corsair.png'
        ]);

        // Reviews
        Review::firstOrCreate(['user_id' => $customer->id, 'product_id' => $p2->id], [
            'rating' => 5,
            'comment' => 'Incredible gaming CPU. Easily hits top frames compared to my old setup.'
        ]);

        // Orders (Test Data)
        $order = \App\Models\Order::firstOrCreate(['user_id' => $customer->id], [
            'total_amount' => $p1->price,
            'status' => 'Delivered',
            'payment_status' => 'Paid',
            'tracking_number' => 'TRK-9876543210'
        ]);

        \App\Models\OrderItem::firstOrCreate([
            'order_id' => $order->id,
            'product_id' => $p1->id
        ], [
            'quantity' => 1,
            'price' => $p1->price
        ]);

        // Wishlists
        \App\Models\Wishlist::firstOrCreate(['user_id' => $customer->id, 'product_id' => $p3->id]);
    }
}
