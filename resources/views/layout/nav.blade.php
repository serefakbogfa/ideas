<nav class="navbar navbar-expand-lg bg-dark border-bottom border-bottom-dark fixed-top">
    <div class="container">
        <a class="navbar-brand nav-link " href="/"><span class="fa-solid fa-xmarks-lines me-2"></span>{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                @guest
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('login') ? 'active' : '' }}" aria-current="page" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('register') ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
                    </li>
                @endguest
                @auth
                @if (Auth::user()->is_admin)
                <li class="nav-item">
                    <a class="nav-link me-2 {{ Request::is('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                </li>
                @endif
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('profile') ? 'active' : '' }}" href="{{ route('profile') }}">{{ Auth::user()->name }}</a>
                    </li>
                    <li class="nav-item mt-1 me- -1">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-danger btn-sm" type="submit">Logout</button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
