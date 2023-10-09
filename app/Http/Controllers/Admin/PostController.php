<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{


    private $validationRules = [
        'title' => 'required|string|min:3|max:255',
        'content' => 'required|string',
// Add other validation rules for image, published_at, etc.
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $posts = Post::all();
//        $posts = Auth::user()->posts;  //posts of the authenticated user
        return view('admin.posts.index', compact('posts'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
// Validate the request data
        $request->validate($this->validationRules);


// Create a new post with manual values
        $post = new Post;
        $post->user_id = Auth::id();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
// $post->author = auth()->user()->name; // Set author as the authenticated user's name
        $post->published_at = now(); // Set published_at as the current datetime
        $post->published = true; // Set published as true


        $post->save();


        return redirect()->route('admin.posts.show', $post->id)->with('success', 'Post created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
// Fetch the post based on the provided ID
        $post = Post::findOrFail($id);


// Pass the post data to the show view
        return view('admin.posts.show', compact('post'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);


// Pass the post data to the show view
        return view('admin.posts.edit', compact('post'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
// Validate the request data
        $request->validate($this->validationRules);


// Find the post
        $post = Post::findOrFail($id);


// Update the post with manual values
        $post->user_id = $post->user_id;
        $post->title = $request->input('title');
        $post->content = $request->input('content');
// $post->author = auth()->user()->name; // Set author as the authenticated user's name
        $post->published_at = $post->published_at; // Set published_at as the old date time
        $post->published = true; // Set published as true


        $post->save();


        return redirect()->route('admin.posts.show', $post->id)->with('success', 'Post updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();


        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }
}
