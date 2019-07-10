@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">Register</h1>

                    <form id="register-form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        @include ('components.form-input', [
                            'id' => 'name',
                            'label' => 'Name',
                            'type' => 'text',
                            'value' => old('name'),
                            'required' => true,
                            'controlAttributes' => 'autofocus'
                        ])

                        @include ('components.form-input', [
                            'id' => 'email',
                            'label' => 'E-Mail Address',
                            'type' => 'email',
                            'value' => old('email'),
                            'required' => true
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
                            'label' => 'Password Confirmation',
                            'type' => 'password',
                            'value' => old('password_confirmation'),
                            'required' => true
                        ])

                        <div class="form-group">
                            @include ('components.button', [
                                'type' => 'submit',
                                'label' => 'Register',
                            ])

                            @include ('components.link', [
                                'class' => 'btn btn-link',
                                'href' => route('login'),
                                'label' => 'Already Have An Account?',
                            ])
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
