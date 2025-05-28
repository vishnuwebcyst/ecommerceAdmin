<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\product;
use App\Models\product_unit;
use Illuminate\Http\Request;
use DB;

use Tymon\JWTAuth\Facades\JWTAuth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $orders = Order::with('user')->when($request->user_id,function($q) use($request){
            $q->where("user_id",$request->user_id);
        })->orderBy('created_at','desc')->paginate(25);
        return view('admin.orders.index', compact('orders'));
    }
    public function pending_orders()
    {
        $orders = Order::with('user')->where('status',"Pending")->orderBy('created_at','desc')->paginate(25);
        return view('admin.orders.pending', compact('orders'));
    }
    public function rejected_orders()
    {
        $orders = Order::with('user')->where('status',"Rejected")->orderBy('created_at','desc')->paginate(25);
        return view('admin.orders.rejected', compact('orders'));
    }

    public function completed_orders()
    {
        $orders = Order::with('user')->where('status',"Delivered")->orderBy('created_at','desc')->paginate(25);
        return view('admin.orders.completed', compact('orders'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(StoreOrderRequest $request)
    // {
    //     $data = $request->except('products', 'token');
    //     $data['user_id'] = JWTAuth::user()->id;
    //     $total = 0;
    //     $total_quantity = 0;
    //     foreach ($request->products as $product) {
    //         $total += $product['price'] * $product['quantity'];
    //         $total_quantity += $product['quantity'];
    //     }
    //     $data['total_price'] = $total;
    //     $data['order_id'] = time() . JWTAuth::user()->id;
    //     $data['total_quantity'] = $total_quantity;
    //     $order = Order::create($data);

    //     foreach ($request->products as $item) {
    //         $product = product::where('id', $item['product_id'])->first();
    //         $productUnit = product_unit::where('id', $item['id'])->first();
    //         // \Log::info($item);
    //         OrderProducts::create([
    //             'order_id' => $order->id,
    //             'product_id' => $item['product_id'],
    //             'product_unit_id' => $item['id'],
    //             'name' => "{$product->name} ({$productUnit->unit} {$productUnit->unit_type})",
    //             'price' => $productUnit->price,
    //             'quantity'=> $item['quantity'],
    //             'total' => $productUnit->price * $item['quantity'],
    //         ]);
    //     }
    //     return response()->json(['status' => true, 'message' => 'Order Placed Successfully']);
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order->load(['orderProducts.product.image', 'address']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        
        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            "remarks"=>$request->remarks
        ]);

        if($request->status  == "Cancelled" || $request->status == 'Rejected'){

            $product_orders = OrderProducts::where("order_id",$order->id)->get();
            foreach($product_orders as $orders){
                DB::update("UPDATE `product_units` SET `quantity`=`quantity`+'" . $orders->quantity . "' WHERE `id`=". $orders->product_unit_id);
            }

        }


        return redirect()->back()->with('success', 'Order Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function update_order(Request $request,Order $order)
    {

        $request->validate([
            'status' => 'required|in:Pending,Processing,Confirmed,Dispatched,Out For Delivery,Delivered,Cancelled,Rejected',
            'order_id' => 'required|exists:orders,id',
            "remarks"=>"required"
        ]);

        Order::where('id', $request->order_id)->update(['status' => $request->status,'payment_status' => $request->payment_status,"remarks"=>$request->remarks]);

        if($request->status  == "Cancelled" || $request->status == 'Rejected'){
            $product_orders = OrderProducts::where("order_id",$request->order_id)->get();
            foreach($product_orders as $orders){
                DB::update("UPDATE `product_units` SET `quantity`=`quantity`+'" . $orders->quantity . "' WHERE `id`=". $orders->product_unit_id);
            }
        }
        return redirect()->back()->with('success', 'Order Status Updated');
    }
}
