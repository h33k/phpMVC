<?php
namespace App\Models;

use App\Model;

class Book extends Model
{
    protected $table = 'books';

    protected array $fillable = [
        'title',
        'author',
        'published_year',
        'genre',
    ];
}