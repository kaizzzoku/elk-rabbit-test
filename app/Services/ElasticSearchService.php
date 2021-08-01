<?php


namespace App\Services;


use App\Concerns\Searchable;
use App\Contracts\SearchServiceContract;
use App\Models\Article;
use Elasticsearch\Client;

class ElasticSearchService implements SearchServiceContract
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function search(string $class, string $query = '')
    {
        if (in_array(Searchable::class, class_uses($class))) {
            $model = new $class;

            $items = $this->client->search([
                'index' => $model->getSearchIndex(),
                'type' => $model->getSearchType(),
                'body' => [
                    'query' => [
                        'multi_match' => [
                            'fields' => $model->getSearchFields(),
                            'query' => $query,
                        ],
                    ],
                ],
            ]);
        }
    }

    public function add(Searchable $model)
    {
        $this->client->index([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
            'body' => $model->toSearchArray(),
        ]);
    }

    public function remove(Searchable $model)
    {
        $this->client->delete([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
        ]);
    }
}
