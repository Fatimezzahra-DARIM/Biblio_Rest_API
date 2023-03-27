<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Type;


class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'content',
        'publication_Date',
        'number_of_pages',
        'location',
        'Status',
        'type_id',
        'collection_id',
        'user_id',
    ];
    protected $hidden =[
        'created_at',
        'updated_at',
    ];
    public function type(){
        return $this->belongsTo(Type::class);
    }
    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
}
