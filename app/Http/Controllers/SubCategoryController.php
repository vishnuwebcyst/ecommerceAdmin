<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\subcategory;
use App\Models\category;


class SubCategoryController extends Controller
{
    public function index()
    {
        $category = subcategory::with('category')->orderBy("id", "desc")->paginate(50);
        return view('admin.sub_category.index', compact('category'));
    }
    public function create()
    {
        $category = category::all();
        return view('admin.sub_category.create', compact('category'));
    }
    public function store(Request $request)
    {
        $request->validate([
            "category_id" => "required",
            "name" => "required|unique:categories",
            "slug" => "required|unique:categories",
        ]);



        $category = new subcategory();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->category_id = $request->category_id;
        $category->description = $request->description;
        if ($request->image != "") {
            $path = "uploads/sub_categories/";
            $file = $request->image;
            $filename  = uniqid() . "_" . $file->getClientOriginalName();
            $file->move(public_path($path), $filename);
            $category->image = $path . $filename;
        }

        $category->save();



        return redirect()->route('sub_category.index')->with("success", "Add Successfully!");
    }
    public function edit(subcategory $sub_category)
    {
        // $category = subcategory::findOrFail($id);
        // dd($sub_category);
        $categories = category::get();
        return view('admin.sub_category.edit', compact('sub_category', 'categories'));
    }
    public function update(subcategory $sub_category, Request $request)
    {
        $request->validate([
            "name" => "required",
            "slug" => "required",
            "category_id" => "required",
        ]);

        $data = $request->only(['name', 'slug', 'category_id', 'description']);
        $sub_category->update($data);

        return redirect()->route('sub_category.index')->with("success", "Add Successfully!");
    }
    public function destroy(subcategory $sub_category)
    {
        // $category = subcategory::findOrFail($id);
        $sub_category->delete();
        return redirect()->route('sub_category.index')->with("success", "Delete Successfully!");
    }
}