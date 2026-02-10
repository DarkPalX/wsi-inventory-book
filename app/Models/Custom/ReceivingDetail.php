<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivingDetail extends Model
{
    use HasFactory;
    
    protected $table = 'receiving_details';
    protected $fillable = ['receiving_header_id', 'book_id', 'sku', 'quantity'];


    public function book()
    {
        return $this->belongsTo(Book::class)->withTrashed();
    }

}
