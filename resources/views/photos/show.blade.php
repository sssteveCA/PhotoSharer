@extends('layouts.page')

@section('content')
    @php
            echo '<pre>';
            var_dump($data);
            echo '</pre>';
    @endphp 
@endsection