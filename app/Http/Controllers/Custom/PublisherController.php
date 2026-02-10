<?php

namespace App\Http\Controllers\Custom;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Facades\App\Helpers\ListingHelper;

use App\Models\{Page};
use App\Models\Custom\{Publisher};

class PublisherController extends Controller
{
    private $searchFields = ['name'];

    public function index()
    {
        $page = new Page();
        $page->name = "Publishers";
    
        $publishers = ListingHelper::simple_search(Publisher::class, $this->searchFields);

        $filter = ListingHelper::get_filter($this->searchFields);

        $searchType = 'simple_search';

       return view('theme.pages.custom.books.publishers.index', compact('page', 'publishers', 'filter', 'searchType'));
    }

    public function create()
    {
        $page = new Page();
        $page->name = "Publishers";

       return view('theme.pages.custom.books.publishers.create', compact('page'));
    }

    public function store(Request $request)
    {
        $name_exists = Publisher::where('name', $request->name)->first();
        
        if($name_exists == null){
            Publisher::create([
                'name' => $request->name
            ]);

            return redirect()->route('books.publishers.index')->with('alert', 'success:Well done! You successfully added a publisher');
        }
        else{
            return redirect()->back()->with('alert', 'danger:Failed! Name already exists');
        }
    }

    public function edit(Publisher $publisher)
    {
        $page = new Page();
        $page->name = "Publishers";

       return view('theme.pages.custom.books.publishers.edit', compact('page', 'publisher'));
    }

    public function update(Request $request, Publisher $publisher)
    {
        $name_exists = Publisher::where('id', '<>', $publisher->id)->where('name', $request->name)->first();
        
        if($name_exists == null){
            $publisher->update([
                'name' => $request->name,
            ]);

            return redirect()->back()->with('alert', 'success:Well done! You successfully updated a publisher');
        }
        else{
            return redirect()->back()->with('alert', 'danger:Failed! Name already exists');
        }
    }

    public function single_delete(Request $request)
    {
        $publisher = Publisher::findOrFail($request->publishers);
        $publisher->delete();

        return redirect()->back()->with('alert', 'success:Well done! You successfully deleted a publisher');
    }

    public function multiple_delete(Request $request)
    {
        $publishers = explode("|",$request->publishers);

        foreach($publishers as $publisher){
            Publisher::whereId((int) $publisher)->delete();
        }

        return redirect()->back()->with('alert', 'success:Well done! You successfully deleted multiple publishers');
    }

    public function single_restore(Request $request)
    {
        $publisher = Publisher::withTrashed()->findOrFail($request->publishers);
        $publisher->restore();

        return redirect()->back()->with('alert', 'success:Well done! You successfully restored a publisher');
    }

    public function multiple_restore(Request $request)
    {
        $publishers = explode("|",$request->publishers);

        foreach($publishers as $publisher){
            Publisher::withTrashed()->whereId((int) $publisher)->restore();
        }

        return redirect()->back()->with('alert', 'success:Well done! You successfully restored multiple publishers');
    }
    
}
