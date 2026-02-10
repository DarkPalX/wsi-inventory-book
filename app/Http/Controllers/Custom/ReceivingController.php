<?php

namespace App\Http\Controllers\Custom;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\ReceivingRequest;

use Facades\App\Helpers\{ListingHelper, FileHelper};


use App\Models\{Page};
use App\Models\Custom\{Book, ReceivingHeader, ReceivingDetail, Supplier};
use Auth;


class ReceivingController extends Controller

{
    private $searchFields = ['id'];

    public function index()
    {
        $page = new Page();
        $page->name = "Receiving Transactions";
    
        $transactions = ListingHelper::simple_search(ReceivingHeader::class, $this->searchFields);

        $filter = ListingHelper::get_filter($this->searchFields);

        $searchType = 'simple_search';

       return view('theme.pages.custom.receiving.transactions.index', compact('page', 'transactions', 'filter', 'searchType'));
    }

    public function create()
    {
        $page = new Page();
        $page->name = "Receiving Transactions";

        $suppliers = Supplier::all();

       return view('theme.pages.custom.receiving.transactions.create', compact('page', 'suppliers'));
    }

    public function store(ReceivingRequest $request)
    {
        $requestData = $request->validated();

        // RECEIVING HEADER CREATION
        $requestData['created_by'] = Auth::user()->id;
        $receiving_header = ReceivingHeader::create($requestData);


        // FOR SUPPLIER
        $supplier_ids = [];
        if (!empty($request->supplier_id)) {
            foreach ($request->supplier_id as $supplier) {
                if (filter_var($supplier, FILTER_VALIDATE_INT) === false) {
                    $new_supplier = Supplier::create([
                        'name' => $supplier
                    ]);
                    $supplier_ids[] = $new_supplier->id;
                } else {
                    $supplier_ids[] = (int)$supplier;
                }
            }

            $receiving_header->update([
                'supplier_id' => json_encode($supplier_ids, JSON_UNESCAPED_SLASHES)
            ]);
        }


        // FOR BOOK COVER UPLOAD
        $book_cover = $request->hasFile('book_cover') ? FileHelper::move_to_files_folder($request->file('book_cover'), 'attachments/receiving-transactions/book_cover/'. $receiving_header->id)['url'] : null;
        $receiving_header->update([
            'book_cover' => $book_cover
        ]);


        // FOR ATTACHMENTS UPLOAD
        if($request->hasFile('attachments')){
            $attachments_url = [];
            foreach ($request->file('attachments') as $attachment) {
                if ($attachment) {
                    $attachment_url = FileHelper::move_to_files_folder($attachment, 'attachments/receiving-transactions/attachments/' . $receiving_header->id)['url'];
                    $attachments_url[] = $attachment_url;
                }
            }

            $receiving_header->update([
                'attachments' => json_encode($attachments_url, JSON_UNESCAPED_SLASHES)
            ]);
        }

        
        // RECEIVING DETAILS CREATION
        $item_count = 0;
        foreach($request->book_id as $item){
            $requestData['receiving_header_id'] = $receiving_header->id;
            $requestData['book_id'] = $item;
            $requestData['sku'] = $request->sku[$item_count];
            $requestData['quantity'] = $request->quantity[$item_count];

            ReceivingDetail::create($requestData);

            $item_count++;
        }

       return redirect()->route('receiving.transactions.index')->with('alert', 'success:Well done! You successfully added a transaction');
    }

    public function show(Request $request)
    {
        $page = new Page();
        $page->name = "Receiving Transactions";

        $transaction = ReceivingHeader::withTrashed()->findOrFail($request->query('id'));

        $suppliers = Supplier::all();
        $receiving_details = ReceivingDetail::where('receiving_header_id', $request->query('id'))->get();

        return view('theme.pages.custom.receiving.transactions.show', compact('transaction', 'page', 'suppliers', 'receiving_details'));
    }

    // public function show(ReceivingHeader $transaction)
    // {
    //     $page = new Page();
    //     $page->name = "Receiving Transactions";

    //     $suppliers = Supplier::all();
    //     $receiving_details = ReceivingDetail::where('receiving_header_id', $transaction->id)->get();

    //     return view('theme.pages.custom.receiving.transactions.show', compact('transaction', 'page', 'suppliers', 'receiving_details'));
    // }

    public function edit(ReceivingHeader $transaction)
    {
        $page = new Page();
        $page->name = "Receiving Transactions";

        $suppliers = Supplier::all();
        $receiving_details = ReceivingDetail::where('receiving_header_id', $transaction->id)->get();

        return view('theme.pages.custom.receiving.transactions.edit', compact('transaction', 'page', 'suppliers', 'receiving_details'));
    }

