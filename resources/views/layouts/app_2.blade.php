@inject('request', 'Illuminate\Http\Request')

@if($request->segment(1) == 'pos' && ($request->segment(2) == 'create' || $request->segment(3) == 'edit'))
@php
    $pos_layout = true;
@endphp
@else
@php
    $pos_layout = false;
@endphp
@endif

        <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{in_array(session()->get('user.language', config('app.locale')), config('constants.langs_rtl')) ? 'rtl' : 'ltr'}}">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ Session::get('business.name') }}</title>

    @include('layouts.partials.css')
    <link rel="stylesheet" href="{{asset('assets/css/all.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" />
    @yield('css')
    <style>
        @media screen and (max-width: 576px) {

            .sidebar-open .main-header {

                transform: translate(230px, 0);
            }
        }
    </style>
</head>
<body class="@if($pos_layout) hold-transition lockscreen @else hold-transition skin-@if(!empty(session('business.theme_color'))){{session('business.theme_color')}}@else{{'black-light'}}@endif sidebar-mini @endif">
<div class="wrapper thetop">
    <script type="text/javascript">
        if(localStorage.getItem("upos_sidebar_collapse") == 'true'){
            var body = document.getElementsByTagName("body")[0];
            body.className += " sidebar-collapse";
        }
    </script>
@if(!$pos_layout)
    @include('layouts.partials.header')
    @include('layouts.partials.sidebar')
@else
    @include('layouts.partials.header-pos')
@endif

<!-- Content Wrapper. Contains page content -->
    <div class="@if(!$pos_layout) content-wrapper @endif">
        <!-- empty div for vuejs -->
        <div id="app">
            @yield('vue')
        </div>
        <!-- Add currency related field-->
        <input type="hidden" id="__code" value="{{session('currency')['code']}}">
        <input type="hidden" id="__symbol" value="{{session('currency')['symbol']}}">
        <input type="hidden" id="__thousand" value="{{session('currency')['thousand_separator']}}">
        <input type="hidden" id="__decimal" value="{{session('currency')['decimal_separator']}}">
        <input type="hidden" id="__symbol_placement" value="{{session('business.currency_symbol_placement')}}">
        <input type="hidden" id="__precision" value="{{session('business.currency_precision', 2)}}">
        <input type="hidden" id="__quantity_precision" value="{{session('business.quantity_precision', 2)}}">
        <!-- End of currency related field-->

        @if (session('status'))
            <input type="hidden" id="status_span" data-status="{{ session('status.success') }}" data-msg="{{ session('status.msg') }}">
        @endif
        @yield('content')

        <div class='scrolltop no-print'>
            <div class='scroll icon'><i class="fas fa-angle-up"></i></div>
        </div>

        @if(config('constants.iraqi_selling_price_adjustment'))
            <input type="hidden" id="iraqi_selling_price_adjustment">
    @endif

    <!-- This will be printed -->
        <section class="invoice print_section" id="receipt_section">
        </section>

    </div>
@include('home.todays_profit_modal')
<!-- /.content-wrapper -->

    @if(!$pos_layout)
        @include('layouts.partials.footer')
    @else
        @include('layouts.partials.footer_pos')
    @endif

    <audio id="success-audio">
        <source src="{{ asset('/audio/success.ogg?v=' . $asset_v) }}" type="audio/ogg">
        <source src="{{ asset('/audio/success.mp3?v=' . $asset_v) }}" type="audio/mpeg">
    </audio>
    <audio id="error-audio">
        <source src="{{ asset('/audio/error.ogg?v=' . $asset_v) }}" type="audio/ogg">
        <source src="{{ asset('/audio/error.mp3?v=' . $asset_v) }}" type="audio/mpeg">
    </audio>
    <audio id="warning-audio">
        <source src="{{ asset('/audio/warning.ogg?v=' . $asset_v) }}" type="audio/ogg">
        <source src="{{ asset('/audio/warning.mp3?v=' . $asset_v) }}" type="audio/mpeg">
    </audio>
</div>

@if(!empty($__additional_html))
    {!! $__additional_html !!}
@endif
<div class="modal fade view_modal" tabindex="-1" role="dialog"
     aria-labelledby="gridSystemModalLabel"></div>
@include('layouts.partials.javascripts')
@if(!empty($__additional_views) && is_array($__additional_views))
    @foreach($__additional_views as $additional_view)
        @includeIf($additional_view)
    @endforeach
@endif
</body>

</html>