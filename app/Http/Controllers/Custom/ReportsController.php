<?php

namespace App\Http\Controllers\Custom;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Facades\App\Helpers\{ListingHelper, FileHelper};

use App\Models\{Page};
use App\Models\Custom\{Book, IssuanceHeader, IssuanceDetail, Receiver, ReceivingHeader, ReceivingDetail};
use App\Models\{User, ActivityLog};
use Auth;
use DB;


class ReportsController extends Controller

{
    private $paginate = 1000;
    private $searchFields = ['id'];

    public function issuance(){
        $page = new Page();
        $page->name = "Issuance Report";
    
        $transactions = IssuanceHeader::select('*')->where('deleted_at', null)->paginate($this->paginate);

        $filter = ListingHelper::get_filter($this->searchFields);

        $searchType = 'simple_search';

       return view('theme.pages.custom.reports.issuance', compact('page', 'transactions', 'filter', 'searchType'));
    }

    public function receiving(){
        $page = new Page();
        $page->name = "Receiving Stock Report";

        $transactions = ReceivingHeader::select('*')->where('deleted_at', null)->paginate($this->paginate);

        $filter = ListingHelper::get_filter($this->searchFields);

        $searchType = 'simple_search';

       return view('theme.pages.custom.reports.receiving', compact('page', 'transactions', 'filter', 'searchType'));
    }

    public function stock_card(Request $request){

        $page = new Page();
        $page->name = "Stock Card";

        $books = Book::all();

        if($request->all() != []){

            $book = Book::find($request->id);

            $receiving_transactions = ReceivingHeader::where('receiving_headers.status', 'POSTED')
            ->join('receiving_details', 'receiving_details.receiving_header_id', '=', 'receiving_headers.id')
            ->where('receiving_details.book_id', $request->id)
            ->select('receiving_headers.posted_at', 'receiving_details.quantity', 'receiving_headers.id', DB::raw("'Receiving' as type"))
            ->get();

            $issuance_transactions = IssuanceHeader::where('issuance_headers.status', 'POSTED')
            ->join('issuance_details', 'issuance_details.issuance_header_id', '=', 'issuance_headers.id')
            ->where('issuance_details.book_id', $request->id)
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

        }
        else{
            $book = new Book();
            $book->id = null;
            $book->name = null;
            $book->Inventory = null;

            $stock_card = [];
        }

        

       return view('theme.pages.custom.reports.stock-card', compact('page', 'books', 'book', 'stock_card'));
    }

    // public function stock_card($id){
    //     $page = new Page();
    //     $page->name = "Stock Card";

    //     $book = Book::find($id);

    //     $receiving_transactions = ReceivingHeader::where('receiving_headers.status', 'POSTED')
    //     ->join('receiving_details', 'receiving_details.receiving_header_id', '=', 'receiving_headers.id')
    //     ->where('receiving_details.book_id', $id)
    //     ->select('receiving_headers.posted_at', 'receiving_details.quantity', 'receiving_headers.id', DB::raw("'Receiving' as type"))
    //     ->get();

    //     $issuance_transactions = IssuanceHeader::where('issuance_headers.status', 'POSTED')
    //     ->join('issuance_details', 'issuance_details.issuance_header_id', '=', 'issuance_headers.id')
    //     ->where('issuance_details.book_id', $id)
    //     ->select('issuance_headers.posted_at', 'issuance_details.quantity', 'issuance_headers.id', DB::raw("'Issuance' as type"))
    //     ->get();

    //     $transactions = $receiving_transactions->merge($issuance_transactions);

    //     $sorted_transactions = $transactions->sortBy('posted_at')->values();

    //     $running_balance = 0;
    //     $stock_card = [];

    //     foreach ($sorted_transactions as $transaction) {
    //         if ($transaction->type === 'Receiving') {
    //             $running_balance += $transaction->quantity;
    //         } else if ($transaction->type === 'Issuance') {
    //             $running_balance -= $transaction->quantity;
    //         }

    //         $stock_card[] = [
    //             'date' => $transaction->posted_at,
    //             'type' => $transaction->type,
    //             'transaction_id' => $transaction->id,
    //             'quantity' => $transaction->quantity,
    //             'running_balance' => $running_balance
    //         ];
    //     }

    //    return view('theme.pages.custom.reports.stock-card', compact('page', 'book', 'stock_card'));
    // }

    public function inventory(){
        $page = new Page();
        $page->name = "Inventory Report";

        $transactions = Book::select('*')->where('deleted_at', null)->paginate($this->paginate);

        $filter = ListingHelper::get_filter($this->searchFields);

        $searchType = 'simple_search';

       return view('theme.pages.custom.reports.inventory', compact('page', 'transactions', 'filter', 'searchType'));
    }

    public function users(){
        $page = new Page();
        $page->name = "User Report";
    
        $transactions = User::select('*')->where('deleted_at', null)->paginate($this->paginate);

        $filter = ListingHelper::get_filter($this->searchFields);

        $searchType = 'simple_search';

       return view('theme.pages.custom.reports.users', compact('page', 'transactions', 'filter', 'searchType'));
    }

    public function audit_trail(){
        $page = new Page();
        $page->name = "Audit Trail";
    
        $transactions = ActivityLog::orderByDesc('id')->paginate($this->paginate);

        $filter = ListingHelper::get_filter($this->searchFields);

        $searchType = 'simple_search';

       return view('theme.pages.custom.reports.audit-trail', compact('page', 'transactions', 'filter', 'searchType'));
    }

    public function books(){
        $page = new Page();
        $page->name = "Book List Report";

        $transactions = Book::select('*')->where('deleted_at', null)->paginate($this->paginate);

        $filter = ListingHelper::get_filter($this->searchFields);

        $searchType = 'simple_search';

       return view('theme.pages.custom.reports.books', compact('page', 'transactions', 'filter', 'searchType'));
    }
    
}
