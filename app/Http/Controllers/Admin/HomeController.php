<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\slider;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Hash;
use Auth;

class HomeController extends Controller
{
    //
    public function index()
    {
        $customers = User::where("is_admin",0)->count();
        $pending_orders = Order::where("status","Pending")->count();
        $rejected_orders = Order::where("status","Rejected")->count();
        $completed_orders = Order::where("status","Confirmed")->count();
        $total_orders = Order::count();
        $today_orders = Order::whereDate("created_at",Carbon::today())->count();
        $total_sale = Order::where("payment_status","Completed")->sum("total_price");
        $month_sale = Order::where("payment_status","Completed")->whereMonth("created_at",Carbon::today()->month)->sum("total_price");
        return view('admin.home',compact('customers','pending_orders','rejected_orders','completed_orders','total_orders','today_orders','total_sale','month_sale'));
    }
    public function products() {
        return view('admin.products');
    }
    public function addproducts() {
        return view('admin.add-product');
    }
    public function category() {
        return view('admin.category');
    }
    public function addcategory() {
        return view('admin.add-category');
    }
    public function subcategory() {
        return view('admin.sub-category');
    }
    public function subcategoryadd() {
        return view('admin.add-subcategory');
    }

    public function customers(){
        $customers = User::where("is_admin",0)->orderBy("id","desc")->paginate(50);
        return view('admin.customers.index',compact('customers'));
    }

    public function profile(){
        return view('admin.profile.index');
    }

    public function update_profile(Request $request){
        $request->validate(["email"=>"required","name"=>"required"]);

        if($request->password  != null && !Hash::check($request->old_password,Auth::user()->password)){
            return redirect()->back()->with('error',"invalid old password");
        }   

        $user = User::findOrFail(Auth::user()->id);
        $user->email = $request->email;
        $user->name = $request->name;

        if($request->password  != null && $request->old_password != null){
            $user->password = Hash::make($request->password);
        }

        $user->save();


        

        return redirect()->back()->with("success","profile update successfully");
    }

    public function sliders() {

        $data =  slider::orderBy('id','desc')->paginate(50);

        return view('admin.slider.index', compact('data'));
    }

    public function add_slider() {

        return view('admin.slider.create');
    }

    public function store_slider(Request $request) {
        $request->validate([
             'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/sliders'), $imageName);

        $slider = new slider();
         $slider->image = 'uploads/sliders/' . $imageName;
        $slider->save();

        return redirect()->route('admin.sliders')->with('success', 'Slider created successfully.');
    }

    public function edit_slider($id) {
        $data = slider::where('id', $id)->first();

        return view('admin.slider.edit', compact('data'));
    }

    public function update_slider(Request $request, $id) {
        // $request->validate([
        //     'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]);

        $slider = slider::findOrFail($id);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/sliders'), $imageName);
            $slider->image = 'uploads/sliders/' . $imageName;
        }

        $slider->save();

        return redirect()->route('admin.sliders')->with('success', 'Slider updated successfully.');
    }

    public function delete_slider($id) {

        $slider = slider::findOrFail($id);

        if (file_exists(public_path($slider->image))) {
            unlink(public_path($slider->image));
        }

        $slider->delete();

        return redirect()->route('admin.sliders')->with('success', 'Slider deleted successfully.');
    }
}
