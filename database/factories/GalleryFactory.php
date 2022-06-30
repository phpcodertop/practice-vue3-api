<?php
/**
 * Created by Ahmed Maher Halima.
 * Email: phpcodertop@gmail.com
 * github: https://github.com/phpcodertop
 * Date: 6/30/2022
 * Time: 5:01 AM
 */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GalleryFactory extends Factory {

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'path' => $this->faker->image('uploads/gallery')
        ];
    }
}
