<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RBACTest extends TestCase
{
    use RefreshDatabase;

    private function createUser($role)
    {
        return User::create([
            'name' => 'Test', 
            'email' => uniqid() . '@test.com', 
            'password' => 'password', 
            'role' => $role, 
            'email_verified_at' => now(),
            'shipping_address' => 'None'
        ]);
    }

    public function test_customer_cannot_access_admin_panel()
    {
        $customer = $this->createUser('Customer');
        $response = $this->actingAs($customer)->get('/admin/dashboard');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_panel()
    {
        $admin = $this->createUser('Admin');
        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    public function test_support_cannot_access_admin_panel()
    {
        $support = $this->createUser('Support');
        $response = $this->actingAs($support)->get('/admin/dashboard');
        $response->assertStatus(403);
    }

    public function test_support_can_access_support_panel()
    {
        $support = $this->createUser('Support');
        $response = $this->actingAs($support)->get('/support/tickets');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_support_panel()
    {
        $admin = $this->createUser('Admin');
        $response = $this->actingAs($admin)->get('/support/tickets');
        $response->assertStatus(200);
    }
}
