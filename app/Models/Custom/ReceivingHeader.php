<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceivingHeader extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'receiving_headers';
    protected $fillable = ['supplier_id', 'date_received', 'book_cover', 'attachments', 'remarks','status', 'created_by', 'updated_by', 'posted_at', 'posted_by', 'cancelled_at', 'cancelled_by'];


    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
