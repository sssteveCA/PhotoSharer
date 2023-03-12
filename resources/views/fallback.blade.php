@extends('layouts.page')

@section('content')
    <x-alert.message classes="alert alert-danger" :message="$message" />
@endsection