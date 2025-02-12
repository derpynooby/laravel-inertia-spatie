<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
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
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
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
