<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class PostController extends Controller
{
    public static function middleware()
    {
        // Adding or assigning middleware for every routes/permissions
        return [
            new Middleware('permission:posts index', only: ['index']),
            new Middleware('permission:posts create', only: ['create', 'store']),
            new Middleware('permission:posts edit', only: ['edit', 'update']),
            new Middleware('permission:posts delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //  get posts
        $posts = Post::select('id', 'title')
            // search based on name, like, % the search request % if $request->search exist
            ->when($request->search,fn($search) => $search->where('title', 'like', '%'.$request->search.'%'))
            // Arrange from the latest data
            ->latest()
            // Set 6 data per page
            ->paginate(6)->withQueryString();

        // render view
        return inertia('Posts/Index', ['posts' => $posts,'filters' => $request->only(['search'])]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // directing to create page
        // render view 
        return inertia('Posts/Create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate request
        $request->validate(['title' => 'required|min:3|max:255']);
        $request->validate(['post' => 'required|min:3|max:255']);

        // create new post data
        Post::create(
            [
            'title' => $request->title,
            'post' => $request->post
        ]);

        // render view
        return to_route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // render view
        return inertia('Posts/Edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
