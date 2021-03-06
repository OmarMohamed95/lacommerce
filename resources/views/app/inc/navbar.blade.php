<a class="navbar-brand" href="{{ url('/') }}">
    {{ config('app.name', 'Lacommerce') }}
</a>
<div class="clearfix visible-xs"></div>
<div class="row" style="margin-right:0px;">
    <form action="{{ url('search') }}" method="POST" id="searchInputForm">
        {{ csrf_field() }}
        <div class="col-xs-6 col-sm-10 col-md-4 col-lg-8">
            <input id="searchInput" name="search" type="text" class="form-control" placeholder="What are you looking for?" style="margin-top: 5px;" value="{{ request()->input('search') }}" autocomplete="off">
            <ul id="searchResultsMenu" class="search-results-menu"></ul>
        </div>
        <div class="col-xs-4 col-sm-2 col-md-1 col-lg-1">
            <button type="submit" class="btn btn-success pull-right" style="margin: 5px 33px;">Search</button>
        </div>
    </form>
    <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1 pull-right homeCart">
        <a @if (Auth::guest()) id='disableCart' @endif href="{{ route('cart_index') }}"><i class="fas fa-shopping-cart fa-2x"></i> Cart</a>
    </div>
</div>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <!--<a class="navbar-brand" href="{{ url('/') }}">
                
            </a> -->
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                @foreach ($parents as $p)
                @if ($p->children->count() > 0)
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $p->name }}<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @foreach ($p->children as $c)
                            <li><a href="{{ url('category/' . $c->id) }}">{{ $c->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                    @else
                        <li><a href="{{ url('category/' . $p->id) }}">{{ $p->name }}</a></li>
                    @endif
                @endforeach
            </ul>
            
            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ url('profile') }}">
                                    My Profile
                                </a>
                                <a href="{{ url('wishlist') }}">
                                    My Wishlist
                                </a>
                                <a href="{{ route('order_my_orders') }}">
                                    My orders
                                </a>
                                <a href="{{ route('order_track') }}">
                                    track order
                                </a>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
@section('script')
    @parent
    <script src="{{ mix('js/App/search.js') }}" type="text/javascript"></script>
    <script src="{{ mix('js/App/cartShared.js') }}" type="text/javascript"></script>
@endsection