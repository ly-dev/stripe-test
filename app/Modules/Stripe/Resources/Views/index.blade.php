@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center mt-5">
        <div class="col-sm-10">

            <h1>Stripe Tests</h1>
            <ul>
                @foreach ([
                    'Elements' => route('stripe.elements'),
                    '3D Secure 2' => route('stripe.3d-secure-2'),
                    'Connect Acount' => route('stripe.connect.accouunt'),
                    'Payment Intent' => route('stripe.payment.intent'),
                ] as $label => $link )
                <li><a href="{{ $link }}">{{ $label }}</a></li>
                @endforeach
            </ul>

        </div>
    </div>
</div>
@endsection

@push('component-styles')

@endpush

@push('component-scripts')

@endpush
