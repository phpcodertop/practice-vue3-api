<?php

namespace Database\Factories;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->realText(50);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => implode("<br />",$this->faker->paragraphs(6)),
            'published' => true,
            'author_id' => function() {
                return User::factory()->create()->id;
            }
        ];
    }
}
