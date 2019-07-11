<?php
$userModel = Auth::user();
$activeClientModel = (isset($userModel->moderator) &&  isset($userModel->moderator->activeClient) ? $userModel->moderator->activeClient : null);
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="{{ route('home') }}">{{ env('APP_NAME', 'Laravel') }}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">Home</a>
            </li>
            @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('stripe.index') }}">Stripe</a>
            </li>
                @if ($userModel->hasPermissionTo(\App\Models\User::PERMISSION_ADMIN))
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="admin-tasks-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Admin Tasks
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('audit-log.index') }}">Audit Logs</a>
                    <a class="dropdown-item" href="{{ route('manage-account.index') }}">Manage Users</a>
                    </div>
                </li>
                @endif
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="user-account-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ $userModel->name }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('account.change-password') }}">Change Password</a>
                <a id='logout-link' class="dropdown-item" href="#"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                </a>
                </div>
            </li>
            @endguest
        </ul>
    </div>
</nav>
