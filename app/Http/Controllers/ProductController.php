<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\unit;
use App\Models\category;
use App\Models\subcategory;
use App\Models\product;
use App\Models\product_unit;
use App\Models\product_image;
use File;

class ProductController extends Controller
{
    public function index()
    {
        $products = product::with('category')->with("sub_category")->with("image")->with('product_units')->orderBy("id", "desc")->paginate(50);
        return view('admin.products.index', compact('products'));
    }
    public function create(Request $request)
    {
        $units = unit::all();
        $category = category::all();

        return view('admin.products.create', compact('units', 'category'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "name" => "required",
            "category" => "required",
            "unit" => "required",
            "unit_type" => "required",
            "quantity" => "required",
            "price" => "required",
            "description" => "required",
            "image" => "required",
            // "status" => "required",
        ]);


        if (!$request->hasFile('image')) {
            return redirect()->back()->with("error", "Invalid Image Type");
        }

        if ($request->unit[0] == null) {
            return redirect()->back()->with("error", "Unit is required");
        } else {
            foreach ($request->unit as $key => $value) {
                if (empty($request->quantity[$key])) {
                    return redirect()->back()->with("error", "Quantity is required for each Product unit");
                }
                if (empty($request->price[$key])) {
                    return redirect()->back()->with("error", "Price is required for each Product unit");
                }
                if (empty($request->unit_type[$key])) {
                    return redirect()->back()->with("error", "Unit type is required for each Product unit");
                }
            }
        }
        // if ($request->quantity[0] == null) {
        //     return redirect()->back()->with("error", "Quantity is required");
        // }
        // if ($request->price[0] == null) {
        //     return redirect()->back()->with("error", "Price is required");
        // }
        // if ($request->unit_type[0] == null) {
        //     return redirect()->back()->with("error", "Unit Type is required");
        // }
        

        $product = new product();
        $product->name = $request->name;
        $product->category_id = $request->category;
        $product->subcategory_id = $request->sub_category;
        // $product->status = $request->status;
        $product->description = $request->description;
        $product->discount = $request->discount ?? 0;
        $product->save();

        // dd($request->unit);
        foreach ($request->unit as $key => $value) {
//            if ($request->discount > $request->price[$key]) {
//     return redirect()->back()->with('error', 'Discount cannot be greater than the price.');
// }

            if ($value == null) {
                continue;
            }
            $unit = new product_unit();
            $unit->product_id = $product->id;
            $unit->unit = $value;
            $unit->unit_type = $request->unit_type[$key];
            $unit->quantity = $request->quantity[$key];
            $unit->price = $request->price[$key];
            $unit->save();
        }

        if ($request->image && count($request->image) > 0) {
            foreach ($request->image as $key => $image) {
                $path = "uploads/products/";
                $file = $image;
                $filename  = uniqid() . "_" . $file->getClientOriginalName();
                $file->move(public_path($path), $filename);

                $image = new product_image();
                $image->product_id = $product->id;
                $image->image = $path . $filename;
                $image->save();
            }
        }


        return redirect()->route('product.index')->with("success", "Add Successfully!");
    }
    public function edit($id)
    {
        $product = product::with(["image"])->findOrFail($id);
        $product_units = product_unit::where('product_id', $id)->get();
        $units = unit::all();
        $category = category::all();
        $subcategory = subcategory::where("category_id", $product->category_id)->get();
        return view('admin.products.edit', compact('product', 'units', 'category', 'product_units', 'subcategory'));
    }


    public function update($id, Request $request)
    {
        $request->validate([
            "name" => "required",
            "category" => "required",
            "unit" => "required",
            "unit_type" => "required",
            "quantity" => "required",
            "price" => "required",
            "description" => "required",
            // "status" => "required",
        ]);
        if ($request->unit[0] == null) {
            return redirect()->back()->with("error", "Unit is required");
        } else {
            foreach ($request->unit as $key => $value) {
                if (empty($request->quantity[$key])) {
                    return redirect()->back()->with("error", "Quantity is required for each Product unit");
                }
                if (empty($request->price[$key])) {
                    return redirect()->back()->with("error", "Price is required for each Product unit");
                }
                if (empty($request->unit_type[$key])) {
                    return redirect()->back()->with("error", "Unit type is required for each Product unit");
                }
            }
        }

        if ($request->image != "" && !$request->hasFile('image')) {
            return redirect()->back()->with("error", "Invalid Image Type");
        }

        // if ($request->unit[0] == null || $request->unit_type[0] == null || $request->price[0] == null || $request->quantity[0] == null) {
        //     return redirect()->back()->with("error", "All fields is required!");
        // }
        product_unit::where("product_id", $id)->delete();

        $product = product::findOrFail($id);
        $product->name = $request->name;
        $product->category_id = $request->category;
        $product->subcategory_id = $request->sub_category;
        // $product->status = $request->status;
        $product->description = $request->description;
        $product->discount = $request->discount ?? 0;
        $product->save();

        foreach ($request->unit as $key => $value) {
            if ($value == null || $request->unit_type[$key] == null) {
                continue;
            }
            $unit = new product_unit();
            $unit->product_id = $product->id;
            $unit->unit = $value;
            $unit->unit_type = $request->unit_type[$key];
            $unit->quantity = $request->quantity[$key];
            $unit->price = $request->price[$key];
            $unit->save();
        }

        if ($request->image && count($request->image) > 0) {
            foreach ($request->image as $key => $image) {

                $image = product_image::where("product_id", $product->id)->first();
                if ($image != null) {
                    if (File::exists(public_path($image->image))) {
                        File::delete(public_path($image->image));
                    }
                }

                if ($image == null) {
                    $image = new product_image();
                    $image->product_id = $product->id;
                }

                $path = "uploads/products/";
                $file = $request->image[$key];
                $filename  = uniqid() . "_" . $file->getClientOriginalName();
                $file->move(public_path($path), $filename);


                $image->image = $path . $filename;
                $image->save();
            }
        }
        return redirect()->route('product.index')->with("success", "Update Successfully!");
    }
    public function destroy($id)
    {
        $product = product::findOrFail($id);
        $image = product_image::where("product_id", $id)->first();

        if ($image != null) {
            if (!File::exists(public_path($image->image))) {
                File::delete(public_path($image->image));
            }

            $image->delete();
        }

        product_unit::where("product_id", $id)->delete();

        $product->delete();

        return redirect()->route('product.index')->with("success", "Delete Successfully!");
    }



    public function delete_file($id)
    {
        $image = product_image::where("product_id", $id)->first();

        if ($image == null) {
            return redirect()->back('error', "Image Not Found");
        }
        if (!File::exists(public_path($image->image))) {
            return redirect()->back('error', "File Already Deleted");
        }
        File::delete(public_path($image->image));

        $image->delete();

        return redirect()->back();
    }

    public function get_category($id)
    {

        $category = subcategory::where("category_id", $id)->get();
        return response()->json($category);
    }


    public function product_stocks(){
        $stocks = product_unit::with(["product"=>function($q){
            $q->join("categories","categories.id","products.category_id")->selectRaw("products.name,products.id,categories.name as category_name");
        }])->paginate(50);

        return view('admin.stocks.index',compact('stocks'));
    }

    public function update_stocks(Request $request,$id){
        $request->validate(['quantity'=>"required"]);
        if($request->quantity <=0){
            return redirect()->back()->with("error","Quantity should be greater than 0");
        }

        $stock = product_unit::findOrFail($id);
        $stock->quantity = $request->quantity;
        $stock->save();

        return redirect()->back()->with("success","Quantity update successfully");

    }
}
