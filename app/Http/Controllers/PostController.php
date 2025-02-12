<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

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
        // declare user_id adn fill using authenticated user
        $user_id = Auth::user()->id;

        // validate request
        $user_id->validate(['user_id' => 'required|min:3|max:255|integer|exists:users,id']);
        $request->validate(['title' => 'required|min:3|max:255']);
        $request->validate(['post' => 'required|min:3|max:255']);

        // merge user_id to request
        $request->merge(['user_id' => $user_id]);

        // create new post data
        Post::create(
            [
            'user_id' => $request->user_id,
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
        // declare user_id adn fill using authenticated user
        $user_id = Auth::user()->id;

        // merge user_id to request
        $request->merge(['user_id' => $user_id]);
        
        // validate request
        $request->validate(
            [
                'user_id' => 'required|min:3|max:255|integer|exists:users,id',
                'title' => 'required|min:3|max:255,'.$post->id,
                'post' => 'required|min:3|max:255'
            ]);

        // update post data
        $post->update(
        [
            'user_id' => $request->user_id,
            'title' => $request->title,
            'post' => $request->post
        ]);

        // render view
        return to_route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // delete posts data
        $post->delete();

        // render view
        return back();
    }
}
