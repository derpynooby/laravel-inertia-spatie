<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public static function middleware()
    {
        // Adding or assigning middleware for every routes/permissions
        return [
            new Middleware('permission:permissions index', only: ['index']),
            new Middleware('permission:permissions create', only: ['create', 'store']),
            new Middleware('permission:permissions edit', only: ['edit', 'update']),
            new Middleware('permission:permissions delete', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //  get permissions
        $permissions = Permission::select('id', 'name')
            // search based on name, like, % the search request % if $request->search exist
            ->when($request->search,fn($search) => $search->where('name', 'like', '%'.$request->search.'%'))
            // Arrange from the latest data
            ->latest()
            // Set 6 data per page
            ->paginate(6)->withQueryString();

        // render view
        return inertia('Permissions/Index', ['permissions' => $permissions,'filters' => $request->only(['search'])]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // directing to create page
        // render view 
        return inertia('Permissions/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate request
        $request->validate(['name' => 'required|min:3|max:255|unique:permissions']);

        // create new permission data
        Permission::create(['name' => $request->name]);

        // render view
        return to_route('permissions.index');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
