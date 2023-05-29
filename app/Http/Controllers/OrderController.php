<?php

namespace App\Http\Controllers;

use App\Mail\PaymentSuccessfull;
use App\Models\Order;
use App\Models\OrderProductSize;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class OrderController extends Controller
{
    private function infoResponse($status, $message, $record = null): JsonResponse {
        if($record == null){
            return response()->json(['message' => $message,],$status);
        }
        if($message == ''){
            return response()->json(['data' => $record],$status);
        }
        return response()->json(['message' => $message, 'product' => $record],$status);
    }


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
        return response()->json(['message' => 'Order created successfully.', 'order' => $order]);


    }

    private function orders($user_id = null): JsonResponse {
        $query = Order::with('user', 'orderProductSizes.productSizes.products');

        if ($user_id) {
            $query->where('user_id', $user_id);
        }

        $orders = $query->get();

        $modifiedOrders = $orders->map(function ($order) {
            $products = $order->orderProductSizes->map(function ($orderProductSize) {
                return $orderProductSize->productSizes->products;
            });

            return $order->only(['id', 'total', 'address', 'city', 'zip_code', 'phone', 'transaction_id', 'user_id', 'created_at', 'updated_at', 'user'])
                + ['products' => $products];
        });

        return $this->infoResponse(200, '', $modifiedOrders);
    }

    public function getOrders(): JsonResponse {
        return $this->orders();
    }

    public function getOrdersPerUser(): JsonResponse {
        $user = Auth::user();
        return $this->orders($user->id);
    }

}
