@extends('layouts.page')

@section('links')
    @parent
    <link rel="stylesheet" href="{{ asset('css/photos/show.css') }}">
@endsection

@section('content')
    {{-- @php
            echo '<pre>';
            var_dump($data);
            echo '</pre>';
    @endphp --}}
    <div class="container-fluid">
        <div class="row">
            <div class="photo-div col-12 col-md-9">
                <img src="{{$data['src']}}" alt="" title="">
            </div>
            <x-components.photo.photo-details-component :author="$data['author']" classes="photo-details-div col-12 col-md-3" :photo="$data['photo']"/>
        </div>
        <div class="row">
            <x-components.photo.comments-list-component :comments="$data['comments']"/>
        </div>
    </div>
@endsection