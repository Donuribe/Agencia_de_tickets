@extends('layouts.app')

@section('content')
<style>
    body { background: #f7f7f7; font-family: 'Segoe UI', sans-serif; }
    .container { max-width: 420px; margin: 6vh auto; padding: 0 1rem; }
    .row { display: flex; flex-wrap: wrap; }
    .justify-content-center { justify-content: center; }
    .col-md-8 { width: 100%; }
    .card { background: #fff; border: 1px solid #e5e5e5; border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,.06); }
    .card-header { padding: 1.2rem 1.5rem; font-size: .85rem; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; color: #888; border-bottom: 1px solid #f0f0f0; background: none; }
    .card-body { padding: 1.5rem; font-size: .9rem; color: #444; line-height: 1.6; }
    .alert-success { background: #f0faf4; border: 1px solid #b7e4c7; color: #276749; border-radius: 5px; padding: .7rem 1rem; margin-bottom: 1rem; font-size: .85rem; }
    .d-inline { display: inline; }
    .btn-link { background: none; border: none; color: #222; font-weight: 600; font-size: .9rem; cursor: pointer; padding: 0; text-decoration: underline; }
    .btn-link:hover { color: #555; }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