    public function update(ReceivingRequest $request, ReceivingHeader $transaction)
    {
        $requestData = $request->validated();

        // RECEIVING HEADER CREATION
        $requestData['updated_by'] = Auth::user()->id;
        $receiving_header = $transaction->update($requestData);


        // FOR SUPPLIER
        $supplier_ids = [];
        if (!empty($request->supplier_id)) {
            foreach ($request->supplier_id as $supplier) {
                if (filter_var($supplier, FILTER_VALIDATE_INT) === false) {
                    $new_supplier = Supplier::create([
                        'name' => $supplier
                    ]);
                    $supplier_ids[] = $new_supplier->id;
                } else {
                    $supplier_ids[] = (int)$supplier;
                }
            }

            $transaction->update([
                'supplier_id' => json_encode($supplier_ids, JSON_UNESCAPED_SLASHES)
            ]);
        }

        // FOR BOOK COVER UPLOAD
        if($request->hasFile('book_cover')){
            $book_cover = $request->hasFile('book_cover') ? FileHelper::move_to_files_folder($request->file('book_cover'), 'attachments/receiving-transactions/book_cover/'. $transaction->id)['url'] : null;
            $transaction->update([
                'book_cover' => $book_cover
            ]);
        }

        // FOR ATTACHMENTS UPLOAD
        if($request->hasFile('attachments')){
            $attachments_url = [];
            foreach ($request->file('attachments') as $attachment) {
                if ($attachment) {
                    $attachment_url = FileHelper::move_to_files_folder($attachment, 'attachments/receiving-transactions/attachments/' . $transaction->id)['url'];
                    $attachments_url[] = $attachment_url;
                }
            }

            $transaction->update([
                'attachments' => json_encode($attachments_url, JSON_UNESCAPED_SLASHES)
            ]);
        }

        // RECEIVING DETAILS CREATION
        ReceivingDetail::where('receiving_header_id', $transaction->id)->delete();
        $item_count = 0;
        foreach($request->book_id as $item){
            $requestData['receiving_header_id'] = $transaction->id;
            $requestData['book_id'] = $item;
            $requestData['sku'] = $request->sku[$item_count];
            $requestData['quantity'] = $request->quantity[$item_count];

            ReceivingDetail::create($requestData);

            $item_count++;
        }

       return redirect()->route('receiving.transactions.index')->with('alert', 'success:Well done! You successfully updated a transaction');
    }

    public function single_delete(Request $request)
    {
        $transaction = ReceivingHeader::findOrFail($request->transactions);

        $transaction->update([
            'status' => 'CANCELLED',
            'cancelled_by' => Auth::user()->id,
            'cancelled_at' => now()
        ]);

        $transaction->delete();

        return redirect()->back()->with('alert', 'success:Well done! You successfully cancelled a transaction');
    }

    public function multiple_delete(Request $request)
    {
        $transactions = explode("|",$request->transactions);

        foreach($transactions as $transaction){

            ReceivingHeader::where('id', $transaction)
            ->update([
                'status' => 'CANCELLED',
                'cancelled_by' => Auth::user()->id,
                'cancelled_at' => now()
            ]);

            ReceivingHeader::whereId((int) $transaction)->delete();
        }

        return redirect()->back()->with('alert', 'success:Well done! You successfully cancelled multiple transactions');
    }

    public function single_restore(Request $request)
    {
        $transaction = ReceivingHeader::withTrashed()->findOrFail($request->transactions);
        $transaction->restore();

        return redirect()->back()->with('alert', 'success:Well done! You successfully restored a transaction');
    }

    public function multiple_restore(Request $request)
    {
        $transactions = explode("|",$request->transactions);

        foreach($transactions as $transaction){
            ReceivingHeader::withTrashed()->whereId((int) $transaction)->restore();
        }

        return redirect()->back()->with('alert', 'success:Well done! You successfully restored multiple transactions');
    }

    public function single_post(Request $request)
    {
        $transaction = ReceivingHeader::findOrFail($request->transactions);
        $transaction->update([
            'status' => 'POSTED',
            'posted_by' => Auth::user()->id,
            'posted_at' => now()
        ]);

        return redirect()->back()->with('alert', 'success:Well done! You successfully posted a transaction');
    }

    public function search_item(Request $request)
    {
        // Perform the search query, using 'like' for partial matches
        $query = $request->input('query');
        $results = Book::where('id', 'like', '%' . $query . '%')
                        ->orWhere('sku', 'like', '%' . $query . '%')
                        ->orWhere('name', 'like', '%' . $query . '%')
                        ->get(['id', 'sku', 'name', 'total_cost']); // Select only the necessary fields

        return response()->json(['results' => $results]);
    }
    
}
