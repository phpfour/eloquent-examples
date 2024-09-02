<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Shipping;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ShippingFactory extends Factory
{
    protected $model = Shipping::class;

    public function definition()
    {
        return [
            'order_id' => Order::factory(),
            'address' => $this->faker->address(),
            'status' => $this->faker->randomElement(['pending', 'in_transit', 'delivered']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
