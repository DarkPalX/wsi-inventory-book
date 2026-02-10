<?php

namespace App\Http\Controllers\Custom;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Facades\App\Helpers\ListingHelper;
use App\Helpers\ModelHelper;

use App\Models\{Page};
use App\Models\Custom\{BookCategory};

class BookCategoryController extends Controller
{
    private $searchFields = ['name'];

    public function index()
    {
        $page = new Page();
        $page->name = "Book Categories";
        
        $categories = ListingHelper::simple_search(BookCategory::class, $this->searchFields);

        $filter = ListingHelper::get_filter($this->searchFields);

        $searchType = 'simple_search';

       return view('theme.pages.custom.books.categories.index', compact('page', 'categories', 'filter', 'searchType'));
    }

    public function create()
    {
        $page = new Page();
        $page->name = "Book Category";

       return view('theme.pages.custom.books.categories.create', compact('page'));
    }

    public function store(Request $request)
    {
        $name_exists = BookCategory::where('name', $request->name)->first();
        
        if($name_exists == null){
            $new_data = BookCategory::create([
                'name' => $request->name,
                'slug' => ModelHelper::convert_to_slug(BookCategory::class, $request->name),
                'description' => $request->description,
                'order' => BookCategory::count() + 1
            ]);
    
           return redirect()->route('books.categories.index')->with('alert', 'success:Well done! You successfully added a category');
        }
        else{
            return redirect()->back()->with('alert', 'danger:Failed! Name already exists');
        }
    }

    public function edit(BookCategory $category)
    {
        $page = new Page();
        $page->name = "Book Category";

       return view('theme.pages.custom.books.categories.edit', compact('page', 'category'));
    }

    public function update(Request $request, BookCategory $category)
    {
        $name_exists = BookCategory::where('id', '<>', $category->id)->where('name', $request->name)->first();
        
        if($name_exists == null){
            $category->update([
                'name' => $request->name,
                'slug' => ModelHelper::convert_to_slug(BookCategory::class, $request->name),
                'description' => $request->description
            ]);

            return redirect()->back()->with('alert', 'success:Well done! You successfully updated a category');
        }
        else{
            return redirect()->back()->with('alert', 'danger:Failed! Name already exists');
        }
    }

    public function single_delete(Request $request)
    {
        $category = BookCategory::findOrFail($request->categories);
        $category->delete();

        return redirect()->back()->with('alert', 'success:Well done! You successfully deleted an category');
    }

    public function multiple_delete(Request $request)
    {
        $categories = explode("|",$request->categories);

        foreach($categories as $category){
            BookCategory::whereId((int) $category)->delete();
        }

        return redirect()->back()->with('alert', 'success:Well done! You successfully deleted multiple categories');
    }

    public function single_restore(Request $request)
    {
        $category = BookCategory::withTrashed()->findOrFail($request->categories);
        $category->restore();

        return redirect()->back()->with('alert', 'success:Well done! You successfully restored an category');
    }

    public function multiple_restore(Request $request)
    {
        $categories = explode("|",$request->categories);

        foreach($categories as $category){
            BookCategory::withTrashed()->whereId((int) $category)->restore();
        }

        return redirect()->back()->with('alert', 'success:Well done! You successfully restored multiple categories');
    }
    
}
