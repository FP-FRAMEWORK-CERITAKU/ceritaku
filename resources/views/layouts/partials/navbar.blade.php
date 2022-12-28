@php
    $user = auth()->user();
    if (
        empty($user)
        || !$user instanceof \App\Models\User
    ) {
        $user = new \App\Models\User([
            'name' => 'Guest',
            'email' => 'guest@localhost'
        ]);
    }
@endphp

<li class="nav-item dropdown dropdown-user">
    <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <div class="user-nav d-sm-flex d-none">
            <span class="user-name fw-bolder">{{ $user->name }}</span>
            <span class="user-status">{{ $user->getRoleNames()->isNotEmpty() ? $user->getRoleNames()->implode(',') : 'Guest' }}</span>
        </div>
        <span class="avatar">
            @php
                $avatar = asset('app-assets/images/portrait/small/avatar-s-11.jpg');

                if (auth()->check()) {
                    $avatar = $user->getPhotoUrl() ?: $avatar;
                }
            @endphp
            <img class="round" src="{{ $avatar }}" alt="avatar" height="40" width="40">
        </span>
    </a>
    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
        @if(auth()->check())
            <a class="dropdown-item" href="{{ route('profile.index') }}">
                <i class="me-50" data-feather="user"></i> Profil
            </a>
            <div class="dropdown-divider"></div>
        @endif

        @if(auth()->check())
            <a class="dropdown-item" href="{{ route('auth.logout') }}">
                <i class="me-50" data-feather="log-out"></i> Logout
            </a>
        @else
            <a class="dropdown-item" href="{{ route('auth.login') }}">
                <i class="me-50" data-feather="log-in"></i> Login
            </a>
        @endif
    </div>
</li>
