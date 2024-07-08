@extends('layouts.base')

@section('main')
@include('layouts.partials.header')

<main class="main">

    @yield('main-content')

</main>
@include('layouts.partials.footer')

@endsection
