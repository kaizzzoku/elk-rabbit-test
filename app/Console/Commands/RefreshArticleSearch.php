<?php

namespace App\Console\Commands;
use App\Models\Article;
use Elasticsearch\Client;
use Illuminate\Console\Command;

class RefreshArticleSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh all articles in Elasticsearch';

    /** @var \Elasticsearch\Client */
    private $client;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (Article::cursor() as $article)
        {
            $this->client->index([
                'index' => $article->getSearchIndex(),
                'type' => $article->getSearchType(),
                'id' => $article->getKey(),
                'body' => $article->toSearchArray(),
            ]);
        }
    }
}
