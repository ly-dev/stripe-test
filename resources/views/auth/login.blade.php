@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">Login</h1>

                    <form id="login-form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

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
                            'required' => true,
                        ])

                        @include ('components.form-check', [
                            'id' => 'remember',
                            'label' => 'Remember Me',
                            'value' => 1,
                            'checked' => old('remember'),
                        ])

                        <div class="form-group">
                            @include ('components.button', [
                                'type' => 'submit',
                                'label' => 'Login',
                            ])

                            @include ('components.link', [
                                'class' => 'btn btn-link',
                                'href' => route('password.request'),
                                'label' => 'Forgot Your Password?',
                            ])

                            @include ('components.link', [
                                'class' => 'btn btn-link',
                                'href' => route('register'),
                                'label' => 'Sign Up A New Account?',
                            ])
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
