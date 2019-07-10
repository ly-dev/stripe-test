@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">Reset Password</h1>

                    <form id="password-request-form" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        @include ('components.form-input', [
                            'id' => 'email',
                            'label' => 'E-Mail Address',
                            'type' => 'email',
                            'value' => old('email'),
                            'required' => true,
                            'controlAttributes' => 'autofocus'
                        ])

                        @include ('components.form-input', [
                            'id' => 'password',
                            'label' => 'Password',
                            'type' => 'password',
                            'value' => old('password'),
                            'required' => true
                        ])

                        @include ('components.form-input', [
                            'id' => 'password_confirmation',
                            'label' => 'Confirm Password',
                            'type' => 'password',
                            'value' => old('password_confirmation'),
                            'required' => true
                        ])

                        @include ('components.form-submit', [
                            'label' => 'Reset Password',
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
