<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\Post;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Html\Button;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $buttons[] = Button::make('create')->name(__("master.create"));
        $actionColumn = [];
        // $image_column = [
        //     'name' => 'image',
        //     'data' => 'image',
        //     'title' =>  __("master.image"),
        //     'searchable' => true,
        //     'orderable' => false,
        //     'render' => 'function(){}',
        //     'footer' => __("role"),
        //     'exportable' => true,
        //     'printable' => true,
        // ];
        $columns = [
                [ 'title' => __("master.creator"), 'data'=> 'user.name'],
                [ 'title' => __("master.title"), 'data'=> 'title'], 
                // [ 'title' => __("master.content"), 'data'=> 'body'],
                [ 'title' => __("master.created_at"), 'data'=> 'created_at']
                ];
        $query = Post::query()->with("user");
        $dataTable = new UsersDataTable($columns, $query,  $buttons, "posts");
        
        return $dataTable->render('dashboard.models.posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.models.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->hasRole(["super.admin", "admin"]))
        {
            $validatedData = $request->validate([
                'title'      => 'required|min:10|max:128',
                'body'      => 'required',
            ]);
            
            $post = new Post();
            $post->users_id = Auth::user()->id;
            //save full adress of image
            if($request->image)
                $post->image = $request->image->store('images');
            $fields = $request->except(['id', 'users_id']);
            foreach ($fields as $key => $value) {
                if( substr($key, 0, 1) != '_')
                    $post[$key] = $value;
            }
            $post->save();
            Session::flash('message', __("master.created_successfully")); 
            Session::flash('alert-class', 'success'); 
        }

        return redirect()->route("posts.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
        $posts = Post::orderBy("id", 'desc')->limit(10)->get()->toArray();
        return view('dashboard.models.posts.view', compact("post", 'posts'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // dd(json_decode($post->body));
        // $post->body = json_decode($post->body);
        return view('dashboard.models.posts.edit', compact("post"));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if(Auth::user()->hasRole(["super.admin", "admin"]))
        {
            $validatedData = $request->validate([
                'title'      => 'required|min:1|max:128',
                'body'      => 'required',
            ]);
            
            $post->users_id = Auth::user()->id;
            
            $fields = $request->except(['id', 'users_id']);
            foreach ($fields as $key => $value) {
                if( substr($key, 0, 1) != '_')
                    $post[$key] = $value;
            }
            //save full adress of image cannot add before foreach case image request paramter
            if($request->image)
                $post->image = $request->image->store('images');
            $post->save();
            Session::flash('message', __("master.edited_successfully")); 
            Session::flash('alert-class', 'success'); 
        }

        return redirect()->route("posts.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(Auth::user()->hasRole(["super.admin", "admin"]))
        {
            $post = Post::find($request->id);
            if($post){
                Storage::delete($post->image);
                $post->delete();
            }
            
        }

    }
}
