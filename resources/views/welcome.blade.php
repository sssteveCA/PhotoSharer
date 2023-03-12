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
                @forelse($data['photos'] as $photo)
                <x-photo.thumbnail-image  classes="thumbnail-div col-12 col-sm-6 col-md-4 col-lg-3" :link="'/photos/'.$photo['id']" :src="$photo['src']"/>
                @empty
                <x-alert.message classes="alert alert-secondary" message="Nessuna foto trovata con i criteri specificati" />
                @endforelse
            </div>
        </div>
    @else
        <x-alert.message classes="alert alert-danger" :message="$message" />
    @endif
@endsection