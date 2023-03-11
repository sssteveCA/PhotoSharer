@extends('layouts.page')

@section('content')
    {{-- @php
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    @endphp --}}
    @if($done == true)
        @includeWhen($data['role'] == 'admin','partials.dashboard.admin')
        @includeWhen($data['role'] == 'user','partials.dashboard.user')
    @else
    @endif
@endsection