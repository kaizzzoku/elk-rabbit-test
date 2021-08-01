<?php


namespace App\Contracts;


use App\Concerns\Searchable;
use App\Models\Article;
use Illuminate\Database\Eloquent\Model;

interface SearchServiceContract
{
    public function search(string $class, string $query);
    public function remove(Model $model);
    public function add(Model $model);
}
