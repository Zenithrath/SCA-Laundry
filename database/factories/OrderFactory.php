<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $statuses = ['Selesai', 'Menunggu', 'Dicuci', 'Disetrika'];
        
        return [
            'order_code' => 'ORD-' . strtoupper($this->faker->bothify('??###')),
            'user_id' => 1, 
            'service_id' => Service::inRandomOrder()->first()->id ?? 1,
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'pickup_address' => $this->faker->address(),
            'pickup_date' => $this->faker->date(),
            'pickup_time' => $this->faker->time('H:i'),
            'weight' => $this->faker->numberBetween(1, 50),
            'total_price' => $this->faker->numberBetween(50000, 500000),
            'status' => $this->faker->randomElement($statuses),
            'created_at' => Carbon::now()->subDays($this->faker->numberBetween(0, 90)),
            'updated_at' => Carbon::now(),
        ];
    }
}
