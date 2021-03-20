<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('admin/home')}}">ecommerce</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a target="_blank" href="{{ url('') }}">Browse Website <span class="sr-only">(current)</span></a></li>
                <li><a href="{{ route('admin_category_index') }}">categores</a></li>
                <li><a href="{{ aurl('products') }}">products</a></li>
                <li><a href="{{ aurl('offers') }}">offers</a></li>
                <li><a href="{{ route('admin_brand_index') }}">brands</a></li>
                <li><a href="{{ aurl('custom_field') }}">custom field</a></li>
                <li><a href="{{ aurl('reviews') }}">reviews</a></li>
                <li><a href="{{ route('admin_order_index') }}">orders</a></li>
                <li><a href="{{ aurl('sittings') }}">settings</a></li>
                <li><a href="{{ route('admin_user_index') }}">admins</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ aurl('logout')}}">Logout</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>