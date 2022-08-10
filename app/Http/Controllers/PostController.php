<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$posts = Post::all();
        $posts = Post::latest()->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        // Upload Files
        $file = $request->file('file');

        // Get file original name
        $file->getClientOriginalName();

        // Validation inside store function
        // $this->validate($request, [
        //     'title' => 'required ',
        //     'content' => 'required',
        // ]);
        $input = $request->all();

        // Check if there is file
        if ($file = $request->file('file')) {
            $name = $file->getClientOriginalName();
            // Create a new folder called images inside public directory
            $file->move('images', $name);

            $input['path'] = $name;
        }

        Post::create($input);
        return redirect('/posts');
        // $post = new Post();
        // $post->title = $request->title;
        // $post->save();
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update($request->all());
        return redirect('/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect('/posts');
    }
    // public function contact()
    // {
    //     $people = ["Edwin", "Jose", "Peter"];
    //     return view('contact', compact('people'));
    // }
    // public function showPost($id, $name, $pass)
    // {
    //     // Chaining option 1 to pass param to the view 
    //     //return view('post')->with('id',$id);

    //     // Option 2
    //     return view('post', compact('id', 'name', 'pass'));
    // }
}
