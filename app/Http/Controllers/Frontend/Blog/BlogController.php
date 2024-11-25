<?php

namespace App\Http\Controllers\Frontend\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = BlogPost::with('blog_comments')->latest()->paginate(5);
        $categories = BlogCategory::all();
        $most_viewed = BlogPost::orderBy('number_of_views', 'desc')
            ->limit(4)
            ->get();
        return view('frontend.blog.index', compact('blogs', 'categories', 'most_viewed'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::select('id', 'name')->get();
        return view('frontend.blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        $data = $request->validated();

        if($request->hasFile('image'))
        {
          $image = $request->file('image');
          $imageNewName = time() . '.' . $image->getClientOriginalExtension();
          $image->storeAs('blog', $imageNewName, 'public');
        }

        $data['image'] = $imageNewName;
        $data['user_id'] = auth()->user()->id;

        BlogPost::create($data);

        notyf()
            ->duration(4000)
            ->success('Blog Post Created Successfully');

        return redirect()->route('blogs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $mainBlog = BlogPost::with(['blog_comments'=>function($query){
            $query->latest()->limit(3);
        }])->whereSlug($slug)->first();

        $categories = BlogCategory::all();

        $most_viewed = BlogPost::orderBy('number_of_views', 'desc')
            ->limit(4)
            ->get();

        $mainBlog->increment('number_of_views');
        return view('frontend.blog.single-blog', compact('mainBlog', 'categories', 'most_viewed'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogPost $blog)
    {
        $categories = BlogCategory::select('id', 'name')->get();
        return view('frontend.blog.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, BlogPost $blog)
    {
        $data = $request->validated();

        if($request->hasFile('image'))
        {
            unlink(storage_path('app/public/blog/'.$blog->image));
            $image = $request->file('image');
            $imageNewName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('blog', $imageNewName, 'public');
            $data['image'] = $imageNewName;
        }

        $blog->update($data);
        notyf()
            ->duration(4000)
            ->success('Blog Post Updated Successfully');

        return redirect()->route('blogs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = BlogPost::find($id);
        unlink(storage_path('app/public/blog/'.$blog->image));
        $blog->delete();
        return response('Blog deleted successfully.', 200);
    }

    public function myBlogs()
    {
        $blogs = BlogPost::where('user_id', auth()->user()->id)->latest()->get();
        return view('frontend.blog.my-blogs', compact('blogs'));
    }
}
