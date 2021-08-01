<?php

namespace App\Models;

use App\Concerns\Searchable;
use App\Contracts\SearchServiceContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory, Searchable;

    protected $casts = [
        'tags' => 'array',
    ];

    public static function search(string $query)
    {
        $service = app()->make(SearchServiceContract::class);

        return $service->search(self::class, $query);
    }

    public function getSearchFields(): array
    {
        return ['title', 'text', 'description', 'author', 'tags', 'published_at'];
    }
}
