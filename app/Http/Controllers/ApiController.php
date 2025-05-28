<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Mail\OrderMail;
use App\Models\Blog;
use App\Models\slider;
use App\Models\category;
use App\Models\product;
use App\Models\subcategory;
use App\Models\User;
use App\Models\userProducts;
use App\Models\product_unit;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use App\Mail\forgetMail;
use DB;
use Illuminate\Support\Facades\Hash;
use App\Models\admins;


class ApiController extends Controller
{
    /** Get All Categories */
    public function categories(): JsonResponse
    {
        $categories = Category::with('subCategories')->get();
        $status = true;
        return response()->json(compact("categories", 'status'));
    }

    public function sub_categories(Request $request, string $slug): JsonResponse
    {
        $category = category::where('slug', $slug)->first();
        $sub_categories = subcategory::where('category_id', $category->id)->get();
        $status = true;
        return response()->json(compact("sub_categories", 'status'));
    }

    /** Get Top Categories */
    public function top_categories(): JsonResponse
    {
        $categories = category::orderBy("id", "desc")->limit(6)->get();
        $status = true;
        return response()->json(compact("categories", 'status'));
    }

    /** Get Products according to Category */
    public function category_products(Request $request): JsonResponse
    {
        // $request->validate([
        //     'category' => 'exists:categories,slug',
        //     'sub' => 'exists:sub_categories,slug',
        // ]);
        $validator = Validator::make($request->all(), [
            'category' => 'exists:categories,slug',
            'sub' => 'exists:sub_categories,slug',
        ]);

        if ($validator->fails()) {
            $status = false;
            $message = 'No Category or Sub category found';
            return response()->json(compact('status', 'message'), 400);
        }
        // with(['product_units' => function($unit) use ($request) {
        //     if ($request->has('filter')) {
        //         $unit->where('unit', $request->get('filter'));
        //     }
        // }])->

        $products = product::with('product_units', 'image')->when($request->category, function ($query) use ($request) {
            $category = category::where('slug', $request->category)->first();
            $query->where("category_id", $category->id);
        })->when($request->sub, function ($query) use ($request) {
            $subCat = subcategory::where('slug', $request->sub)->first();
            return $query->where('subcategory_id', $subCat->id);
        })->whereHas('product_units', function ($query) use ($request) {
            if ($request->has('filter')) {
                $query->where('unit', '=', $request->get('filter'));
            }
        })->orderBy("id", "desc")->paginate(24);

        $products->map(function ($data) {
            $product = product_unit::where('product_id', $data->id)->first();
            $discount = $data->discount;

            $discount_price =  $product->price - $discount;
            $data->discount_price = $discount_price;
            return $data;
        });
        $status = true;
        return response()->json(compact("products", 'status'));
    }

    /** Get Unique Units */
    public function uniqueUnits(): JsonResponse
    {
        $units = product_unit::select('unit')
            ->where('unit_type', 'ml')
            ->distinct()
            ->get();
        $status = true;
        $filter = Session::get('filter');

        return response()->json(compact('units', 'status', 'filter'));
    }

    /** Get All Products */
    public function products(Request $request): JsonResponse
    {
        $products = product::with('product_units', 'image')->orderBy('id', 'desc')->paginate(10);
         
        $products->map(function ($data) {
            $product = product_unit::where('product_id', $data->id)->first();
            $discount = $data->discount;

            $discount_price =  $product->price - $discount;
            $data->discount_price = $discount_price;
            return $data;
        });
        $status = true;
        return response()->json(compact("products", 'status'));
    }

    /** Get Product by Id */
    public function productById(Request $request, int $id): JsonResponse
    {
        $product = product::with('product_units', 'image')->find($id);
        $status = true;
        return response()->json(compact("product", 'status'));
    }

    /** Related Products */
    public function relatedProducts(Request $request, Product $product): JsonResponse
    {
        $products = product::with('product_units', 'image')->where('category_id', $product->category_id)->where('id', '!=', $product->id)->orderBy('id', 'desc')->limit(8)->get();
        $products->map(function ($data) {
            $product = product_unit::where('product_id', $data->id)->first();
            $discount = $data->discount;

            $discount_price =  $product->price - $discount;
            $data->discount_price = $discount_price;
            return $data;
        });
        $status = true;
        return response()->json(compact('products', 'status'));
    }

    /** Get Featured Products */
    public function featured_products(Request $request): JsonResponse
    {
        $products = product::with('product_units', 'image')->orderBy("id", "desc")->limit(8)->get();
        $status = true;
        return response()->json(compact("products", 'status'));
    }

    /** Get Best Seller Products */
    public function best_sellers(Request $request): JsonResponse
    {
        $products = product::with('product_units', 'image')->inRandomOrder()->limit(8)->get();
        $products->map(function ($data) {
            $product = product_unit::where('product_id', $data->id)->first();
            $discount = $data->discount;

            $discount_price =  $product->price - $discount;
            $data->discount_price = $discount_price;
            return $data;
        });
        $status = true;
        return response()->json(compact('products', 'status'));
    }

