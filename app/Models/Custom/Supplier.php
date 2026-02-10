<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'suppliers';
    protected $fillable = ['name', 'address', 'cellphone_no', 'telephone_no'];


    public function receiving_headers()
    {
        return $this->hasMany(ReceivingHeader::class);
    }
    
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
        $this->attributes['address'] = ucwords(strtolower($value));
    }
}
