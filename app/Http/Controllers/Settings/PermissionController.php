<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\PanelHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Facades\App\Helpers\ListingHelper;
use App\Models\Permission;
use App\Models\{Page};

use Auth;

class PermissionController extends Controller
{
    private $searchFields = ['module'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('checkPermission:admin/permission', ['only' => ['index']]);
        $this->middleware('checkPermission:admin/permission/create', ['only' => ['create','store']]);
        $this->middleware('checkPermission:admin/permission/edit', ['only' => ['show','edit','update']]);
        $this->middleware('checkPermission:admin/permission/delete', ['only' => ['destroy']]);
    }


    public function index($param = null)
    {
        $page = new Page();
        $page->name = "Permissions";

        $permissions = ListingHelper::simple_search(Permission::class, $this->searchFields);
        $panelRoutes = PanelHelper::get_routes();
        $modules = Permission::modules();
        
        // Simple search init data
        $filter = ListingHelper::get_filter($this->searchFields);
        $searchType = 'simple_search';

        return view('theme.pages.custom.accounts.permissions.index', compact('page', 'permissions', 'panelRoutes', 'modules', 'filter', 'searchType'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $panelRoutes = PanelHelper::get_routes();
        $modules = Permission::modules();

        return view('admin.settings.permission.create', compact('panelRoutes', 'modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newData = $request->validate([
            'name' => 'required',
            'module' => 'required',
            'routes' => 'required|array',
            'methods' => 'required|array',
            'description' => 'required',
            'is_view_page' => ''
        ]);

        $newData['is_view_page'] = ($request->has('is_view_page')) ? 1 : 0;
        $newData['user_id'] = auth()->id();

        Permission::create($newData);

        return redirect()->route('permission.index')->with('success', __('standard.account_management.permissions.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        $panelRoutes = PanelHelper::get_routes();
        $modules = Permission::modules();

        return view('admin.settings.permission.edit', compact('permission', 'panelRoutes', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $updateData = $request->validate([
            'name' => 'required',
            'module' => 'required',
            'routes' => 'required|array',
            'methods' => 'required|array',
            'description' => 'required',
            'is_view_page' => ''
        ]);

        $updateData['is_view_page'] = ($request->has('is_view_page')) ? 1 : 0;
        $updateData['user_id'] = auth()->id();

        $permission->update($updateData);

        return redirect()->route('permission.index')->with('success', __('standard.account_management.permissions.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    // }

    public function delete(Request $request){

        $permission = Permission::findOrFail($request->permission_id);
        $permission->update([ 'user_id' => Auth::id() ]);
        $permission->delete();

        return back()->with('success', __('standard.account_management.permissions.delete_success'));
    }

    public function restore($id){
        Permission::withTrashed()->find($id)->update(['user_id' => Auth::id() ]);
        Permission::whereId($id)->restore();

        return back()->with('success', __('standard.account_management.permissions.restore_success'));
    }

    public function single_delete(Request $request)
    {
        $permission = Permission::findOrFail($request->permissions);
        $permission->delete();

        return redirect()->back()->with('alert', 'success:Well done! You successfully deleted an permission');
    }

    public function multiple_delete(Request $request)
    {
        $permissions = explode("|",$request->permissions);

        foreach($permissions as $permission){
            Permission::whereId((int) $permission)->delete();
        }

        return redirect()->back()->with('alert', 'success:Well done! You successfully deleted multiple permissions');
    }

    public function single_restore(Request $request)
    {
        $permission = Permission::withTrashed()->findOrFail($request->permissions);
        $permission->restore();

        return redirect()->back()->with('alert', 'success:Well done! You successfully restored an permission');
    }

    public function multiple_restore(Request $request)
    {
        $permissions = explode("|",$request->permissions);

        foreach($permissions as $permission){
            Permission::withTrashed()->whereId((int) $permission)->restore();
        }

        return redirect()->back()->with('alert', 'success:Well done! You successfully restored multiple permissions');
    }
}
