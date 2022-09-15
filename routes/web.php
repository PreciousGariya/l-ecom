<?php

use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\SubscriptionController;
use App\Models\Customer;
use App\Models\Order;
use App\Models\PaymentSuccess;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Subscription;
use Modules\ProductModule\Entities\Product;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {


//     return view('welcome');

// });

Route::get('/', [FrontEndController::class, 'index'])->name('homepage');

Route::get('session_cart', [FrontEndController::class, 'session_cart'])->name('session_cart');

Route::get('cart', [FrontEndController::class, 'cart'])->name('cart');
Route::get('payment', [FrontEndController::class, 'payment'])->name('payment');
Route::post('customer/details', [FrontEndController::class, 'customer_details'])->name('customer_details');

Route::post('addmoney/stripe', [FrontEndController::class, 'postPaymentStripe'])->name('addmoney.stripe');

Route::get('cart/checkout', [FrontEndController::class, 'checkout'])->name('checkout');


Route::get('add-to-cart/{id}', [FrontEndController::class, 'addToCart'])->name('add.to.cart');
Route::patch('update-cart', [FrontEndController::class, 'update_cart'])->name('update.cart');
Route::delete('remove-from-cart', [FrontEndController::class, 'remove'])->name('remove.from.cart');

Route::get('/subscription/create', [SubscriptionController::class, 'index'])->name('subscription.create');
Route::post('order-post', [SubscriptionController::class, 'orderPost'])->name('subscription.post');

Route::group(['middleware' => ['role:admin', 'auth']], function () {
    //
    Route::get('/subscription/create/New', [SubscriptionController::class, 'create'])->name('subscription.create.new');

    // print_r(auth()->user()); die;
    Route::get('/admin-dashboard', function () {
        return view('backend.dashboard');
    })->name('admin-dashboard');
});


Route::group(['middleware' => ['role:customer', 'auth']], function () {
    //
    // print_r(auth()->user()); die;
    Route::get('/customer/buy/as/subscription/{id}', [SubscriptionController::class, 'buyOnSubscription'])->name('buy_as_subscription');

    Route::get('/user-dashboard', function () {

        $user = User::find(Auth::user()->id);
        $paymentMethod = $user->defaultPaymentMethod();
        $paymentMethods = $user->paymentMethods();
        // $user->newSubscription('default', '2000')->create($paymentMethod->id, [
        //     'email' => $user->email,
        // ], [
        //     'metadata' => ['note' => 'Some extra information.'],
        // ]);

        $my_orders = Order::where('customer_id', Auth::user()->id)->get();
        $address = Customer::where('email', Auth::user()->email)->get();
        $payment_details = PaymentSuccess::where('customer_id', AUth::user()->id)->get();
        $subscriptions = DB::table('subscriptions')->where('user_id', Auth::user()->id)->get();
        return view('dashboard', compact('my_orders', 'address', 'payment_details', 'subscriptions'));
    })->name('user-dashboard');


    Route::get('/customer/view/order/details/{id}', function ($id) {
        $singal_order = Order::where('id', $id)->first();
        return view('fullorder', compact('singal_order'));
    })->name('view_order_details');



//     Route::get('/customer/buy/as/subscription/{id}', function ($id) {
//         // $product = Product::findOrFail($id);
//         // $user = User::find(Auth::user()->id);
//         // if (is_null($user->stripe_id)) {
//         //     $stripeCustomer = $user->createAsStripeCustomer();
//         // }
//         // // $paymentMethods = $user->paymentMethods();

//         // // if ($user->hasDefaultPaymentMethod()) {
//         // //     //
//         // //     $paymentMethod = $user->defaultPaymentMethod();
//         // //     $attachedPyment = $stripe->paymentMethods->attach(
//         // //         $paymentMethod->id,
//         // //         ['customer' => $user->stripe_id]
//         // //     );
//         // //     $makeSubscription = $stripe->subscriptions->create([
//         // //         'customer' => $user->stripe_id,
//         // //         'default_payment_method' => $attachedPyment->id,
//         // //         'items' => [
//         // //             ['price' => 'plan_MNmWzFjp4TRoZT'],
//         // //         ],
//         // //     ]);
//         // // }
//         // print_r($product);
//         // $singal_order = Order::where('id', $id)->first();

//         // return view('fullorder', compact('singal_order'));
//     })->name('');
});







// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
