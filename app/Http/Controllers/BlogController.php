<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Support\Facades\File;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $blogs = Blog::paginate(20);
        return view("admin.blogs.index", compact("blogs"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBlogRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreBlogRequest $request)
    {
        $data = $request->only('title', 'description', 'content', 'author');
        if ($request->image) {
            $path = "uploads/blogs/";
            $file = $request->image;
            $filename  = uniqid() . "_" . $file->getClientOriginalName();
            $file->move(public_path($path), $filename);
            $data['image'] = $path . $filename;
        }
        Blog::create($data);
        return redirect()->back()->with('success','Blog Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\View\View
     */
    public function show(Blog $blog)
    {
        return view('admin.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\View\View
     */
    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBlogRequest  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $data = $request->only('title', 'description', 'content', 'author');
        if ($request->image) {
            if(File::exists($blog->image)) {
                File::delete($blog->image);
            }
            $path = "uploads/blogs/";
            $file = $request->image;
            $filename  = uniqid() . "_" . $file->getClientOriginalName();
            $file->move(public_path($path), $filename);
            $data['image'] = $path . $filename;
        }
        $blog->update($data);
        return redirect()->route('blog.index')->with('success','Blog Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Blog $blog)
    {
        if(File::exists($blog->image)) {
            File::delete($blog->image);
        }
        $blog->delete();
        return redirect()->back()->with('success','Blog Deleted Successfully');
    }
}
