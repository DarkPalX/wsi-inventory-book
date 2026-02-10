<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IssuanceHeader extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'issuance_headers';
    protected $fillable = ['receiver_id', 'date_released', 'attachments', 'remarks', 'status', 'created_by', 'updated_by', 'posted_at', 'posted_by', 'cancelled_at', 'cancelled_by'];


    public function receiver()
    {
        return $this->belongsTo(Receiver::class);
    }
}
