<?php

namespace App\Http\Controllers\Frontend\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    public function store(StoreCommentRequest $request)
    {
        $data = $request->validated();

        if($data){
            notyf()->success('Thanks for your comment!');
        }

        BlogComment::create($data);
        return redirect()->back();
    }
}
