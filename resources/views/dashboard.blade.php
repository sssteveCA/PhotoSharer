@extends('layouts.page')

@section('content')
    @php
        echo '<pre>';
        var_dump($user);
        echo '</pre>';
    @endphp
@endsection