    public function search(Request $request): JsonResponse
    {
        $products = product::with('product_units', 'image')->where('name', 'LIKE', "%{$request->search}%")->paginate(24);
        $status = true;
        return response()->json(compact('products', 'status'));
    }

    public function orders(): JsonResponse
    {
        $orders = Order::where('user_id', JWTAuth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        return response()->json(['orders' => $orders, 'status' => true]);
    }

    public function placeOrder(StoreOrderRequest $request): JsonResponse
    {
        $data = $request->except('products', 'token');
        $data['user_id'] = JWTAuth::user()->id;
        $total = 0;
        $total_quantity = 0;
        foreach ($request->products as $product) {
            $total += $product['price'] * $product['quantity'];
            $total_quantity += $product['quantity'];
        }
        $order_id = JWTAuth::user()->id . time();

        $data['total_price'] = $total;
        $data['order_id'] = $order_id;
        $data['paymet_method'] = $request->order_id ? 'cashfree' : 'COD';
        $data['paymet_method'] = $request->discount;
        $data['discount'] = $total_quantity;
        $order = Order::create($data);

        $product['invoice_id'] = 1;
        $product['invoice_description'] = "Order #{$product['invoice_id']} Bill";

        // $product['return_url'] = route('success.payment');
        // $product['cancel_url'] = route('cancel.payment');
        $product['total'] = $total;




        // $paypalModule = new Orders;

        foreach ($request->products as $item) {
            $product = product::where('id', $item['product_id'])->first();
            $productUnit = product_unit::where('id', $item['id'])->first();

            OrderProducts::create([
                'order_id' => $order->id,
                'discount' => $item['discount'],
                'product_id' => $item['product_id'],
                'product_unit_id' => $item['id'],
                'name' => "{$product->name} ({$productUnit->unit} {$productUnit->unit_type})",
                'price' => $productUnit->price,
                'quantity' => $item['quantity'],
                'total' => $productUnit->price * $item['quantity'],
            ]);
        }
        return response()->json(['status' => true, 'message' => 'Order Placed Successfully', 'order_id' => $order_id]);
    }

    public function orderDetails(int $order_id): JsonResponse
    {
        $order = Order::with('orderProducts.product.image', 'address')->where('order_id', $order_id)->first();

        return response()->json(['status' => true, 'order' => $order]);
    }

    public function latestBlog(): JsonResponse
    {
        $blogs = Blog::orderBy('created_at', 'desc')->limit(6)->get();
        return response()->json(['status' => true, 'blogs' => $blogs]);
    }

    /**
     * Deal Of The Week
     * @return JsonResponse
     */
    public function dealOfWeek(): JsonResponse
    {
        $blogs = Settings::orderBy('created_at', 'desc')->limit(6)->get();
        return response()->json(['status' => true, 'blogs' => $blogs]);
    }

    public function getOrders()
    {
        $orders = Order::where('user_id', JWTAuth::user()->id)->orderBy('created_at', 'desc')->paginate(10);

        return response()->json(['orders' => $orders, 'status' => true]);
    }

    public function storeOrder(StoreOrderRequest $request)
    {
        $data = $request->except('products', 'token');
        $data['user_id'] = JWTAuth::user()->id;
        $total = 0;
        $total_quantity = 0;
        $total_discount = 0;
        $discount = 0;

        foreach ($request->products as $cartItem) {
            $discount += $cartItem['discount'] * $cartItem['quantity'];
        }
        \Log::info($discount);
        foreach ($request->products as $cartItem) {
            // Calculate total price and total quantity from the selected unit price and quantity
            $unitPrice = $cartItem['selectedUnit']['price'];
            $quantity = $cartItem['quantity'];
            $unitId  = $cartItem['selectedUnit']['id'];

            $productUnit = product_unit::find($unitId);


            // $discount = $cartItem['discount'];



            if ($productUnit->quantity < $quantity) {
                continue;
            }
            $discount_with_qty =  $discount * $quantity;

            $total += $unitPrice * $quantity;
            $total_discount += $discount_with_qty;

            $total_quantity += $quantity;
        }

        // Add GST (5%) to the total price
        $data['total_price'] = $total;
        $data['order_id'] = time() . JWTAuth::user()->id;
        $data['total_quantity'] = $total_quantity;
        $data['discount'] = $discount;
        $order = Order::create($data);

        foreach ($request->products as $item) {
            $productId = $item['product']['id'];
            $unitId = $item['selectedUnit']['id'];
            $quantity = $item['quantity'];

            $product = Product::find($productId);
            $productUnit = product_unit::find($unitId);

            if ($productUnit->quantity < $quantity) {
                continue;
            }
            // Create an entry in OrderProducts with all necessary fields
            OrderProducts::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'product_unit_id' => $unitId,
                'discount' => $item['discount'],
                'name' => "{$product->name} ({$productUnit->unit} {$productUnit->unit_type})",
                'price' => $productUnit->price,
                'quantity' => $quantity,
                'total' => $productUnit->price * $quantity,
            ]);
            DB::update("UPDATE `product_units` SET `quantity`=`quantity`-'" . $quantity . "' WHERE `id`=" . $unitId);
        }

