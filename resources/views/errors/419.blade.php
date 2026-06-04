@extends('layouts.app_authentication')

@section('title', '419 - Sesión expirada')

@section('content')

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body{
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #0f172a, #1e293b);
        overflow: hidden;
    }

    .error-wrapper{
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        position: relative;
    }

    /* Fondo animado */
    .circle{
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: .35;
        animation: float 6s ease-in-out infinite;
    }

    .circle.one{
        width: 320px;
        height: 320px;
        background: #3b82f6;
        top: -120px;
        left: -120px;
    }

    .circle.two{
        width: 260px;
        height: 260px;
        background: #06b6d4;
        bottom: -100px;
        right: -100px;
        animation-delay: 2s;
    }

    @keyframes float{
        0%,100%{
            transform: translateY(0px);
        }
        50%{
            transform: translateY(-20px);
        }
    }

    .error-card{
        position: relative;
        z-index: 2;
        width: 100%;
        max-width: 760px;
        padding: 70px 60px;
        border-radius: 35px;
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(18px);
        border: 1px solid rgba(255,255,255,0.08);
        box-shadow: 0 15px 45px rgba(0,0,0,.4);
        text-align: center;
        animation: fadeIn 1s ease;
    }

    .clock{
        width: 130px;
        height: 130px;
        margin: auto;
        margin-bottom: 30px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        background: rgba(59,130,246,.12);
        border: 2px solid rgba(59,130,246,.25);
        box-shadow: 0 0 40px rgba(59,130,246,.25);
    }

    .clock i{
        font-size: 55px;
        color: #3b82f6;
    }

    .error-code{
        font-size: 140px;
        font-weight: 800;
        line-height: 1;
        color: white;
        margin-bottom: 10px;
        text-shadow: 0 0 25px rgba(255,255,255,.1);
    }

    .error-title{
        font-size: 40px;
        font-weight: 700;
        color: white;
        margin-bottom: 15px;
    }

    .error-text{
        color: rgba(255,255,255,.75);
        font-size: 18px;
        line-height: 1.7;
        margin-bottom: 45px;
    }

    .buttons{
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .btn-custom{
        padding: 15px 35px;
        border-radius: 14px;
        text-decoration: none;
        font-size: 17px;
        font-weight: 600;
        transition: all .3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-back{
        border: 2px solid rgba(255,255,255,.15);
        color: white;
        background: transparent;
    }

    .btn-back:hover{
        background: rgba(255,255,255,.08);
        transform: translateY(-3px);
        color: white;
    }

    .btn-home{
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        box-shadow: 0 8px 20px rgba(37,99,235,.4);
    }

    .btn-home:hover{
        transform: translateY(-3px) scale(1.03);
        color: white;
        box-shadow: 0 10px 30px rgba(37,99,235,.65);
    }

    @keyframes fadeIn{
        from{
            opacity: 0;
            transform: translateY(40px);
        }
        to{
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media(max-width: 768px){

        .error-card{
            padding: 50px 30px;
        }

        .error-code{
            font-size: 100px;
        }

        .error-title{
            font-size: 30px;
        }

        .error-text{
            font-size: 16px;
        }

    }

</style>

<div class="error-wrapper">

    <div class="circle one"></div>
    <div class="circle two"></div>

    <div class="error-card">

        <div class="clock">
            <i class="fas fa-clock"></i>
        </div>

        <div class="error-code">
            419
        </div>

        <div class="error-title">
            Sesión expirada
        </div>

        <div class="error-text">
            Tu sesión ha expirado por seguridad o inactividad.
            Por favor, vuelve a cargar la página e inicia sesión nuevamente.
        </div>

        <div class="buttons">

            <a href="{{ url()->previous() }}" class="btn-custom btn-back">
                <i class="fas fa-arrow-left"></i>
                Volver
            </a>

            <a href="{{ route('login') }}" class="btn-custom btn-home">
                <i class="fas fa-right-to-bracket"></i>
                Iniciar sesión
            </a>

        </div>

    </div>

</div>

@endsection
