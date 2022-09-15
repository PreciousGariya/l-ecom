@extends('layouts.app')

@section('content')

<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.html" rel="nofollow">Home</a>
            <span></span> Shop
            <span></span> Checkout
        </div>
    </div>
</div>
<section class="mt-50 mb-50">
    <div class="container">
        <div class="row">

            <div class="col-lg-6">
                <div class="toggle_info">
                    <span><i class="fi-rs-label mr-10"></i><span class="text-muted">Have a coupon?</span> <a
                            href="#coupon" data-bs-toggle="collapse" class="collapsed" aria-expanded="false">Click here
                            to enter your code</a></span>
                </div>
                <div class="panel-collapse collapse coupon_form " id="coupon">
                    <div class="panel-body">
                        <p class="mb-30 font-sm">If you have a coupon code, please apply it below.</p>
                        <form method="post">
                            <div class="form-group">
                                <input type="text" placeholder="Enter Coupon Code...">
                            </div>
                            <div class="form-group">
                                <button class="btn  btn-md" name="login">Apply Coupon</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="divider mt-50 mb-50"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="order_review">
                    <div class="mb-20">
                        <h4>Your Orders</h4>
                    </div>
                    <div class="table-responsive order_table text-center">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="2">Product</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0 @endphp

                                @foreach ((array) session('cart') as $id => $details)
                                    @php $total += $details['price'] * $details['quantity'] @endphp
                                @endforeach
                                @if (session('cart'))
                                    @foreach (session('cart') as $id => $details)
                                        <tr>
                                            <td class="image product-thumbnail"><img src="/{{ $details['image'] }}"
                                                    alt="#"></td>
                                            <td>
                                                <h5><a
                                                        href="{{ route('products.view', $details['slug']) }}">{{ $details['product_name'] }}</a>
                                                </h5> <span class="product-qty">x 2</span>
                                            </td>
                                            <td>{{ env('CURRENCY') }} {{ $details['price'] }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                <tr>
                                    <th>SubTotal</th>
                                    <td class="product-subtotal" colspan="2">{{ env('CURRENCY') }}
                                        {{ $total }}</td>
                                </tr>
                                <tr>
                                    <th>Shipping</th>
                                    <td colspan="2"><em>Free Shipping</em></td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td colspan="2" class="product-subtotal"><span
                                            class="font-xl text-brand fw-900">{{ env('CURRENCY') }}
                                            {{ $total }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                    <div class="payment_method">
                        <div class="mb-25">
                            <h5>Payment</h5>
                        </div>
                        <div class="payment_option">
                            <div class="custome-radio">
                                <input class="form-check-input" required="" type="radio" name="payment_option"
                                    id="exampleRadios3" checked="">
                                <label class="form-check-label" for="exampleRadios3" data-bs-toggle="collapse"
                                    data-target="#bankTranfer" aria-controls="bankTranfer">Direct Bank
                                    Transfer</label>
                                <div class="form-group collapse in" id="bankTranfer">
                                    <p class="text-muted mt-5">There are many variations of passages of Lorem Ipsum
                                        available, but the majority have suffered alteration. </p>
                                </div>
                            </div>
                            <div class="custome-radio">
                                <input class="form-check-input" required="" type="radio" name="payment_option"
                                    id="exampleRadios4" checked="">
                                <label class="form-check-label" for="exampleRadios4" data-bs-toggle="collapse"
                                    data-target="#checkPayment" aria-controls="checkPayment">Check Payment</label>
                                <div class="form-group collapse in" id="checkPayment">
                                    <p class="text-muted mt-5">Please send your cheque to Store Name, Store Street,
                                        Store Town, Store State / County, Store Postcode. </p>
                                </div>
                            </div>
                            <div class="custome-radio">
                                <input class="form-check-input" required="" type="radio" name="payment_option"
                                    id="exampleRadios5" checked="">
                                <label class="form-check-label" for="exampleRadios5" data-bs-toggle="collapse"
                                    data-target="#paypal" aria-controls="paypal">Paypal</label>
                                <div class="form-group collapse in" id="paypal">
                                    <p class="text-muted mt-5">Pay via PayPal; you can pay with your credit card if you
                                        don't have a PayPal account.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('addmoney.stripe') }}" class="btn btn-fill-out btn-block mt-30">Place Order</a>
                </div>
            </div>
        </div>
    </div>
</section>


    <style>
        .my-input {
            padding: 10px;
            border: 1px solid #ccc;
        }
    </style>

    <div class="container">
        <form
                        role="form"
                        action="{{ route('addmoney.stripe') }}"
                        method="post"
                        class="require-validation"
                        data-cc-on-file="false"
                        data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                        id="payment-form">
                        @csrf
                        <div class='form-row row'>
                           <div class='col-xs-12 form-group required'>
                              <label class='control-label'>Name on Card</label> <input
                                 class='form-control' size='4' type='text'>
                           </div>
                        </div>
                        <div class='form-row row'>
                           <div class='col-xs-12 form-group card required'>
                              <label class='control-label'>Card Number</label> <input
                                 autocomplete='off' class='form-control card-number' size='20'
                                 type='text'>
                           </div>
                        </div>
                        <div class='form-row row'>
                           <div class='col-xs-12 col-md-4 form-group cvc required'>
                              <label class='control-label'>CVC</label> <input autocomplete='off'
                                 class='form-control card-cvc' placeholder='ex. 311' size='4'
                                 type='text'>
                           </div>
                           <div class='col-xs-12 col-md-4 form-group expiration required'>
                              <label class='control-label'>Expiration Month</label> <input
                                 class='form-control card-expiry-month' placeholder='MM' size='2'
                                 type='text'>
                           </div>
                           <div class='col-xs-12 col-md-4 form-group expiration required'>
                              <label class='control-label'>Expiration Year</label> <input
                                 class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                 type='text'>
                           </div>
                        </div>
                        <div class='form-row row'>
                           <div class='col-md-12 error form-group hide'>
                              <div class='alert-danger alert'>Please correct the errors and try
                                 again.
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-xs-12">
                              <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now ($100)</button>
                           </div>
                        </div>
                     </form>

    </div>
@endsection
@section('after-script')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
        $(function() {
      var $form = $(".require-validation");
      $('form.require-validation').bind('submit', function(e) {
          var $form = $(".require-validation"),
              inputSelector = ['input[type=email]', 'input[type=password]',
                  'input[type=text]', 'input[type=file]',
                  'textarea'
              ].join(', '),
              $inputs = $form.find('.required').find(inputSelector),
              $errorMessage = $form.find('div.error'),
              valid = true;
          $errorMessage.addClass('hide');
          $('.has-error').removeClass('has-error');
          $inputs.each(function(i, el) {
              var $input = $(el);
              if ($input.val() === '') {
                  $input.parent().addClass('has-error');
                  $errorMessage.removeClass('hide');
                  e.preventDefault();
              }
          });
          if (!$form.data('cc-on-file')) {
              e.preventDefault();
              Stripe.setPublishableKey($form.data('stripe-publishable-key'));
              Stripe.createToken({
                  number: $('.card-number').val(),
                  cvc: $('.card-cvc').val(),
                  exp_month: $('.card-expiry-month').val(),
                  exp_year: $('.card-expiry-year').val()
              }, stripeResponseHandler);
          }
      });
      function stripeResponseHandler(status, response) {
          if (response.error) {
              $('.error')
                  .removeClass('hide')
                  .find('.alert')
                  .text(response.error.message);
          } else {
              /* token contains id, last4, and card type */
              var token = response['id'];
              $form.find('input[type=text]').empty();
              $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
              $form.get(0).submit();
          }
      }
  });
     </script>
@endsection
