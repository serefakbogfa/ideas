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
                        <a class="nav-link {{ Request::is('login') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('register') ? 'active' : '' }}"
                            href="{{ route('register') }}">Register</a>
                    </li>
                @endguest
                @auth
                    @if (Auth::user()->is_admin)
                        <li class="nav-item">
                            <a class="{{ Route::is('admin.dashboard') ? 'active' : '' }} nav-link"
                                href="{{ route('admin.dashboard') }}">
                                Admin Dashboard </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('profile') ? 'active' : '' }}"
                            href="{{ route('profile') }}">{{ Auth::user()->name }}</a>
                    </li>
                    <li class="nav-item mt-1 me-3"> <!-- Margin-right  -->
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-danger btn-sm" type="submit">Logout</button>
                        </form>
                    </li>
                @endauth
            </ul>
            <li class="nav-item mt-1"></li>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    lang
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="dropdownMenu">
                    <a class="dropdown-item" href="{{ route('lang', 'en') }}">English</a>
                    <a class="dropdown-item" href="{{ route('lang', 'es') }}">Spanish</a>
                    <a class="dropdown-item" href="{{ route('lang', 'tr') }}">Turkish</a>
                </div>
            </div>
        </div>
    </div>
</nav>
