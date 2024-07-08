@extends('administrator.layouts.base')

@section('app')
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            @include('administrator.layouts.partials.header')
            @include('administrator.layouts.partials.sidebar')
            @yield('content')
            {{-- <div class="main-content">
                <section class="section">
                </section>
            </div> --}}

            @include('administrator.layouts.partials.footer')
        </div>
    </div>
@endsection
