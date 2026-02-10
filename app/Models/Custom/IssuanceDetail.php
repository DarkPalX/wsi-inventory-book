<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssuanceDetail extends Model
{
    use HasFactory;

    protected $table = 'issuance_details';
    protected $fillable = ['issuance_header_id', 'book_id', 'sku', 'quantity', 'cost'];


    public function book()
    {
        return $this->belongsTo(Book::class)->withTrashed();
    }
}
