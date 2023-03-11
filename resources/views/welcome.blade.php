@extends('layouts.page')

@section('content')
    @php
        echo '<pre>';
        var_dump($photos);
        echo '</pre>';
    @endphp 
    @if($done == true)
        <div class="container-fluid">
            <div class="row g-3">
                @foreach($photos as $photo)
                @endforeach
            </div>
        </div>
    @else
        <x-alert.error message={{$message}} />
    @endif
@endsection