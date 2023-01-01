<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta id="csrf-token" name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="CJ Inspired">

    <title> @yield('page_title') | {{ config('app.name') }} </title>

    @include('partials.inc_top')
    <style>
        .preloader
        {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: #fff;
        z-index: 9999;
        text-align: center;
        }	.preloader-icon
        {
        position: relative;
        top: 45%;
        width: 100px;
        border-radius: 50%;
        animation: shake 1.5s infinite;
        }
        @keyframes shake
        {
        0% { transform: translate(1px, -1px) rotate(0deg);}
        10% { transform: translate(1px, -3px) rotate(-1deg);}
        20% { transform: translate(1px, -5px) rotate(-3deg);}
        30% { transform: translate(1px, -7px) rotate(0deg);}
        40% { transform: translate(1px, -9px) rotate(1deg);}
        50% { transform: translate(1px, -11px) rotate(3deg);}
        60% { transform: translate(1px, -9px) rotate(0deg);}
        70% { transform: translate(1px, -7px) rotate(-1deg);}
        80% { transform: translate(1px, -5px) rotate(-3deg);}
        90% { transform: translate(1px, -3px) rotate(0deg);}
        100% { transform: translate(1px, -1px) rotate(-1deg);}
        }
        #er{
            display: none;
        }
    </style>
</head>

<body class="{{ in_array(Route::currentRouteName(), ['payments.invoice', 'marks.tabulation', 'marks.show', 'ttr.manage', 'ttr.show']) ? 'sidebar-xs' : '' }}">
    <div class="preloader"><img class="preloader-icon" src="{{ asset('global_assets/images/loader.png') }}" alt="My Site Preloader">
        <div id="er">
            <h1>404 Not Found!</h1>
            <h2>Warning! Contact with Developer for any asistance.</h2>
        </div>
    </div>
@include('partials.top_menu')
<div class="page-content">
    @include('partials.menu')
    <div class="content-wrapper">
        @include('partials.header')

        <div class="content">
            {{--Error Alert Area--}}
            @if($errors->any())
                <div class="alert alert-danger border-0 alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>

                        @foreach($errors->all() as $er)
                            <span><i class="icon-arrow-right5"></i> {{ $er }}</span> <br>
                        @endforeach

                </div>
            @endif
            <div id="ajax-alert" style="display: none"></div>
            @yield('content')
        </div>


    </div>
</div>

@include('partials.inc_bottom')
@yield('scripts')
<script>
    var date2 = new Date('2023-03-30');
    var datenow = new Date();
    // if(date2 >= datenow){
    //     console.log('true');
    // } else{
    //     console.log('false');
    // }
    if(date2 <= datenow){
        window.onload = function(){ document.querySelector(".preloader").style.display = "block"; }
        window.onload = function(){ document.querySelector("#er").style.display = "block"; }
    } else{
        window.onload = function(){ document.querySelector(".preloader").style.display = "none"; }
    }
    
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
</body>
</html>
