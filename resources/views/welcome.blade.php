@extends('layouts.page')

@section('links')
    @parent
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
@endsection

@section('content')
    {{-- @php
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    @endphp --}}
    @if($done == true)
        <div class="container-fluid">
            <div class="row gy-5 gx-0 gx-3">
                @foreach($data['photos'] as $photo)
                <x-photo.thumbnail-image  classes="thumbnail-div col-12 col-sm-6 col-md-4 col-lg-3" :link="'/photos/'.$photo['id']" :src="$photo['src']"/>
                @endforeach
            </div>
        </div>
    @else
        <x-alert.error message={{$message}} />
    @endif
@endsection