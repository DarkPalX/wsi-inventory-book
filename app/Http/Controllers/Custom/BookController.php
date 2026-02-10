<?php

namespace App\Http\Controllers\Custom;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\BookRequest;


use Facades\App\Helpers\{ListingHelper, FileHelper};

use App\Models\{Page};
use App\Helpers\ModelHelper;
use App\Models\Custom\{Book, BookCategory, Author, BookAuthor, Publisher, Agency, BookAgency, ReceivingHeader, ReceivingDetail, IssuanceHeader, IssuanceDetail};
use DB;

class BookController extends Controller
{
    private $searchFields = ['name', 'sku'];

    public function index()
    {
        $page = new Page();
        $page->name = "Books";

        $books = ListingHelper::simple_search(Book::class, $this->searchFields);

        $filter = ListingHelper::get_filter($this->searchFields);
 
        $searchType = 'simple_search';

       return view('theme.pages.custom.books.index', compact('page', 'books', 'filter', 'searchType'));
    }

    public function create()
    {
        $page = new Page();
        $page->name = "Books";

        $categories = BookCategory::all();
        $authors = Author::all();
        $publishers = Publisher::all();
        $agencies = Agency::all();

       return view('theme.pages.custom.books.create', compact('page', 'categories', 'authors', 'publishers', 'agencies'));
    }

    public function store(BookRequest $request)
    {
        $sku_exists = Book::where('sku', $request->sku)->exists();
        if ($sku_exists) {
            throw ValidationException::withMessages([
                'sku' => 'The sku has already been taken.',
            ]);
        }
        
        $requestData = $request->validated();
        $requestData['slug'] = ModelHelper::convert_to_slug(Book::class, $request->name);

        $book = Book::create($requestData);

        // FOR FILE UPLOADS
        $file_url = $request->hasFile('file_url') ? FileHelper::move_to_files_folder($request->file('file_url'), 'attachments/books/'. $book->slug)['url'] : null;
        $book->update([
            'file_url' => $file_url
        ]);
        
        $print_file_url = $request->hasFile('print_file_url') ? FileHelper::move_to_files_folder($request->file('print_file_url'), 'attachments/books/'. $book->slug)['url'] : null;
        $book->update([
            'print_file_url' => $print_file_url
        ]);


        // FOR FORMATS
        if (!empty($request->format)) {
            $extension = implode(',', $request->format);
        
            $book->update([
                'format' => $extension
            ]);
        }

        // FOR PUBLISHER
        if (!empty($request->publisher_id)) {

            $publisher = $request->publisher_id;

            if(filter_var($publisher, FILTER_VALIDATE_INT) == false){
                $new_publisher = Publisher::create([
                    'name' => $publisher
                ]);
                $publisher = $new_publisher->id;
            }

            $book->update([
                'publisher_id' => $publisher
            ]);
        }

        // FOR AUTHORS
        if (!empty($request->author_id)) {
            foreach($request->author_id as $author){
                if(filter_var($author, FILTER_VALIDATE_INT) == false){
                    $new_author = Author::create([
                        'name' => $author
                    ]);
                    $author = $new_author->id;
                }

                BookAuthor::create([
                    'book_id' => $book->id,
                    'author_id' => $author
                ]);
            }
        }

        // FOR AGENCY
        if (!empty($request->agency_id)) {
            foreach($request->agency_id as $agency){
                if(filter_var($agency, FILTER_VALIDATE_INT) == false){
                    $new_agency = Agency::create([
                        'name' => $agency
                    ]);
                    $agency = $new_agency->id;
                }
                BookAgency::create([
                    'book_id' => $book->id,
                    'agency_id' => $agency
                ]);
            }
        }

       return redirect()->route('books.index')->with('alert', 'success:Well done! You successfully added a book');
    }

    public function show($id)
    {
        $page = new Page();
        $page->name = "Book Details";

        $book = Book::withTrashed()->find($id);
        $categories = BookCategory::all();
        $authors = Author::all();
        $publishers = Publisher::all();
        $agencies = Agency::all();


       return view('theme.pages.custom.books.show', compact('page', 'book', 'categories', 'authors', 'publishers', 'agencies'));
    }
    
