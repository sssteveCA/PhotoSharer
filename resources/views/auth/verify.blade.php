@extends('layouts.page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifica il tuo indirizzo email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Abbiamo inviato un link di verifica al tuo indirizzo email.') }}
                        </div>
                    @endif

                    {{ __('Prima di procedere fai click sul link di verifica che abbiamo inviato alla tua casella di posta.') }}
                    {{ __('Se non l\'hai ricevuto') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('fai click qui per richiederne un altro') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
