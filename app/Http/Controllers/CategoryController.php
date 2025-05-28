<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\category;
use File;


class CategoryController extends Controller
{
    public function index(){
        $category = category::orderBy("id","desc")->paginate(50);
        return view('admin.category.index',compact('category'));
    }
    public function create(){
        return view('admin.category.create');
    }
    public function store(Request $request){
        $request->validate([
            "name"=>"required",
            "slug"=>"required|unique:categories",
        ]);
        if($request->image != "" && !$request->hasFile('image')){
            return redirect()->back()->with("error","Invalid Image Type");
        }


        $category = new category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;

        if($request->image != ""){
            $path = "uploads/category/";
            $file = $request->image;
            $filename  = uniqid()."_".$file->getClientOriginalName();
            $file->move(public_path($path),$filename);
            $category->image = $path.$filename;
        }

        $category->save();

        return redirect()->route('category.index')->with("success","Add Successfully!");


    }
    public function edit($id){
        $category = category::findOrFail($id);
        return view('admin.category.edit',compact('category'));
    }
    public function update($id , Request $request){
        $request->validate([
            "name"=>"required",
            "slug"=>"required",
        ]);
        if($request->image != "" && !$request->hasFile('image')){
            return redirect()->back()->with("error","Invalid Image Type");
        }




        $category = category::findOrFail($id);
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;

        if($request->image != ""){
            $path = "uploads/category/";
            $file = $request->image;
            $filename  = uniqid()."_".$file->getClientOriginalName();
            $file->move(public_path($path),$filename);
            $category->image = $path.$filename;
        }

        $category->save();

        return redirect()->route('category.index')->with("success","Add Successfully!");
    }
    public function destroy($id){
        $category = category::findOrFail($id);

        if(!File::exists(public_path($category->image))) {
            return redirect()->back()->with('message',"File Already Deleted");
            exit;
        }
        File::delete(public_path($category->image));
        $category->delete();
        return redirect()->route('category.index')->with("success","Delete Successfully!");

    }

    public function delete_file($id){

        $category = category::findOrFail($id);

        if(!File::exists(public_path($category->image))) {
            return redirect()->back()->with('error',"File Already Deleted");
            exit;
        }
        File::delete(public_path($category->image));
        $category->image = null;
        $category->save();

        return redirect()->back();

    }
}
