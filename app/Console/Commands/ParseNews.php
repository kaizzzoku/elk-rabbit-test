<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ParseNews extends Command
{
    private const API_URL = 'https://newsapi.org/v2/everything';
    private const API_SEARCH_OBJECT = 'PHP';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $news = $this->parseNews();
        $prepared_news = $this->prepareNews($news);

        $created = Article::insert($prepared_news);

        print(count($prepared_news)." news parsed.\n");

        return 0;
    }

    private function parseNews()
    {
        return Http::get(self::API_URL, [
            'q' => self::API_SEARCH_OBJECT,
            'apiKey' => config('services.newsapi.key'),
        ])->json();
    }

    private function prepareNews(array $news)
    {
        $now = (string) now();
        return array_map(function ($a) use ($now) {
            return [
                'title' => $a['title'],
                'description' =>  $a['description'],
                'text' =>  $a['content'],
                'author' =>  $a['author'],
                'published_at' =>  $a['publishedAt'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $news['articles']);
    }
}
