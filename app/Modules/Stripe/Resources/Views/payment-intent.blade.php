@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row d-flex justify-content-center mt-5">
        <div class="col-sm-10">
            <h1>Payment Intent</h1>

            <label for="cardholder-name" style="display:block">
                Credit or debit card
            </label>
            <input id="cardholder-name" type="text" placeholder="Cardholder Name">

            <div id="card-element" style="width: auto">
                <!-- A Stripe Element will be inserted here. -->
            </div>

            <!-- Used to display form errors. -->
            <div id="card-errors" role="alert"></div>

            <button id="card-button" data-secret="{{ $intent->client_secret }}">
                Submit Payment
            </button>
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
        var stripe = Stripe('{{ env("STRIPE_PUBLISHABLE_KEY") }}');

        // Create an instance of Elements.
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
            base: {
                fontSize: '16px',
                color: "#32325d",
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        // Create an instance of the card Element.
        var cardElement = elements.create('card', {
            style: style
        });

        // Add an instance of the card Element into the `card-element` <div>.
        cardElement.mount('#card-element');

        // Handle real-time validation errors from the card Element.
        cardElement.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var cardholderName = document.getElementById('cardholder-name');
        var cardButton = document.getElementById('card-button');
        var clientSecret = cardButton.dataset.secret;

        cardButton.addEventListener('click', function(ev) {
            stripe.handleCardPayment(
                clientSecret, cardElement, {
                    payment_method_data: {
                        billing_details: {name: cardholderName.value}
                    }
                }
            ).then(function(result) {
                if (result.error) {
                    console.error(result.error);
                } else {
                    console.log('success');
                }
            });
        });
    });
</script>
@endpush