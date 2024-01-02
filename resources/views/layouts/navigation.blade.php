<nav class="navbar navbar-default custom-navbar">
    <div class="container-fluid">
        <!-- Navbar Header -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
            </button>
        </div>
        <!-- Navbar Collapse -->
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav" style="margin-top: 10px;">
                <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('execute-code') }}">Code Execution</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right" style="margin-top: 5px;">
                @if (Auth::check())
                <li style="margin-top: 10px">
                    <form action="{{ route('logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="btn btn-link logout-btn"><span
                                class="glyphicon glyphicon-log-out"></span> Logout</button>
                    </form>
                </li>
                @else
                <li><a href="{{ route('login') }}">Log in</a></li>
                @if (Route::has('register'))
                <li><a href="{{ route('register') }}">Register</a></li>
                @endif
                @endif
            </ul>
        </div>
    </div>
</nav>
