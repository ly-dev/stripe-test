@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-sm-6">
            <h1>Welcome to {{ env('APP_NAME', 'Laravel') }}</h1>
            @guest
            <p>Please login.</p>
            @else
            <p>You've logged in.</p>
            @endguest
        </div>
    </div>
</div>
@endsection
