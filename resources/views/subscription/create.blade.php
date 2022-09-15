@extends('layouts.app')
@section('content')
    <section class="mt-50 mb-50">
        <div class="container">
            <div class="col-md-12">
                {{-- {!! Form::open(['url' => route('subscription.post'), 'data-parsley-validate', 'id' => 'payment-form']) !!} --}}
                <form role="form" action="{{ route('subscription.post') }}" method="post" class="require-validation"
                    data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    @csrf
                    <div class="form-group" id="product-group">
                        <?php
$user=Auth::user();
$paymentMethods = $user->paymentMethods();

dd($paymentMethods);
?>
                        {!! Form::label('plane', 'Select Plan:') !!}
                        {!! Form::select(
                            'plane',
                            ['laravel' => 'Laravel ($10)', 'vue' => 'Vue ($20)', 'react' => 'React ($15)'],
                            'Book',
                            [
                                'class' => 'form-control',
                                'required' => 'required',
                                'data-parsley-class-handler' => '#product-group',
                            ],
                        ) !!}
                        {{-- <select name="plan" id="" class="form-control">
                            <option value="">---Select Plan---</option>
                            <?php
                        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                        $plans=$stripe->plans->all(['limit' => 3]);
                       foreach ($plans as $key => $plan) {
                            $productName=$stripe->products->retrieve($plan->product,[]);
                           ?>
                        <option value="{{ $plan->id }}">{{$productName->name}} | {{ $plan->amount }}</option>
                        <?php } ?>
                        </select> --}}

                    </div>
                    <div class='form-row row'>
                        <div class='col-xs-12 form-group required'>
                            <label class='control-label'>Name on Card</label> <input class='form-control' size='4'
                                name="name_nCard" type='text' value="Gokul">
                        </div>
                        <div class='col-xs-12 form-group required'>
                            <div class="card"></div>
                            <label class='control-label'>Card Number</label>
                            <input autocomplete='off' class='form-control card-number' size='20' type='text'
                                name="card_number" value="4242424242424242">
                        </div>
                        <div class='col-xs-12 col-md-4 form-group cvc required'>
                            <label class='control-label'>CVC</label> <input autocomplete='off' class='form-control card-cvc'
                                placeholder='ex. 311' size='4' type='text' name="cvv" value="123">
                        </div>
                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                            <label class='control-label'>Expiration Month</label> <input
                                class='form-control card-expiry-month' placeholder='MM' size='2' type='text'
                                name="expiry_month" value="12">
                        </div>
                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                            <label class='control-label'>Expiration Year</label> <input
                                class='form-control card-expiry-year' name="exp_year" placeholder='YYYY' size='4'
                                type='text' value="2045">
                        </div>
                        <div class='col-md-12 error form-group hide'>
                            <div class='alert-danger alert'>Please correct the errors and try
                                again.
                            </div>

                        </div>
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
            </div>
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
