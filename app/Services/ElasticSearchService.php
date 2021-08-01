<?php


namespace App\Services;


use App\Concerns\Searchable;
use App\Contracts\SearchServiceContract;
use App\Models\Article;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

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
                            'query' => "$query",
                        ],
                    ],
                ],
            ]);

            return $this->getModels($class, $items);
        }
    }

    public function add(Model $model)
    {
        $this->client->index([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
            'body' => $model->toSearchArray(),
        ]);
    }

    public function remove(Model $model)
    {
        $this->client->delete([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
        ]);
    }

    private function getModels(string $class, array $items)
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');

        return $class::findMany($ids);
    }
}
