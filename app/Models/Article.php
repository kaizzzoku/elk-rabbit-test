<?php

namespace App\Models;

use App\Concerns\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory, Searchable;

    protected $casts = [
        'tags' => 'array',
    ];

    public function getSearchFields(): array
    {
        return ['title', 'body', 'tags'];
    }
}
