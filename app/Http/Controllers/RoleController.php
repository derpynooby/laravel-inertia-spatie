<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    // Adding or assigning middleware for every routes(permissions)
    public static function middleware()
    {
        return [
            new Middleware('permission:roles index', only: ['index']),
            new Middleware('permission:roles create', only: ['create', 'store']),
            new Middleware('permission:roles edit', only: ['edit', 'update']),
            new Middleware('permission:roles delete', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get roles
        $roles = Role::select('id', 'name')
            
            // Set 6 data per page
            ->paginate(6);

        // render view
        return inertia('Roles/Index', ['roles' => $roles,'filters' => $request->only(['search'])]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
