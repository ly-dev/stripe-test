@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">Change Password</h1>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('account.change-password') }}">
                        {{ csrf_field() }}

                        @include ('components.form-input', [
                            'id' => 'old_password',
                            'label' => 'Current Password',
                            'type' => 'password',
                            'value' => old('old_password'),
                            'required' => true,
                            'controlAttributes' => 'autofocus'
                        ])

                        @include ('components.form-input', [
                            'id' => 'new_password',
                            'label' => 'New Password',
                            'type' => 'password',
                            'value' => old('new_password'),
                            'required' => true,
                        ])

                        @include ('components.form-input', [
                            'id' => 'new_password_confirmation',
                            'label' => 'New Password Confirmation',
                            'type' => 'password',
                            'value' => old('new_password_confirmation'),
                            'required' => true,
                        ])

                        @include ('components.form-submit', [
                            'label' => 'Save',
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
