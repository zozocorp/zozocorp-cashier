<html lang="en">
    <head>
        <title>{{ trans('cashier::messages.razorpay.checkout.page_title') }}</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <link rel="stylesheet" href="{{ \Worker\Cashier\Cashier::public_url('/vendor/ema-cashier/css/main.css') }}">
    </head>
    
    <body>
        <div class="main-container row mt-40">
            <div class="col-md-2"></div>
            <div class="col-md-4 mt-40 pd-60">
                <label class="text-semibold text-muted mb-20 mt-0">
                    <strong>
                        {{ trans('cashier::messages.razorpay.checkout_with_razorpay') }}
                    </strong>
                </label>
                <img class="rounded" width="100%" src="{{ \Worker\Cashier\Cashier::public_url('/vendor/ema-cashier/image/razorpay.png') }}" />
            </div>
            <div class="col-md-4 mt-40 pd-60">                
                <label>{{ $subscription->plan->getBillableName() }}</label>  
                <h2 class="mb-40">{{ $subscription->plan->getBillableFormattedPrice() }}</h2>
                <p>{!! trans('cashier::messages.razorpay.checkout.intro', [
                    'plan' => $subscription->plan->getBillableName(),
                    'price' => $subscription->plan->getBillableFormattedPrice(),
                ]) !!}</p>

                <ul class="dotted-list topborder section mb-4">
                    <li>
                        <div class="unit size1of2">
                            {{ trans('cashier::messages.razorpay.plan') }}
                        </div>
                        <div class="lastUnit size1of2">
                            <mc:flag>{{ $subscription->plan->getBillableName() }}</mc:flag>
                        </div>
                    </li>
                    <li>
                        <div class="unit size1of2">
                            {{ trans('cashier::messages.razorpay.next_period_day') }}
                        </div>
                        <div class="lastUnit size1of2">
                            <mc:flag>{{ $subscription->current_period_ends_at }}</mc:flag>
                        </div>
                    </li>
                    <li>
                        <div class="unit size1of2">
                            {{ trans('cashier::messages.razorpay.amount') }}
                        </div>
                        <div class="lastUnit size1of2">
                            <mc:flag>{{ $subscription->plan->getBillableFormattedPrice() }}</mc:flag>
                        </div>
                    </li>
                </ul>

                <a href="javascript:;" class="btn btn-secondary" onclick="$('.razorpay-payment-button').click()">
                    {{ trans('cashier::messages.razorpay.pay_with_razorpay') }}
                </a>
                
                <div class="hide" style="display:none">
                    <form action="{{ \Worker\Cashier\Cashier::lr_action('\Worker\Cashier\Controllers\RazorpayController@checkout', [
                    '_token' => csrf_token(),
                    'subscription_id' => $subscription->uid,
                ]) }}" method="POST">

                        <script
                            src="https://checkout.razorpay.com/v1/checkout.js"
                            data-key="{{ $service->key_id }}" // Enter the Test API Key ID generated from Dashboard → Settings → API Keys
                            data-amount="{{ $service->convertPrice($subscription->plan->getBillableAmount(), $subscription->plan->getBillableCurrency()) }}" // Amount is in currency subunits. Hence, 29935 refers to 29935 paise or ₹299.35.
                            data-currency="{{ $subscription->plan->getBillableCurrency() }}" //You can accept international payments by changing the currency code. Contact our Support Team to enable International for your account
                            data-order_id="{{ $order["id"] }}" //Replace with the order_id generated by you in the backend.
                            data-buttontext="{{ trans('cashier::messages.razorpay.pay_with_razorpay') }}"
                            data-name="{{ $subscription->plan->getBillableName() }}"
                            data-description="{{ $subscription->plan->description }}"
                            data-image="{{ \Worker\Model\Setting::get('site_logo_small') ? \Worker\Cashier\Cashier::lr_action('SettingController@file', \Worker\Model\Setting::get('site_logo_small')) : URL::asset('images/default_site_logo_small_' . (Auth::user()->customer->getColorScheme() == "white" ? "dark" : "light") . '.png') }}"
                            data-prefill.email="{{ $subscription->user->getBillableEmail() }}"
                            data-theme.color="#F37254"
                            data-customer_id="{{ $customer["id"] }}"
                            data-save="1"
                        ></script>
                        <input type="hidden" custom="Hidden Element" name="hidden">
                    </form>
                </div>

            </div>
            <div class="col-md-2"></div>
        </div>
        <br />
        <br />
        <br />
    </body>
</html>