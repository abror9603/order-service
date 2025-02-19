<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();    
    }

    public function test_it_can_get_all_orders()
    {
        Order::factory(3)->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/orders');

        $response
        ->assertStatus(200)
        ->assertJsonCount(3);
    }

    public function test_it_can_get_one_order()
    {
       $order = Order::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user, 'sanctum')->getJson("/api/orders/{$order->id}");

        $response 
        ->assertStatus(200)
        ->assertJson(['id' => $order->id]);
    }

    public function test_it_can_create_new_order()
    {
         $data = [
            'user_id' => $this->user->id,
            'status' => 'pending',
            'total_price' => 150.50,
        ];

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/orders', $data);

        $response
        ->assertStatus(200)
        ->assertJson(["message" => "Create successfully order!"]);

        $this->assertDatabaseHas('orders', array_merge($data, ['user_id' => $this->user->id]));
    }

    public function test_it_can_update_an_order()
    {
        $order = Order::factory()->create(['user_id' => $this->user->id]);

        $updateData = ['status' => 'completed'];

        $response = $this->actingAs($this->user, 'sanctum')->patchJson("/api/orders/{$order->id}", $updateData);

        $this->assertEquals($this->user->id, $order->user_id);
        $response
        ->assertStatus(200)
        ->assertJson(['message' => 'Update successfully order!']);

        $this->assertDatabaseHas('orders', array_merge($updateData, ['id' => $order->id]));
    }

    public function test_it_can_delete_an_order()
    {
        $order = Order::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user, 'sanctum')->deleteJson("/api/orders/{$order->id}");

        $response
        ->assertStatus(200)
        ->assertJson(["message" => "Delete successfully order!"]);

        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }
}
