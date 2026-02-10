<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'books';
    protected $fillable = ['name', 
                            'subtitle', 
                            'slug', 
                            'edition', 
                            'isbn', 
                            'publication_date', 
                            'copyright', 
                            'publisher_id', 
                            'format', 
                            'paper_height', 
                            'paper_width', 
                            'cover_height', 
                            'cover_width', 
                            'pages', 
                            'color', 
                            'category_id',
                            'sku', 
                            'file_url', 
                            'print_file_url',
                            'total_cost', 
                            'editor', 
                            'researcher', 
                            'writer', 
                            'graphic_designer', 
                            'layout_designer', 
                            'photographer', 
                            'markup_fee'];



    public function category()
    {
        return $this->belongsTo(BookCategory::class)->withTrashed();
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_authors')->withTrashed();
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class)->withTrashed();
    }

    public function agencies()
    {
        return $this->belongsToMany(Agency::class, 'book_agencies')->withTrashed();
    }

    public function receiving_details()
    {
        return $this->hasMany(ReceivingDetail::class);
    }

    public function setNameAttribute($value)
    {
        // Define a pattern to match uppercase words (possible acronyms)
        $pattern = '/\b[A-Z]{2,}\b/';
        
        // Replace each acronym with its original form
        $acronyms = [];
        preg_match_all($pattern, $value, $matches);
        foreach ($matches[0] as $acronym) {
            $acronyms[$acronym] = $acronym;
        }
        
        // Convert the entire string to lowercase and then capitalize each word
        $value = ucwords(strtolower($value));
        
        // Restore the acronyms to their uppercase form
        foreach ($acronyms as $acronym) {
            $value = str_replace(ucwords(strtolower($acronym)), $acronym, $value);
        }
        
        // Set the formatted name
        $this->attributes['name'] = $value;
    }

    protected function getInventoryAttribute()
    {
        $total_received = ReceivingDetail::where('book_id', $this->id)
            ->where('receiving_headers.status', 'POSTED')
            ->join('receiving_headers', 'receiving_headers.id', '=', 'receiving_details.receiving_header_id')
            ->groupBy('book_id')
            ->sum('receiving_details.quantity');
        
        $total_issued = IssuanceDetail::where('book_id', $this->id)
            ->where('issuance_headers.status', 'POSTED')
            ->join('issuance_headers', 'issuance_headers.id', '=', 'issuance_details.issuance_header_id')
            ->groupBy('book_id')
            ->sum('issuance_details.quantity');

        $inventory = $total_received - $total_issued;

        return $inventory > 0 ? $inventory : 0;
    }
}
