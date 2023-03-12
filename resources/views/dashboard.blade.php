@extends('layouts.page')

@section('content')
    {{-- @php
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    @endphp --}}
    @if($done == true)
        @includeWhen($data['role'] == 'admin','partials.dashboard.admin',[
            'comments' => $data['comments'],
            'photos' => $data['photos'],
            'reported_comments' => $data['reported_comments'],
            'reported_photos' => $data['reported_photos'],
            'tags' => $data['tags'],
            'users_subscribed' => $data['users_subscribed'],
        ])
        @includeWhen($data['role'] == 'user','partials.dashboard.user')
    @else
        <x-alert.message classes="alert alert-danger" :message="$message" />
    @endif
@endsection