        // $link = env('SPA_LINK') . '/orders';
        // $message = 'Thank you for your order. Your order has been placed successfully';

        // Mail::to(JWTAuth::user()->email)->send(new OrderMail(
        //     JWTAuth::user()->name,
        //     $link,
        //     $message,
        //     $order->orderProducts,
        //     $total + round($total * 0.05, 2)
        // ));

        return response()->json(['status' => true, 'message' => 'Order Placed Successfully']);
    }


    public function userImageUpdate(Request $request)
    {

        $request->validate([
            "image" => "required",
        ]);

        if (!$request->hasFile('image')) {
            return redirect()->back()->with("error", "Invalid Image Type");
        }

        $file = $request->image;
        $filename = uniqid() . '_' . $file->getClientOriginalName();
        $file->move(public_path("uploads/user"), $filename);
        $user = new user();
        $user->image = $filename;
        $user->save();

        return response()->json(['status' => true, 'message' => 'Image Upload Successfully ']);
    }


    public function profile_update(Request $request, $id)
    {
        user::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return response()->json(['status' => true, 'message' => 'Profile Updated Successfully']);
    }


    public function forgotPwd(Request $request)
    {
        \Log::info($request->all());
        $rand = mt_rand(10000, 99999);
        $user = User::where("email", $request->email)->first();
        if (!$user) {
            return response()->json(["status" => 0, "error" => "Invalid User"]);
            exit;
        }
        $details = [
            'title' => 'Dear  ' . $user->name,
            'body' => "Your OTP is " . $rand
        ];
        Mail::to($user->email)->send(new forgetMail($details));

        User::where("email", $user->email)->update([
            "forgot_code" => $rand
        ]);
        return response()->json(["status" => 1]);
    }

    public function checkOTP(Request $request)
    {
        $user = User::where("email", $request->email)->first();
        if (!$user) {
            return response()->json(["status" => 0, "error" => "Invalid User"]);
            exit;
        }
        $code = $user->forgot_code;
        if ($user->forgot_code == null) {
            $code = $user->verified_code;
        }
        $reqCode = $request->otp;
        if ($reqCode != $code) {
            return response()->json(["status" => 2, "error" => "Wrong OTP"]);
            exit;
        }
        $user->is_verified = 1;
        $user->save();

        return response()->json(["status" => 1]);
    }

    public function updatePwd(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //      'password' => 'required|min:6',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['status' => false, 'error' => 'Password must be at least 6 characters'], 401);
        // }
        $user = User::where("email", $request->email)->first();
        if (empty($user)) {
            return response()->json(["status" => 0, "error" => "Invalid User"]);
            exit;
        }
        User::where("email", $user->email)->update([
            "password" => Hash::make($request->password),
            "show_pass" => $request->password
        ]);

        return response()->json(["status" => 1]);
    }

    public function masterLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()->first()], 401);
        }

        $master = admins::where('email', $request->email)->where('role', 'master')->first();
        if (empty($master)) {
            return response()->json(['error' => 'Not Found'], 401);
        }
        $credentials = request(['email', 'password']);

        if (Hash::check($request->password, $master->password)) {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['status' => false, 'error' => 'Email or Password is wrong'], 401);
            }

            return response()->json(['status' => true, 'token' => $token, 'message' => ' Login Successful', 'master' => $master], 200);
        }

        return response()->json(['status' => false, 'error' => 'Email or Password is wrong'], 401);
    }

    public function addAdmin(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()->first()], 401);
        }

        $admin = new admins();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password =  Hash::make($request->password);;
        $admin->show_pass = $request->password;
        $admin->phone = $request->phone;
        $admin->role = 'admin';

        
        if($request->hasFile('image')) {
            $file = $request->image;
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path("uploads/profile"), $filename);
            $admin->image = $filename;
        }

        $admin->save();

        return response()->json(['status' => true, 'success' => 'Admin Created Successfully!']);



    }

    public function sliders() {
        $sliders = slider::orderBy('id', 'desc')->get();

        return response()->json(['status' => true, 'sliders' => $sliders, ]);
    }

    public function setting() {
        $logo = Settings::where('type', 'logo')->first();

        return response()->json(['status' => true, 'logo' => $logo, ]);

    }
}
