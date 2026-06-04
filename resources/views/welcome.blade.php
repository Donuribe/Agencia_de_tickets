@extends('layouts.app_authentication')

@section('title', 'Bienvenido')

@section('content')
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <img src="{{ asset('backend/dist/img/ticket_logo.png') }}" alt="" style="max-width: 100%; height: auto; max-height: 70px;">
            </div>
            <div class="card-body">
                <p class="login-box-msg">{{ __('Bienvenido') }}</p>
                
                @auth
                    <p class="text-center mb-3">{{ __('¿Listo para continuar?') }}</p>
                    <a href="{{ url('/home') }}" class="btn btn-primary btn-block">
                        {{ __('Ir al Dashboard') }}
                    </a>
                @else
                    <p class="text-center mb-3">{{ __('Inicia sesión o regístrate para continuar') }}</p>
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('login') }}" class="btn btn-primary btn-block">
                                {{ __('Iniciar Sesión') }}
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('register') }}" class="btn btn-success btn-block">
                                {{ __('Registrarse') }}
                            </a>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
@endsection