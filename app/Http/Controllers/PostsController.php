<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use Exception;

class PostsController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // Ako zelimo odredjenim redosledom (svaki put posle koriscenja ovih specijalnih metoda moramo da koristimo metodu get)
        // $posts=Post::orderBy('title','desc')->take(1)->get();

        //Koriscenje where klauzule
        //$posts=Post::where('title','Post2')->get();

        //Koriscenje all metode gde ne se ne koristi get posle nje
        // $posts=Post::all();

        $posts=Post::orderBy('id','desc')->paginate(4);
        return view('posts.index')->with('posts',$posts);
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
    public function store(Request $request)
    {
        $this->validate($request, [
        'title' => 'required',
        'body' => 'required',
        // Image(JPG,PNG,GIF..),Nullable-nije required,max-apache standard je 2 mb
        'cover_image'=>'image|nullable|max:1999'
    ]);

    //Handle file upload
    if($request->hasFile('cover_image')){
        //Get file name with extension
        $fileNameWithExt=$request->file('cover_image')->getClientOriginalName();
        // Get just file name
        $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
        //Get just file extension
        $ext=$request->file('cover_image')->getClientOriginalExtension();
        //File name to store
        $fileNameToStore=$fileName.'_'.time().'.'.$ext;
        //Upload image
        $path=$request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
    } else {
        $fileNameToStore='noimage.jpg';
    }
    //Create Post
    $post=new Post();
    $post->title=$request->input('title');
    $post->body=$request->input('body');
    $post->user_id = auth()->user()->id;
    $post->cover_image = $fileNameToStore;
    $post->save();
    return redirect('/posts')->with('success', 'Post created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post=Post::find($id);

        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $post=Post::find($id);
            // Check for correct user
            if(auth()->user()->id!=$post->user_id){
                return redirect('/posts')->with('error','Unauthorized page!');
            }
            else{
                return view('posts.edit')->with('post',$post);
            }
        } catch(Exception $e) {
            return redirect('/posts')->with('error','Exception!');
        }
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
        $this->validate($request, [
        'title' => 'required',
        'body' => 'required',
        // Image(JPG,PNG,GIF..),Nullable-nije required,max-apache standard je 2 mb
        'cover_image'=>'image|nullable|max:1999'
    ]);
        //Handle file upload
    if($request->hasFile('cover_image')){
        //Get file name with extension
        $fileNameWithExt=$request->file('cover_image')->getClientOriginalName();
        // Get just file name
        $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
        //Get just file extension
        $ext=$request->file('cover_image')->getClientOriginalExtension();
        //File name to store
        $fileNameToStore=$fileName.'_'.time().'.'.$ext;
        //Upload image
        $path=$request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
    } else {
        $fileNameToStore='noimage.jpg';
    }
        $post=Post::find($id);
        $post->title=$request->input('title');
        $post->body=$request->input('body');
        if($fileNameToStore!='noimage.jpg'){
            Storage::delete('public/cover_images/'.$post->cover_image);
            $post->cover_image=$fileNameToStore;
        }
        $post->save();
        return redirect('/posts/'.$post->id)->with('success','Successful post editing!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $post=Post::find($id);
            if(auth()->user()->id!=$post->user_id){
                return redirect('/posts')->with('error','Unauthorized page!');
            }
            else{
                //If image is not noimage.jpg than delete it
                if($post->cover_image != 'noimage.jpg'){
                    Storage::delete('public/cover_images/'.$post->cover_image);
                }
                $post->delete();
                return redirect('/posts')->with('success','Post removed!');
            }

        } catch (Exception $e) {
            return redirect('/posts')->with('error','Unauthorized page!');
            }
        }

}
