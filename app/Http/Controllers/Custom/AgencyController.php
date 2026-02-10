<?php

namespace App\Http\Controllers\Custom;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Facades\App\Helpers\ListingHelper;

use App\Models\{Page};
use App\Models\Custom\{Agency};

class AgencyController extends Controller
{
    private $searchFields = ['name'];

    public function index()
    {
        $page = new Page();
        $page->name = "Agencies";
        
        $agencies = ListingHelper::simple_search(Agency::class, $this->searchFields);

        $filter = ListingHelper::get_filter($this->searchFields);

        $searchType = 'simple_search';

       return view('theme.pages.custom.books.agencies.index', compact('page', 'agencies', 'filter', 'searchType'));
    }

    public function create()
    {
        $page = new Page();
        $page->name = "Agencies";

       return view('theme.pages.custom.books.agencies.create', compact('page'));
    }

    public function store(Request $request)
    {
        $name_exists = Agency::where('name', $request->name)->first();
        
        if($name_exists == null){
            Agency::create([
                'name' => $request->name
            ]);

            return redirect()->route('books.agencies.index')->with('alert', 'success:Well done! You successfully added an agency');
        }
        else{
            return redirect()->back()->with('alert', 'danger:Failed! Name already exists');
        }
    }

    public function edit(Agency $agency)
    {
        $page = new Page();
        $page->name = "Agencies";

       return view('theme.pages.custom.books.agencies.edit', compact('page', 'agency'));
    }

    public function update(Request $request, Agency $agency)
    {
        $name_exists = Agency::where('id', '<>', $agency->id)->where('name', $request->name)->first();
        
        if($name_exists == null){
            $agency->update([
                'name' => $request->name,
            ]);

            return redirect()->back()->with('alert', 'success:Well done! You successfully updated an agency');
        }
        else{
            return redirect()->back()->with('alert', 'danger:Failed! Name already exists');
        }
    }

    public function single_delete(Request $request)
    {
        $agency = Agency::findOrFail($request->agencies);
        $agency->delete();

        return redirect()->back()->with('alert', 'success:Well done! You successfully deleted an agency');
    }

    public function multiple_delete(Request $request)
    {
        $agencies = explode("|",$request->agencies);

        foreach($agencies as $agency){
            Agency::whereId((int) $agency)->delete();
        }

        return redirect()->back()->with('alert', 'success:Well done! You successfully deleted multiple agencies');
    }

    public function single_restore(Request $request)
    {
        $agency = Agency::withTrashed()->findOrFail($request->agencies);
        $agency->restore();

        return redirect()->back()->with('alert', 'success:Well done! You successfully restored an agency');
    }

    public function multiple_restore(Request $request)
    {
        $agencies = explode("|",$request->agencies);

        foreach($agencies as $agency){
            Agency::withTrashed()->whereId((int) $agency)->restore();
        }

        return redirect()->back()->with('alert', 'success:Well done! You successfully restored multiple agencies');
    }
}
