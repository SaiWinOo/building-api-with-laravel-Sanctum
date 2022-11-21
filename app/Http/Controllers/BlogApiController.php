<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs  = Blog::latest('id')->get();
        return response()->json($blogs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:5',
            'description' => 'required|min:20',
            'category_id' => 'required',
            'featured_image' => 'required|file|mimes:jpg,jpeg,png,gif'
        ]);
        $newName = uniqid().'_featured_image_'.$request->file('featured_image')->extension();
        $request->file('featured_image')->storeAs('public',$newName);
        Blog::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'featured_image' => $newName,
        ]);
        return response()->json(['message' => 'Blog post is created!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog = Blog::find($id);
        if(is_null($blog)){
            return response()->json(['message' => 'Blog post is not found!']);
        }
        return response()->json($blog);
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
        $request->validate([
            'title' => 'nullable|min:5',
            'description' => 'nullable|min:20',
            'category_id' => 'nullable',
            'featured_image' => 'nullable',
        ]);
        $blog = Blog::find($id);
        if(is_null($blog)){
            return response()->json(['message' => 'Blog post is not found!']);
        }
        if($request->title){
            $blog->title = $request->title;
        }
        if($request->description){
            $blog->description = $request->description;
        }
        if($request->category_id){
            $blog->category_id = $request->category_id;
        }
        $blog->update();
        if($request->featured_image){
            $newName = uniqid().'_featured_image_.'.$request->file('featured_image')->extension();
            $request->file('featured_image')->storeAs('public',$newName);
            $blog->featured_image = $newName;
        }
        return response()->json(['message' => 'Blog post is updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);
        if(!$blog){
            return response()->json(['message' => 'blog post is not found!']);
        }
        $blog->delete();
        return response()->json(['message' => 'blog post is deleted!']);
    }
}
