<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\ProductModule\Entities\Category;
use Modules\ProductModule\Entities\Product;

use App\Http\Requests;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Console\Input\Input;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Stripe\Error\Card;
use Stripe;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Cards;
use App\Models\Order;
use App\Models\PaymentSuccess;
use App\Models\ShopingCart;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe as StripeStripe;

class FrontEndController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $products = Product::with('category')->paginate(12);

        $latest = Product::with('category')->latest()->take(6)->get();
        $categories = Category::all();

        return view('welcome', compact('products', 'categories', 'latest'));
    }

    public function session_cart()
    {

        $cart = session()->get('cart');
        // dd($cart);
        if (Auth::check()) {
            if (session()->has('cart')) {

                foreach ($cart as $key => $CartValue) {
                    $check_cart = ShopingCart::where(['customer_id' => Auth::user()->id, 'product_id' => $CartValue['product_id']])->first();
                    if ($check_cart) {
                        $update_cart = ShopingCart::where('customer_id', '=', Auth::user()->id)
                            ->where('product_id', $CartValue['product_id'])
                            ->update(['quantity' => $check_cart->quantity + 1]);
                    } else {
                        ShopingCart::create([
                            'customer_id' => Auth::user()->id,
                            'product_name' => $CartValue['product_name'],
                            'product_id' => $CartValue['product_id'],
                            'slug' => $CartValue['slug'],
                            'quantity' => $CartValue['quantity'],
                            'price' => $CartValue['price'],
                            'image' => $CartValue['image']

                        ]);
                    }
                }
            }
            Session::forget('cart');
            $cart = ShopingCart::where('customer_id', '=', Auth::user()->id)->get();
            $total_pro = count($cart);
            $total = 0;
            foreach ($cart as $key => $value) {
                $total += $value['price'] * $value['quantity'];
            }
            // return view('checkout', compact('cart', 'total_pro', 'total'));
        } else {
            $cart = session()->get('cart');
            if ($cart) {
                $total_pro = count($cart);
                $total = 0;
                foreach ($cart as $key => $value) {
                    $total += $value['price'] * $value['quantity'];
                }
                // return view('checkout', compact('cart', 'total_pro', 'total'));
            }
        }


        return response()->json(['success' => 'Cart Fetch successfully!', 'data' => $cart, 'total' => $total, 'total_pro' => $total_pro]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function cart()

    {
        if (Auth::check()) {
            $cart = ShopingCart::where('customer_id', '=', Auth::user()->id)->get();
            $total_pro = count($cart);
            $total = 0;
            foreach ($cart as $key => $value) {
                $total += $value->price * $value->quantity;
            }
            return view('cart', compact('cart', 'total', 'total_pro'));
            // return response()->json(['data' => $cart, 'total' => $total, 'total_pro' => $total_pro]);
        } else {
            return view('cart');
        }
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        if (Auth::check()) {

            $check_cart = ShopingCart::where(['customer_id' => Auth::user()->id, 'product_id' => $id])->first();
            if ($check_cart) {
                $update_cart = ShopingCart::where('customer_id', '=', Auth::user()->id)
                    ->where('product_id', $id)
                    ->update(['quantity' => $check_cart->quantity + 1]);
            } else {
                $data = [
                    "customer_id" => Auth::user()->id,
                    "product_id" => $product->id,
                    "product_name" => $product->title,
                    "slug" => $product->slug,
                    "quantity" => 1,
                    "price" => $product->price,
                    "image" => $product->image
                ];
                ShopingCart::create($data);
            }
            $cart = ShopingCart::where('customer_id', '=', Auth::user()->id)->get();
            $total_pro = count($cart);
            $total = 0;
            foreach ($cart as $key => $value) {
                $total += $value->price * $value->quantity;
            }
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
            } else {
                $cart[$id] = [
                    "product_id" => $product->id,
                    "product_name" => $product->title,
                    "slug" => $product->slug,
                    "quantity" => 1,
                    "price" => $product->price,
                    "image" => $product->image
                ];
            }
            session()->put('cart', $cart);
            $total = 0;
            $total_pro = count($cart);
            foreach ($cart as $key => $value) {
                $total += $value['price'] * $value['quantity'];
            }
        }

        return response()->json(['success' => 'Product added to cart successfully!', 'data' => $cart, 'total' => $total, 'total_pro' => $total_pro]);
    }

    public function update_cart(Request $request)
    {
        if ($request->id && $request->quantity) {
            if (Auth::check()) {
                $update_cart = ShopingCart::where('customer_id', '=', Auth::user()->id)
                    ->where('product_id', $request->id)
                    ->update(['quantity' => $request->quantity]);
                $cart = ShopingCart::where('customer_id', '=', Auth::user()->id)->get();
                $total_pro = count($cart);
                $total = 0;
                foreach ($cart as $key => $value) {
                    // $total += $value['price'] * $value['quantity'];
                    $total += $value->price * $value->quantity;
                }
            } else {
                $cart = session()->get('cart');
                $cart[$request->id]["quantity"] = $request->quantity;
                session()->put('cart', $cart);

                $total = 0;
                $total_pro = count($cart);
                foreach ($cart as $key => $value) {

                    $total += $value['price'] * $value['quantity'];
                }
            }
            return response()->json(['success' => 'Cart Updated Succcessfully', 'data' => $cart, 'total' => $total, 'total_pro' => $total_pro]);
            // session()->flash('success', 'Cart updated successfully');
        }
    }
    public function remove(Request $request)
    {
        if ($request->id) {
            if (Auth::check()) {
                $result = ShopingCart::where(['product_id' => $request->id, 'customer_id' => Auth::user()->id])->delete();
                $cart = ShopingCart::where('customer_id', '=', Auth::user()->id)->get();
                $total_pro = count($cart);
                $total = 0;
                foreach ($cart as $key => $value) {
                    // $total += $value['price'] * $value['quantity'];
                    $total += $value->price * $value->quantity;
                }
            } else {
                $cart = session()->get('cart');
                if (isset($cart[$request->id])) {
                    unset($cart[$request->id]);
                    session()->put('cart', $cart);
                }
            }

            return response()->json(['success' => 'Product Removed Sucessfully', 'data' => $cart, 'total' => $total, 'total_pro' => $total_pro]);
        }
    }


    // Checkout
    public function checkout()
    {

        $cart = session()->get('cart');
        // dd(Auth::user()->name);
        if (Auth::check()) {
            if (session()->has('cart')) {

                foreach ($cart as $key => $CartValue) {
                    $check_cart = ShopingCart::where(['customer_id' => Auth::user()->id, 'product_id' => $CartValue['product_id']])->first();
                    if ($check_cart) {
                        $update_cart = ShopingCart::where('customer_id', '=', Auth::user()->id)
                            ->where('product_id', $CartValue['product_id'])
                            ->update(['quantity' => $check_cart->quantity + 1]);
                    } else {
                        ShopingCart::create([
                            'customer_id' => Auth::user()->id,
                            'product_name' => $CartValue['product_name'],
                            'product_id' => $CartValue['product_id'],
                            'slug' => $CartValue['slug'],
                            'quantity' => $CartValue['quantity'],
                            'price' => $CartValue['price'],
                            'image' => $CartValue['image']

                        ]);
                    }
                }
            }
            Session::forget('cart');
            $cart = ShopingCart::where('customer_id', '=', Auth::user()->id)->get();
            $total_pro = count($cart);
            $total = 0;
            foreach ($cart as $key => $value) {
                $total += $value['price'] * $value['quantity'];
            }
            return view('checkout', compact('cart', 'total_pro', 'total'));
        } else {
            $cart = session()->get('cart');
            if ($cart) {
                $total_pro = count($cart);
                $total = 0;
                foreach ($cart as $key => $value) {
                    $total += $value['price'] * $value['quantity'];
                }
                return view('checkout', compact('cart', 'total_pro', 'total'));
            }
        }
    }


    public function payment()
    {
        if (Auth::check()) {
            $cart = ShopingCart::where('customer_id', '=', Auth::user()->id)->get();
            $total_pro = count($cart);
            $total = 0;
            foreach ($cart as $key => $value) {
                $total += $value['price'] * $value['quantity'];
            }
            return view('payment', compact('cart', 'total_pro', 'total'));
        } else {
            $cart = session()->get('cart');
            $total_pro = count($cart);
            $total = 0;
            foreach ($cart as $key => $value) {

                $total += $value['price'] * $value['quantity'];
            }
            return view('payment', compact('cart', 'total_pro', 'total'));
        }
    }

    public function customer_details(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'billing_address' => 'required',
            'billing_address2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zipcode' => 'required',
            'phone' => 'required',
            'email' => 'required_if:checkbox,on',

        ]);
        $request->except('_token');
        $input = $request->all();

        // dd($input);
        Customer::create($input);
        if ($request->checkbox == 'on') {
            $checkEmail=User::where('email',$request->email)->first();
            if(!$checkEmail){
                $user_acc = [
                    'name' => $request->fname . " " . $request->lname,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ];
                $acc = User::create($user_acc);
                $acc->assignRole('customer');
            }

            if ($acc) {
                $credentials = $request->validate([
                    'email' => ['required', 'email'],
                    'password' => ['required'],
                ]);

                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();
                }
            }
        }
        return redirect()->back();
        //  dd('creted');

    }
    public function postPaymentStripe(Request $request)
    {
        if($request->total_value<=0){
            Session::flash('error', 'Problem Deducted in Total Amount');
            return back();
        }

        // dd($request->all());
        $card_details=[
            'customer_id'=>Auth::user()->id,
            'name_nCard'=>$request->name_nCard,
            'card_number'=>$request->card_number,
            'cvv'=>$request->cvv,
            'expiry_month'=>$request->expiry_month,
            'expiry_year'=>$request->exp_year
        ];
        $order_details = [];
        for ($i = 0; $i < count($request->pro_name); $i++) {
            // echo $i;
            $order_details[$i] = [
                'customer_id' => Auth::user()->id,
                'product_name' => $request->pro_name[$i],
                'product_id' => $request->pro_id[$i],
                'slug' => $request->pro_slug[$i],
                'quantity' => $request->pr_qty[$i],
                'price' => $request->price[$i],
                'image' => $request->image[$i],

            ];
        }
        $create_order = [
            'customer_id' => Auth::user()->id,
            'order_details' => json_encode($order_details),
            'total_value' => $request->total_value,
            'o_status' => 'pending'
        ];
        // dd($create_order);
        $init_order = Order::create($create_order);

        $customer_address = DB::table('customers')->where('email', Auth::user()->email)->first();
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        // payment method create
        $pay_method = $stripe->paymentMethods->create([
            'type' => 'card',
            'card' => [
                'number' => $request->card_number,
                'exp_month' => $request->expiry_month,
                'exp_year' => $request->exp_year,
                'cvc' => $request->cvv,
            ],
        ]);
        // create customer to gateway
        $create_stripe_customer = \Stripe\Customer::create(
            [
                "email" => $customer_address->email,
                "name" => $customer_address->fname . " " . $customer_address->lname,
                "phone" => $customer_address->phone,
                'address' => [
                    'line1' => $customer_address->billing_address,
                    'line2' => $customer_address->billing_address2,
                    'city' => $customer_address->city,
                    'state' => $customer_address->state,
                    'country' => 'IND',
                    'postal_code' => $customer_address->zipcode
                ],
                'payment_method' => $pay_method['id'],
                "metadata" => [
                    'order_id' => $init_order->id,
                ]
            ],
        );
        // create payment Intent
        $payment = \Stripe\PaymentIntent::create([
            "amount" => 100 * $request->total_value,
            "currency" => "usd",
            "customer" => $create_stripe_customer->id,
            "receipt_email" => 'gokul.hestabit@gmail.com',
            "description" => "This payment is tested purpose phpcodingstuff.com",
        ]);
        // confirm the payment with the intent id
        $confirm_payment = $stripe->paymentIntents->confirm(
            $payment->id,
            ['payment_method' => 'pm_card_visa']
        );

        // echo "<pre>";
        // print_r($confirm_payment);

        // die;
        // $payment->
        // Check the status and store required details for further reference
        if ($confirm_payment->status == "succeeded") {
            $amount_received = $confirm_payment->amount_received;
            $currency = $confirm_payment->currency;
            $Stripe_customer = $confirm_payment->customer;
            $description = $confirm_payment->description;
            $status = $confirm_payment->status;
            //
            $receipt_url = $confirm_payment->charges['data'][0]['receipt_url'];
            $charge_id = $confirm_payment->charges['data'][0]['id'];
            $amount_captured = $confirm_payment->charges['data'][0]['amount_captured'];
            $captured_status = $confirm_payment->charges['data'][0]['captured'];
            $paid = $confirm_payment->charges['data'][0]['paid'];
            $payment_intent = $confirm_payment->charges['data'][0]['payment_intent'];
            $payment_method = $confirm_payment->charges['data'][0]['payment_method'];
            $payment_method_details = $confirm_payment->charges['data'][0]['payment_method_details'];
            //
            // Store
            $payment_details_store = PaymentSuccess::create([
                'customer_id' => Auth::user()->id,
                'order_id' => $init_order->id,
                'amount_received' => $amount_received/100,
                'currency' => $currency,
                'Stripe_customer' => $Stripe_customer,
                'description' => $description,
                'amount_captured' => $amount_captured,
                'charge_id' => $charge_id,
                'payment_intent' => $payment_intent,
                'payment_method' => $payment_method,
                'paid_status' => $paid,
                'captured_status' => $captured_status,
                'receipt_url' => $receipt_url,
                'payment_method_details' => $payment_method_details,
                'payment_status' => $status,
            ]);
            // change the current order status pending=>success
            $init_order->where('id',$init_order->id)->update(['o_status'=>'paid']);

            // empty the cart
            ShopingCart::where('customer_id',Auth::user()->id)->delete();
        }

        Session::flash('success', 'Payment successful!');

        return back();
    }

    public function subscriptionCreate(){
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        // Stripe\Stripe::setApiKey();
        $chargeCreate=$stripe->charges->create([
            "amount" => 2000,
            "currency" => "usd",
            "source" => "tok_mastercard", // obtained with Stripe.js
            "metadata" => ["order_id" => "6735"]
          ]);
          echo "<pre>";
          print_r($chargeCreate);
          die;
        $ch = $stripe->charges->capture(
            $chargeCreate->id,
            // [],
            // ['api_key' => 'sk_test_4eC39HqLyjWDarjtT1zdp7dc']
          );
          echo "<pre>";
          print_r($ch);

    }
}
