<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    public function definition()
    {
        $address = ['Yangon','Monywa','Mandalay','Pyay','NayPyiTaw','TaungGyi'];
        return [
            'title'=>$this->faker->sentence(10),
            'description'=>$this->faker->text(1000),
            'price'=>rand(2000,10000),
            'address'=>$address[array_rand($address)],
            'rating'=>rand(1,5),
        ];
    }
}
