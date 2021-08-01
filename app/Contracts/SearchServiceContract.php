<?php


namespace App\Contracts;


use App\Concerns\Searchable;
use App\Models\Article;

interface SearchServiceContract
{
    public function search(string $class, string $query);
    public function remove(Searchable $model);
    public function add(Searchable $model);
}
