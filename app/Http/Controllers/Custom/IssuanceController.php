<?php

namespace App\Http\Controllers\Custom;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\IssuanceRequest;

use Facades\App\Helpers\{ListingHelper, FileHelper};


use App\Models\{Page};
use App\Models\Custom\{Book, IssuanceHeader, IssuanceDetail, Receiver};
use Auth;


class IssuanceController extends Controller

{
    private $searchFields = ['id'];

    public function index()
    {
        $page = new Page();
        $page->name = "Issuance Transactions";
    
        $transactions = ListingHelper::simple_search(IssuanceHeader::class, $this->searchFields);

        $filter = ListingHelper::get_filter($this->searchFields);

        $searchType = 'simple_search';

       return view('theme.pages.custom.issuance.transactions.index', compact('page', 'transactions', 'filter', 'searchType'));
    }

    public function create()
    {
        $page = new Page();
        $page->name = "Issuance Transactions";

        $receivers = Receiver::all();

       return view('theme.pages.custom.issuance.transactions.create', compact('page', 'receivers'));
    }

    public function store(IssuanceRequest $request)
    {
        $requestData = $request->validated();

        // ISSUANCE HEADER CREATION
        $requestData['created_by'] = Auth::user()->id;
        $issuance_header = IssuanceHeader::create($requestData);


        // FOR RECEIVER
        $receiver_ids = [];
        if (!empty($request->receiver_id)) {
            foreach ($request->receiver_id as $receiver) {
                if (filter_var($receiver, FILTER_VALIDATE_INT) === false) {
                    $new_receiver = Receiver::create([
                        'name' => $receiver
                    ]);
                    $receiver_ids[] = $new_receiver->id;
                } else {
                    $receiver_ids[] = (int)$receiver;
                }
            }

            $issuance_header->update([
                'receiver_id' => json_encode($receiver_ids, JSON_UNESCAPED_SLASHES)
            ]);
        }

        // FOR ATTACHMENTS UPLOAD
        if($request->hasFile('attachments')){
            $attachments_url = [];
            foreach ($request->file('attachments') as $attachment) {
                if ($attachment) {
                    $attachment_url = FileHelper::move_to_files_folder($attachment, 'attachments/issuance-transactions/attachments/' . $issuance_header->id)['url'];
                    $attachments_url[] = $attachment_url;
                }
            }

            $issuance_header->update([
                'attachments' => json_encode($attachments_url, JSON_UNESCAPED_SLASHES)
            ]);
        }

        // ISSUANCE DETAILS CREATION
        $item_count = 0;
        foreach($request->book_id as $item){
            $requestData['issuance_header_id'] = $issuance_header->id;
            $requestData['book_id'] = $item;
            $requestData['sku'] = $request->sku[$item_count];
            $requestData['quantity'] = $request->quantity[$item_count];
            $requestData['cost'] = $request->cost[$item_count];

            IssuanceDetail::create($requestData);

            $item_count++;
        }

       return redirect()->route('issuance.transactions.index')->with('alert', 'success:Well done! You successfully added a transaction');
    }
    
    public function show(Request $request)
    {
        $page = new Page();
        $page->name = "Issuance Transactions";

        $transaction = IssuanceHeader::withTrashed()->findOrFail($request->query('id'));

        $receivers = Receiver::all();
        $issuance_details = IssuanceDetail::where('issuance_header_id', $transaction->id)->get();

        return view('theme.pages.custom.issuance.transactions.show', compact('transaction', 'page', 'receivers', 'issuance_details'));
    }
    
    // public function show(IssuanceHeader $transaction)
    // {
    //     $page = new Page();
    //     $page->name = "Issuance Transactions";

    //     $receivers = Receiver::all();
    //     $issuance_details = IssuanceDetail::where('issuance_header_id', $transaction->id)->get();

    //     return view('theme.pages.custom.issuance.transactions.show', compact('transaction', 'page', 'receivers', 'issuance_details'));
    // }

    public function edit(IssuanceHeader $transaction)
    {
        $page = new Page();
        $page->name = "Issuance Transactions";

        $receivers = Receiver::all();
        $issuance_details = IssuanceDetail::where('issuance_header_id', $transaction->id)->get();

        return view('theme.pages.custom.issuance.transactions.edit', compact('transaction', 'page', 'receivers', 'issuance_details'));
    }

