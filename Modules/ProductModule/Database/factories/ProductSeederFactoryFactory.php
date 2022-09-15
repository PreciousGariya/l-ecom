<?php

namespace Modules\ProductModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
class ProductSeederFactoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\ProductModule\Entities\ProductSeederFactory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->getFaker();
        return [
            'title'=> $this->faker->Pro(),
            'keywords'=> $this->faker->name(),
            'short_description'=> $this->faker->name(),
            'image'=> $this->faker->name(),
            'category_id'=> $this->faker->name(),
            'long_description'=> $this->faker->name(),
            'price'=> $this->faker->name(),
            'discount_price'=> $this->faker->name(),
            'stock'=> $this->faker->name(),
            'user_id'=> $this->faker->name(),
            'is_status'
        ];
    }
}

