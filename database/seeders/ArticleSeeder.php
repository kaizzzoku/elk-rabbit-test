<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    private const TAGS = ['php', 'laravel', 'json', 'telegram', 'javascript', 'python', 'django', 'redis', 'cache', 'elasticsearch', 'kibana'];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    }

    public static function getRandomTags()
    {
        $tags = array_rand(array_flip(self::TAGS), random_int(1, 3));
        return is_array($tags) ? $tags : [$tags];
    }
}
