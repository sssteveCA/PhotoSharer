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
        <x-alert.message classes="alert alert-danger" :message="$message" />
    @endif
@endsection