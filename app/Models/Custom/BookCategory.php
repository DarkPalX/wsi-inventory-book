<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookCategory extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'book_categories';
    protected $fillable = ['name', 'slug', 'description', 'order'];

    

    public function books()
    {
        return $this->hasMany(Book::class);
    }
    
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

}