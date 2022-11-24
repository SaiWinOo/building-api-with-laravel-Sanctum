<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::latest('id')->get();
        return CommentResource::collection($comments);
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
            'comment'=> 'required',
            'blog_id' => 'required',
        ]);
        Comment::create([
            'comment' => $request->comment,
            'blog_id' => $request->blog_id,
            'user_id' => Auth::id(),
        ]);
        return response()->json(['message' => 'commented successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comment::find($id);
        if(is_null($comment)){
            return response()->json(['message' => 'Comment is not found!']);
        }
        return response()->json($comment);
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
        $comment = Comment::find($id);
        if($request->comment){
                $comment->comment = $request->comment;
        }
        $comment->update();
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
        $comment = Comment::find($id);
        if(is_null($comment)){
            return response()->json(['message' => 'Comment is not found!']);
        }
        $comment->delete();
        return response()->json(['message' => 'Comment is deleted!']);
    }
}
