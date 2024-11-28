<?php

namespace App\Http\Controllers\Frontend\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Models\BlogComment;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    public function index($slug)
    {
        $post = BlogPost::whereSlug($slug)->first();
        $comments = $post->blog_comments()->latest()->get();
        return response()->json($comments);
    }
    public function store(StoreCommentRequest $request)
    {
        $data = $request->validated();

//        if($data){
//            notyf()->success('Thanks for your comment!');
//        }

        $comment = BlogComment::create($data);

        if(!$comment){
            return response()->json([
                'data'=>'Operation failed',
            ]);

        }

        return response()->json([
            'msg'=>'Comment Stored Successfully!',
            'comment'=>$comment,
            'status'=>201,
        ]);
//        return redirect()->back();
    }
}
