<?php

namespace App\Providers;

use App\Contracts\SearchServiceContract;
use App\Models\Article;
use App\Observers\ArticleObserver;
use App\Services\ElasticSearchService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SearchServiceContract::class, function ($app) {
            return new ElasticSearchService($app->make(Client::class));
        } );

        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('services.search.hosts'))
                ->build();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Article::observe(ArticleObserver::class);
        Paginator::useBootstrap();
    }
}
