@extends('layouts.page')

@section('content')
    {{-- @php
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    @endphp --}}
    @if($done == true)
        @isset($data['comments'],$data['photos'],$data['reported_comments'],$data['reported_photos'],$data['tags'],$data['users_subscribed'],)
            @includeWhen($data['role'] == 'admin','partials.dashboard.admin',[
                'comments' => $data['comments'],
                'photos' => $data['photos'],
                'reported_comments' => $data['reported_comments'],
                'reported_photos' => $data['reported_photos'],
                'tags' => $data['tags'],
                'users_subscribed' => $data['users_subscribed'],
            ])
        @endisset
        @isset($data['username'])
            @includeWhen($data['role'] == 'user','partials.dashboard.user',[
                'username' => $data['username']
            ])
        @endisset
    @else
        <x-alert.message classes="alert alert-danger" :message="$message" />
    @endif
@endsection