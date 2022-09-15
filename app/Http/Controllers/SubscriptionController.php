<?php

namespace App\Http\Controllers;

use App\Models\Cards;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Models\User;
use Stripe;
use Session;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Cashier\Subscription;
use Modules\ProductModule\Entities\Product;
use Stripe\Issuing\Card;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('subscription.create');
    }

    public function create()
    {
        return view('backend.subscription.create');
        // Creating Plan
        // $create_product = $stripe->products->create([
        //     'name' => 'Gold Special',
        //     'description'=>'This is test plan',

        // ]);
        // $createPlan = $stripe->plans->create([
        //     'amount' => 1200,
        //     'currency' => 'usd',
        //     'interval' => 'month',
        //     'product' => $create_product->id,
        // ]);

        // $StorePlan = Plan::create([
        //     'name' =>  $createPlan->product,
        //     'slug'=>Hash::make('Gold Special'),
        //     'stripe_plan'=> $createPlan->id,
        //     'cost'=> $createPlan->amount,
        //     'description'=> $createPlan->description,
        // ]);
        // $getPlanDetails=$stripe->plans->retrieve(
        //     'plan_MNmWzFjp4TRoZT',
        //     []
        //   );
        //  $planUpdate= $stripe->plans->update(
        //     'plan_MNmWzFjp4TRoZT',
        //     ['metadata' => ['order_id' => '6735']]
        //   );
        // $planDelete=$stripe->plans->delete(
        //     'plan_MNmWzFjp4TRoZT',
        //     []
        //   );
    }
    public function StoreProduct(Request $request)
    {
    }
    public function orderPost(Request $request)
    {

        // dd($request->all());
        $user = auth()->user();
        $input = $request->all();
        $token =  $request->stripeToken;
        $paymentMethod = $request->paymentMethod;


        try {

            // Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));



            // list all plans
            // $stripe->plans->all(['limit' => 3]);
            // getting cuttomers
            if (is_null($user->stripe_id)) {
                $stripeCustomer = $user->createAsStripeCustomer();
            }

            $paymentMethods = $user->paymentMethods();

            if ($user->hasDefaultPaymentMethod()) {
                //
                $paymentMethod = $user->defaultPaymentMethod();
                $attachedPyment = $stripe->paymentMethods->attach(
                    $paymentMethod->id,
                    ['customer' => $user->stripe_id]
                );
                $makeSubscription = $stripe->subscriptions->create([
                    'customer' => $user->stripe_id,
                    'default_payment_method' => $attachedPyment->id,
                    'items' => [
                        ['price' => 'plan_MNmWzFjp4TRoZT'],
                    ],
                ]);
            } else {
                $cardDetailsFetch = Cards::where('name_nCard', $request->name_nCard)->first();
                if (!$cardDetailsFetch) {
                    $card_details = [
                        'customer_id' => Auth::user()->id,
                        'name_nCard' => $request->name_nCard,
                        'card_number' => $request->card_number,
                        'cvv' => $request->cvv,
                        'expiry_month' => $request->expiry_month,
                        'expiry_year' => $request->exp_year
                    ];
                    $saveCardDetails = Cards::create($card_details);
                }
                $pay_method = $stripe->paymentMethods->create([
                    'type' => 'card',
                    'card' => [
                        'number' => $request->card_number,
                        'exp_month' => $request->expiry_month,
                        'exp_year' => $request->exp_year,
                        'cvc' => $request->cvv,
                    ],
                ]);
                $attachedPyment = $stripe->paymentMethods->attach(
                    $pay_method->id,
                    ['customer' => $user->stripe_id]
                );

                $makeSubscription = $stripe->subscriptions->create([
                    'customer' => $user->stripe_id,
                    'default_payment_method' => $attachedPyment->id,
                    'items' => [
                        ['price' => 'plan_MNmWzFjp4TRoZT'],
                    ],
                ]);
            }
            if ($makeSubscription->status == 'active') {
                $save_subs = [
                    'user_id' => Auth::user()->id,
                    'name'    => Auth::user()->name,
                    'stripe_id'    => Auth::user()->stripe_id,
                    'stripe_plan' => $makeSubscription->plan->id,
                    'quantity'    => $makeSubscription->quantity,
                    'trial_ends_at' => $makeSubscription->trial_end,
                    'ends_at' => $makeSubscription->ended_at,
                ];
                Subscription::create($save_subs);
            }
            //
            // echo "<pre>";
            // print_r($makeSubscription);
            // die;

            return back()->with('success', 'Subscription is completed.');
        } catch (Exception $e) {
            return back()->with('success', $e->getMessage());
        }
    }

    public function buyOnSubscription($id)
    {
        $product = Product::findOrFail($id);
        $user = User::find(Auth::user()->id);
        // dd($product);
        // echo $user->stripe_id;
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        if (is_null($user->stripe_id)) {
            $stripeCustomer = $user->createAsStripeCustomer();
        }

        // check product is available on subscription or not
        if ($product->subscription_product && $product->plan_id) {
            $paymentMethods = $user->paymentMethods()->first();
            //  $paymentMethod = $user->findPaymentMethod($paymentMethods->id);
            //  $paymentMethods->id;
            $paymentMethod = $user->defaultPaymentMethod();
            if ($paymentMethods) {
                // process to subscription
                $makeSubscription = $stripe->subscriptions->create([
                    'customer' => $user->stripe_id,
                    'default_payment_method' => $paymentMethods->id,
                    'items' => [
                        ['price' => $product->plan_id],
                    ],
                ]);

                // echo "<pre>";
                // print_r($makeSubscription);
                // die;
                if ($makeSubscription->status == 'active') {
                    $save_subs = [
                        'user_id' => Auth::user()->id,
                        'name'    => Auth::user()->name,
                        'stripe_id'    => $makeSubscription->plan->id,
                        'stripe_price'=> $makeSubscription->plan->amount,
                        'quantity'    => $makeSubscription->quantity,
                        'stripe_status'=>$makeSubscription->status,
                        'trial_ends_at' => $makeSubscription->trial_end,
                        'ends_at' => $makeSubscription->ended_at,
                    ];
                    Subscription::create($save_subs);
                }
                return redirect()->route('user-dashboard')->with('message', 'Subscription Started Successfully!!');

            //    dd($save_subs);
            }else{
                return back()->with(['message'=>'Payment Method Not Configured!!']);
            }

        } else {
            //  Createproduct
            $create_product = $stripe->products->create([
                'name' => $product->title,
                'description' => $product->short_description,
            ]);

            $createPlan = $stripe->plans->create([
                'amount' => $product->price/2*100,
                'currency' => 'usd',
                'interval' => 'month',
                'product' => $create_product->id,
            ]);

            // StorePlan
            $StorePlan = Plan::create([
                'name' =>  $createPlan->product,
                'slug' => $product->slug,
                'stripe_plan' => $createPlan->id,
                'cost' => $createPlan->amount,
                'description' => $createPlan->description,
            ]);
            $product=Product::where('id', $id)->update(['subscription_product' => $create_product->id, 'plan_id' => $createPlan->id]);

            $paymentMethods = $user->paymentMethods()->first();
            $paymentMethod = $user->defaultPaymentMethod();
            if ($paymentMethods) {
                // process to subscription
                $makeSubscription = $stripe->subscriptions->create([
                    'customer' => $user->stripe_id,
                    'default_payment_method' => $paymentMethods->id,
                    'items' => [
                        ['price' => $createPlan->id],
                    ],
                ]);
                //
                if ($makeSubscription->status == 'active') {
                    $save_subs = [
                        'user_id' => Auth::user()->id,
                        'name'    => Auth::user()->name,
                        'stripe_id'    => $makeSubscription->plan->id,
                        'stripe_price'=> $makeSubscription->plan->amount,
                        'quantity'    => $makeSubscription->quantity,
                        'stripe_status'=>$makeSubscription->status,
                        'trial_ends_at' => $makeSubscription->trial_end,
                        'ends_at' => $makeSubscription->ended_at,
                    ];
                    Subscription::create($save_subs);
                }
                return redirect()->route('user-dashboard')->with('message', 'Subscription Started Successfully!!');
            //    dd($save_subs);
            }else{
                return back()->with(['message'=>'Payment Method Not Configured!!']);
            }
        }
    }
}
