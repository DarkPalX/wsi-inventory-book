<?php

namespace App\Http\Controllers\Custom;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Facades\App\Helpers\ListingHelper;

use App\Models\{Page};
use App\Models\Custom\{Author};

class AuthorController extends Controller
{
    private $searchFields = ['name'];

    public function index()
    {
        $page = new Page();
        $page->name = "Authors";
        
        $authors = ListingHelper::simple_search(Author::class, $this->searchFields);

        $filter = ListingHelper::get_filter($this->searchFields);

        $searchType = 'simple_search';

       return view('theme.pages.custom.books.authors.index', compact('page', 'authors', 'filter', 'searchType'));
    }

    public function create()
    {
        $page = new Page();
        $page->name = "Authors";

       return view('theme.pages.custom.books.authors.create', compact('page'));
    }

    public function store(Request $request)
    {
        $name_exists = Author::where('name', $request->name)->first();
        
        if($name_exists == null){
            Author::create([
                'name' => $request->name
            ]);

            return redirect()->route('books.authors.index')->with('alert', 'success:Well done! You successfully added an author');
        }
        else{
            return redirect()->back()->with('alert', 'danger:Failed! Name already exists');
        }
    }

    public function edit(Author $author)
    {
        $page = new Page();
        $page->name = "Authors";

       return view('theme.pages.custom.books.authors.edit', compact('page', 'author'));
    }

    public function update(Request $request, Author $author)
    {
        $name_exists = Author::where('id', '<>', $author->id)->where('name', $request->name)->first();
        
        if($name_exists == null){
            $author->update([
                'name' => $request->name,
            ]);

            return redirect()->back()->with('alert', 'success:Well done! You successfully updated an author');
        }
        else{
            return redirect()->back()->with('alert', 'danger:Failed! Name already exists');
        }
    }

    public function single_delete(Request $request)
    {
        $author = Author::findOrFail($request->authors);
        $author->delete();

        return redirect()->back()->with('alert', 'success:Well done! You successfully deleted an author');
    }

    public function multiple_delete(Request $request)
    {
        $authors = explode("|",$request->authors);

        foreach($authors as $author){
            Author::whereId((int) $author)->delete();
        }

        return redirect()->back()->with('alert', 'success:Well done! You successfully deleted multiple authors');
    }

    public function single_restore(Request $request)
    {
        $author = Author::withTrashed()->findOrFail($request->authors);
        $author->restore();

        return redirect()->back()->with('alert', 'success:Well done! You successfully restored an author');
    }

    public function multiple_restore(Request $request)
    {
        $authors = explode("|",$request->authors);

        foreach($authors as $author){
            Author::withTrashed()->whereId((int) $author)->restore();
        }

        return redirect()->back()->with('alert', 'success:Well done! You successfully restored multiple authors');
    }
    
}
