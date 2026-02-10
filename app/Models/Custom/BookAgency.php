<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookAgency extends Model
{
    use HasFactory;
    
    protected $table = 'book_agencies';
    protected $fillable = ['book_id', 'agency_id'];
    

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}