    public function update(IssuanceRequest $request, IssuanceHeader $transaction)
    {
        $requestData = $request->validated();

        // ISSUANCE HEADER CREATION
        $requestData['updated_by'] = Auth::user()->id;
        $issuance_header = $transaction->update($requestData);


        // FOR RECEIVER
        $receiver_ids = [];
        if (!empty($request->receiver_id)) {
            foreach ($request->receiver_id as $receiver) {
                if (filter_var($receiver, FILTER_VALIDATE_INT) === false) {
                    $new_receiver = Receiver::create([
                        'name' => $receiver
                    ]);
                    $receiver_ids[] = $new_receiver->id;
                } else {
                    $receiver_ids[] = (int)$receiver;
                }
            }

            $transaction->update([
                'receiver_id' => json_encode($receiver_ids, JSON_UNESCAPED_SLASHES)
            ]);
        }

        // FOR ATTACHMENTS UPLOAD
        if($request->hasFile('attachments')){
            $attachments_url = [];
            foreach ($request->file('attachments') as $attachment) {
                if ($attachment) {
                    $attachment_url = FileHelper::move_to_files_folder($attachment, 'attachments/issuance-transactions/attachments/' . $transaction->id)['url'];
                    $attachments_url[] = $attachment_url;
                }
            }

            $transaction->update([
                'attachments' => json_encode($attachments_url, JSON_UNESCAPED_SLASHES)
            ]);
        }

        // ISSUANCE DETAILS CREATION
        IssuanceDetail::where('issuance_header_id', $transaction->id)->delete();
        $item_count = 0;
        foreach($request->book_id as $item){
            $requestData['issuance_header_id'] = $transaction->id;
            $requestData['book_id'] = $item;
            $requestData['sku'] = $request->sku[$item_count];
            $requestData['quantity'] = $request->quantity[$item_count];
            $requestData['cost'] = $request->cost[$item_count];

            IssuanceDetail::create($requestData);

            $item_count++;
        }

       return redirect()->route('issuance.transactions.index')->with('alert', 'success:Well done! You successfully updated a transaction');
    }

    public function single_delete(Request $request)
    {
        $transaction = IssuanceHeader::findOrFail($request->transactions);

        $transaction->update([
            'status' => 'CANCELLED',
            'cancelled_by' => Auth::user()->id,
            'cancelled_at' => now()
        ]);

        $transaction->delete();

        return redirect()->back()->with('alert', 'success:Well done! You successfully deleted a transaction');
    }

    public function multiple_delete(Request $request)
    {
        $transactions = explode("|",$request->transactions);

        foreach($transactions as $transaction){

            IssuanceHeader::where('id', $transaction)
            ->update([
                'status' => 'CANCELLED',
                'cancelled_by' => Auth::user()->id,
                'cancelled_at' => now()
            ]);

            IssuanceHeader::whereId((int) $transaction)->delete();
        }

        return redirect()->back()->with('alert', 'success:Well done! You successfully deleted multiple transactions');
    }

    public function single_restore(Request $request)
    {
        $transaction = IssuanceHeader::withTrashed()->findOrFail($request->transactions);
        $transaction->restore();

        return redirect()->back()->with('alert', 'success:Well done! You successfully restored a transaction');
    }

    public function multiple_restore(Request $request)
    {
        $transactions = explode("|",$request->transactions);

        foreach($transactions as $transaction){
            IssuanceHeader::withTrashed()->whereId((int) $transaction)->restore();
        }

        return redirect()->back()->with('alert', 'success:Well done! You successfully restored multiple transactions');
    }

    public function single_post(Request $request)
    {
        $transaction = IssuanceHeader::findOrFail($request->transactions);
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

        // Filter out books with inventory equal to 0 and include the inventory in the response
        $filteredResults = $results->filter(function ($book) {
            $book->inventory = $book->inventory; // Access the inventory attribute
            return $book->inventory > 0; // Only include books with inventory greater than 0
        });

        return response()->json(['results' => $filteredResults->values()]);
    }
    
}
