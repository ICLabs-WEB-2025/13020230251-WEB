<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'author', 'publisher', 'year', 'isbn', 'status', 'stock'];

    protected $dates = ['deleted_at'];
}