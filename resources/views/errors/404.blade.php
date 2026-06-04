@extends('layouts.app_authentication')

@section('title', '404 - Página no encontrada')

@section('content')

<style>
    body{
        background: linear-gradient(135deg, #0f172a, #1e293b);
        min-height: 100vh;
        overflow: hidden;
        font-family: 'Poppins', sans-serif;
    }

    .error-container{
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .error-card{
        position: relative;
        width: 100%;
        max-width: 750px;
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(15px);
        border-radius: 30px;
        padding: 60px;
        text-align: center;
        box-shadow: 0 8px 40px rgba(0,0,0,0.4);
        border: 1px solid rgba(255,255,255,0.1);
        overflow: hidden;
        animation: fadeIn 1s ease;
    }

    .error-card::before{
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(59,130,246,0.2);
        border-radius: 50%;
        top: -100px;
        left: -100px;
        filter: blur(60px);
    }

    .error-card::after{
        content: '';
        position: absolute;
        width: 250px;
        height: 250px;
        background: rgba(239,68,68,0.2);
        border-radius: 50%;
        bottom: -100px;
        right: -100px;
        filter: blur(60px);
    }

    .error-code{
        font-size: 140px;
        font-weight: 800;
        color: white;
        line-height: 1;
        margin-bottom: 15px;
        text-shadow: 0 0 25px rgba(255,255,255,0.2);
    }

    .error-title{
        font-size: 38px;
        color: white;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .error-text{
        color: rgba(255,255,255,0.75);
        font-size: 18px;
        margin-bottom: 40px;
    }

    .btn-custom{
        padding: 14px 35px;
        border-radius: 14px;
        font-size: 17px;
        font-weight: 500;
        transition: all .3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-back{
        background: transparent;
        border: 2px solid rgba(255,255,255,0.2);
        color: white;
    }

    .btn-back:hover{
        background: rgba(255,255,255,0.1);
        transform: translateY(-3px);
        color: white;
    }

    .btn-home{
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        box-shadow: 0 5px 20px rgba(37,99,235,0.5);
    }

    .btn-home:hover{
        transform: translateY(-3px) scale(1.03);
        color: white;
        box-shadow: 0 8px 25px rgba(37,99,235,0.7);
    }

    .buttons{
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    @keyframes fadeIn{
        from{
            opacity: 0;
            transform: translateY(30px);
        }
        to{
            opacity: 1;
            transform: translateY(0);
        }
    }

</style>

{{-- Font Awesome --}}
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<div class="error-container">

    <div class="error-card">

        <div class="error-code">
            404
        </div>

        <div class="error-title">
            Página no encontrada
        </div>

        <div class="error-text">
            La página que intentas visitar no existe, fue movida
            o posiblemente nunca estuvo aquí.
        </div>

        <div class="buttons">

            <a href="{{ url()->previous() }}" class="btn-custom btn-back">
                <i class="fas fa-arrow-left"></i>
                Volver
            </a>

            <a href="{{ url('/') }}" class="btn-custom btn-home">
                <i class="fas fa-house"></i>
                Ir al inicio
            </a>

        </div>

    </div>

</div>

@endsection
