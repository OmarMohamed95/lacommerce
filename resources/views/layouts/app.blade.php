<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" />

    <!-- jquery -->
    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script defer src="{{ mix('js/app.js') }}"></script>

    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />-->
    <script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'></script>
</head>
<body>
    @include('app.inc.msgAjax')
    <div id="app" class="container-fluid customContainer">
        <div class="row">
        @include('app.inc.navbar')
        <div class="container appContent">
            @include('app.inc.messeges')
            @include('app.inc.messegeTop')
            @yield('content')
        </div>
        @include('app.inc.footer')
        </div>
    </div>
    @yield('script')
</body>
</html>
