<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;

class Type extends Model
{
    use HasFactory;


    public function Books()
    {
        return $this->belongsToMany(Book::class);
    }
}
