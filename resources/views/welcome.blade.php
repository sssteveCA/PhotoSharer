@extends('layouts.page')

@section('content')
    @php
        echo '<pre>';
        var_dump($photos);
        echo '</pre>';
    @endphp
@endsection