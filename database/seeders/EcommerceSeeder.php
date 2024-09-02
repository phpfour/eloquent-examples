<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Product;
use App\Models\Shipping;
use Illuminate\Database\Seeder;

class EcommerceSeeder extends Seeder
{
    public function run(): void
    {
        // Create 1000 products
        Product::factory()->count(1000)->create();

        // Create 10000 orders with order lines and shipping
        Order::factory()
            ->count(1000)
            ->create()
            ->each(function ($order) {
                // Create 1-5 order lines for each order
                $orderLines = OrderLine::factory()
                    ->count(rand(1, 5))
                    ->make([
                        'product_id' => mt_rand(1, 1000)
                    ]);

                $order->orderLines()->saveMany($orderLines);

                // Calculate and update the total amount
                $totalAmount = $orderLines->sum(function ($orderLine) {
                    return $orderLine->quantity * $orderLine->price;
                });

                $order->update(['total_amount' => $totalAmount]);

                // Create shipping for the order
                Shipping::factory()->create(['order_id' => $order->id]);
            });
    }
}
