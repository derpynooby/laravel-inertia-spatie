<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserController extends Controller
{
    // Assingning or adding middleware for every routes / permissions
    public static function middleware()
    {
        return [
            new Middleware('permission:users index', only : ['index']),
            new Middleware('permission:users create', only : ['create', 'store']),
            new Middleware('permission:users edit', only : ['edit', 'update   ']),
            new Middleware('permission:users delete', only : ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get all users with roles
        $users = User::with('roles')
            // search based on name, like, % the search request % if $request->search exist
            ->when(request('search'), fn($query) => $query->where('name', 'like', '%'.request('search').'%'))
            // arrange data from the latest
            ->latest()
            // set 6 data per page
            ->paginate(6);

        // render view
        return inertia('Users/Index', ['users' => $users,'filters' => $request->only(['search'])]);
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
         // validate request
         $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:4',
            'selectedRoles' => 'required|array|min:1',
        ]);

        // create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // attach roles
        $user->assignRole($request->selectedRoles);

        // render view
        return to_route('users.index');
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
