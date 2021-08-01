<?php

namespace Database\Factories;

use App\Models\Article;
use Database\Seeders\ArticleSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'author' => $this->faker->name ,
            'text' => $this->faker->realText(1000),
            'description' => $this->faker->realText(200),
            'tags' => ArticleSeeder::getRandomTags(),
            'title' => random_int(0, 1) ? $this->faker->catchPhrase : $this->faker->bs,
            'published_at' => $this->faker->dateTime,
        ];
    }
}
