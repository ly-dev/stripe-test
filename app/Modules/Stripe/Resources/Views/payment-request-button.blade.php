@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row d-flex justify-content-center mt-5">
        <div class="col-sm-10">
            <h1>Payment Request Button</h1>

            <div>
                <label for="payment-request-button" style="display:block">
                    Payment Request Button
                </label>
                <div id="payment-request-button">
                    <!-- A Stripe Element will be inserted here. -->
                </div>

                <!-- Used to display form errors. -->
                <div id="card-errors" role="alert"></div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('component-styles')

@endpush

@push('component-scripts')
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        // Create a Stripe client.
        var stripe = Stripe('{{ config("stripe.publishable_key") }}');

        var paymentRequest = stripe.paymentRequest({
            country: 'GB',
            currency: 'gbp',
            total: {
                label: 'test total',
                amount: 100,
            },
            requestPayerName: true,
            requestPayerEmail: true,
            // requestPayerPhone: true,
            // requestShipping: true,
        });

        // Create an instance of Elements.
        var elements = stripe.elements();
        var prButton = elements.create('paymentRequestButton', {
            paymentRequest: paymentRequest,
            style: {
                paymentRequestButton: {
                    type: 'donate', // default: 'default', 'default' | 'donate' | 'buy'
                    theme: 'light-outline', // default: 'dark', dark' | 'light' | 'light-outline', // default: 'dark'
                    height: '64px', // default: '40px', the width is always '100%'
                }
            }
        });

        // Check the availability of the Payment Request API first.
        paymentRequest.canMakePayment().then(function(result) {
            // console.error(result);
            if (result) {
                prButton.mount('#payment-request-button');
            } else {
                document.getElementById('payment-request-button').style.display = 'none';
                alert('not support');
            }
        });

        paymentRequest.on('paymentmethod', function(ev) {
            ev.complete('fail');
            alert(ev.paymentMethod.id);
            stripe.confirmPaymentIntent(clientSecret, {
                payment_method: ev.paymentMethod.id,
            }).then(function(confirmResult) {
                if (confirmResult.error) {
                    // Report to the browser that the payment failed, prompting it to
                    // re-show the payment interface, or show an error message and close
                    // the payment interface.
                    ev.complete('fail');
                } else {
                    // Report to the browser that the confirmation was successful, prompting
                    // it to close the browser payment method collection interface.
                    ev.complete('success');

                    // Let Stripe.js handle the rest of the payment flow.
                    stripe.handleCardPayment(clientSecret).then(function(result) {
                        if (result.error) {
                        // The payment failed -- ask your customer for a new payment method.
                        } else {
                        // The payment has succeeded.
                        }
                    });
                }
            });
});        

    });
</script>
@endpush