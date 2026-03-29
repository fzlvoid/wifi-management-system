<?php

use App\Models\User;
use App\Models\Customer;
use App\Models\Package;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('dashboard displays package name correctly', function () {
    $user = User::factory()->create();
    $package = Package::factory()->create(['package_name' => 'Ultra Fast 1Gbps']);
    $customer = Customer::factory()->create([
        'user_id' => $user->id,
        'package_id' => $package->id,
    ]);
    
    // Create a payment so the customer shows up in the dashboard summary/lists
    Payment::factory()->create([
        'customer_id' => $customer->id,
        'status' => 'PAID',
    ]);

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertStatus(200);
    $response->assertSee('Ultra Fast 1Gbps');
    $response->assertDontSee('"package_name":'); // Ensure the object is not rendered as JSON
});
