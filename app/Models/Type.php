<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // public function Books()
    // {
    //     return $this->belongsToMany(Book::class);
    // }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function type()
    {
        return $this->hasMany(Type::class);
    }
}
