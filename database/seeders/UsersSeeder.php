<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Order;
use App\Models\Part;
use App\Models\Cart;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    User::create(
      [
        'username' => 'brengeley',
        'email' => 'b.rob.tracy@gmail.com',
        'password' => bcrypt('password'),
        'remember_token' => null,
      ],
    );

    User::factory(10)->create()->each(function ($user) {

      // Create a cart for the user
      $cart = Cart::factory()->create(['user_id' => $user->id]);

      // Create some orders for the user
      Order::factory(3)->create(['user_id' => $user->id])->each(function ($order) use ($cart) {
        // Create some parts to add to the order
        Part::factory(5)->create(['order_id' => $order->id]);
      });

      $parts = Part::factory(5)->create();
      //Save some parts
      $user->parts()->attach($parts->random(2));

      // Put some parts in their cart, why not
      $cart->parts()->attach($parts->random(2));

    });
  }
}