    public function stock_card($id){
        $page = new Page();
        $page->name = "Stock Card";

        $book = Book::find($id);

        $receiving_transactions = ReceivingHeader::where('receiving_headers.status', 'POSTED')
        ->join('receiving_details', 'receiving_details.receiving_header_id', '=', 'receiving_headers.id')
        ->where('receiving_details.book_id', $id)
        ->select('receiving_headers.posted_at', 'receiving_details.quantity', 'receiving_headers.id', DB::raw("'Receiving' as type"))
        ->get();

        $issuance_transactions = IssuanceHeader::where('issuance_headers.status', 'POSTED')
        ->join('issuance_details', 'issuance_details.issuance_header_id', '=', 'issuance_headers.id')
        ->where('issuance_details.book_id', $id)
        ->select('issuance_headers.posted_at', 'issuance_details.quantity', 'issuance_headers.id', DB::raw("'Issuance' as type"))
        ->get();

        $transactions = $receiving_transactions->merge($issuance_transactions);

        $sorted_transactions = $transactions->sortBy('posted_at')->values();

        $running_balance = 0;
        $stock_card = [];

        foreach ($sorted_transactions as $transaction) {
            if ($transaction->type === 'Receiving') {
                $running_balance += $transaction->quantity;
            } else if ($transaction->type === 'Issuance') {
                $running_balance -= $transaction->quantity;
            }

            $stock_card[] = [
                'date' => $transaction->posted_at,
                'type' => $transaction->type,
                'transaction_id' => $transaction->id,
                'quantity' => $transaction->quantity,
                'running_balance' => $running_balance
            ];
        }

       return view('theme.pages.custom.books.stock-card', compact('page', 'book', 'stock_card'));
    }

    public function edit(Book $book)
    {
        $page = new Page();
        $page->name = "Books";

        $categories = BookCategory::all();
        $authors = Author::all();
        $publishers = Publisher::all();
        $agencies = Agency::all();

       return view('theme.pages.custom.books.edit', compact('page', 'book', 'categories', 'authors', 'publishers', 'agencies'));
    }

    public function update(BookRequest $request, Book $book)
    {
        $sku_exists = Book::where('id', '<>', $book->id)->where('sku', $request->sku)->exists();
        if ($sku_exists) {
            throw ValidationException::withMessages([
                'sku' => 'The sku has already been taken.',
            ]);
        }

        $requestData = $request->validated();
        $requestData['slug'] = ModelHelper::convert_to_slug(Book::class, $request->name);

        $book->update($requestData);
        
        // FOR FILE UPLOADS

        if($request->hasFile('file_url')){
            $file_url = $request->hasFile('file_url') ? FileHelper::move_to_files_folder($request->file('file_url'), 'attachments/books/'. $book->slug)['url'] : null;
            $book->update([
                'file_url' => $file_url
            ]);
        }

        if($request->hasFile('print_file_url')){
            $print_file_url = $request->hasFile('print_file_url') ? FileHelper::move_to_files_folder($request->file('print_file_url'), 'attachments/books/'. $book->slug)['url'] : null;
            $book->update([
                'print_file_url' => $print_file_url
            ]);
        }

        // FOR FORMATS
        if (!empty($request->format)) {
            $extension = implode(',', $request->format);
        
            $book->update([
                'format' => $extension
            ]);
        }

        // FOR PUBLISHER
        if (!empty($request->publisher_id)) {

            $publisher = $request->publisher_id;

            if(filter_var($publisher, FILTER_VALIDATE_INT) == false){
                $new_publisher = Publisher::create([
                    'name' => $publisher
                ]);
                $publisher = $new_publisher->id;
            }

            $book->update([
                'publisher_id' => $publisher
            ]);
        }

        // FOR AUTHORS
        BookAuthor::where('book_id', $book->id)->delete();
        if (!empty($request->author_id)) {
            foreach($request->author_id as $author){
                if(filter_var($author, FILTER_VALIDATE_INT) == false){
                    $new_author = Author::create([
                        'name' => $author
                    ]);
                    $author = $new_author->id;
                }

                BookAuthor::create([
                    'book_id' => $book->id,
                    'author_id' => $author
                ]);
            }
        }

        // FOR AGENCY
        BookAgency::where('book_id', $book->id)->delete();
        if (!empty($request->agency_id)) {
            foreach($request->agency_id as $agency){
                if(filter_var($agency, FILTER_VALIDATE_INT) == false){
                    $new_agency = Agency::create([
                        'name' => $agency
                    ]);
                    $agency = $new_agency->id;
                }
                BookAgency::create([
                    'book_id' => $book->id,
                    'agency_id' => $agency
                ]);
            }
        }

       return redirect()->route('books.index')->with('alert', 'success:Well done! You successfully updated a book');
    }

    public function single_delete(Request $request)
    {
        $book = Book::findOrFail($request->books);
        $book->delete();

        return redirect()->back()->with('alert', 'success:Well done! You successfully deleted a book');
    }

    public function multiple_delete(Request $request)
    {
        $books = explode("|",$request->books);

        foreach($books as $book){
            Book::whereId((int) $book)->delete();
        }

        return redirect()->back()->with('alert', 'success:Well done! You successfully deleted multiple books');
    }

    public function single_restore(Request $request)
    {
        $book = Book::withTrashed()->findOrFail($request->books);
        $book->restore();

        return redirect()->back()->with('alert', 'success:Well done! You successfully restored an book');
    }

    public function multiple_restore(Request $request)
    {
        $books = explode("|",$request->books);

        foreach($books as $book){
            Book::withTrashed()->whereId((int) $book)->restore();
        }

        return redirect()->back()->with('alert', 'success:Well done! You successfully restored multiple books');
    }
    
}
