@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">Reset Password</h1>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form id="password-email-form" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        @include ('components.form-input', [
                            'id' => 'email',
                            'label' => 'E-Mail Address',
                            'type' => 'email',
                            'value' => old('email'),
                            'required' => true,
                            'controlAttributes' => 'autofocus'
                        ])

                        @include ('components.form-submit', [
                            'label' => 'Send Password Reset Link',
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
