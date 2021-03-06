<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use App\Category;

use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $posts = Post::with('user')->latest()->paginate(5);
    return view('posts.index',compact('posts'));
  }

  /**
  * search the blog
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function search(Request $request)
  {
    $this->validate($request, [
      'keyword'=>'required',
    ]);

    $search = $request->get('keyword');

    $searchResults = Post::where('title', 'LIKE', '%'. $search.'%')
    ->orWhere('body', 'LIKE', '%'.$search.'%')
    ->paginate(2);

    return view('search',compact('searchResults','search'));

  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    $categories = Category::all();
    return view('posts.create',compact('categories'));
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    //Post::create($request->except('_token'););

    $this->validate($request, [
      'title'=>'required|max:50',
      'body'=>'required|max:65535',
      'category'=>'required',
    ]);

    $input = $request->except('_token');
    if ($file = $request->file('image'))
    {
      $name = $file->getClientOriginalName();
      $file->move(public_path('images'),$name);
      $input['image'] = $name;

    }

    $input['user_id']=Auth::user()->id;
    $input['category_id']=$request->get('category');
    Post::create($input);
    //$post = Auth::user()->posts()->save(new Post($request->except('_token')));
    return redirect('/posts');
    //return $request->all();
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    $data = Post::findOrFail($id);
    $comments = $data->comments;
    return view('posts.show',compact('data','comments'));
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    //
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
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    //
  }
}
