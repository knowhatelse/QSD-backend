<?php

namespace App\Http\Controllers;

use App\Mail\PaymentSuccessfull;
use App\Models\Order;
use App\Models\OrderProductSize;
use App\Models\Product;
use App\Models\ProductSize;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Psy\Util\Str;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class OrderController extends Controller
{
    public function payment(Request $request){
        $request->validate([
            'payment_method'=>'required|string',
            'address'=>'required|string',
            'city'=>'required|string',
            'zip_code'=>'required|integer',
            'phone'=>'integer',
            'total_price'=>'required|numeric',
            'products'=>'required|array',
            'products.*.product_id'=>'required|exists:products,id',
            'products.*.size_id'=>'required|exists:sizes,id',
            'products.*.quantity'=>'required|integer'
        ]);

        $user=auth()->guard('api')->user();
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $connectedAccountId='acct_1N9EGFF35CxH0pFC';

        $paymentIntent = PaymentIntent::create([
            'amount'=>$request->total_price,
            'currency'=>'usd',
            'payment_method'=>$request->payment_method,
        ]);

        $paymentIntentId=$paymentIntent->id;

        $order = Order::create([
            'user_id'=>$user->id,
            'transaction_id'=>$paymentIntentId,
            'total'=>$request->total_price,
            'address'=>$request->address,
            'city'=>$request->city,
            'zip_code'=>$request->zip_code,
            'phone'=>$request->phone,
        ]);

        foreach($request->products as $productData) {
            $productSize = ProductSize::where('product_id',$productData['product_id'])->where('size_id',$productData['size_id'])->first();

            if(!$productSize){
                return response()->json(['message'=>'Product not found'],400);
            }
            if($productSize->amount<$productData['quantity']||$productData['quantity']<=0){
                $product=Product::where('id',$productData['product_id'])->first();
                $productName=$product->name;
                return response()->json(['message'=>"$productName is not in stock"],400);
            }
            $orderProductSize = OrderProductSize::create([
                'quantity'=>$productData['quantity'],
                'product_size_id'=>$productSize->id,
                'order_id'=>$order->id,
            ]);
            $order->orderProductSizes()->save($orderProductSize);
        }
        $paymentIntent->confirm(['payment_method'=>$request->payment_method],['stripe_account'=>$connectedAccountId]);
        Mail::to($user->email)->send(new PaymentSuccessfull($order));
        return response()->json(['message' => 'Order created successfully.', 'order' => $order->load('user','orderProductSizes.product.product','orderProductSizes.size')]);


    }
}
