@extends('layouts.app')
@section('title', 'ChanchullApp — Iniciar Sesión')

@section('content')
<div style="max-width:420px;margin:0 auto;padding:80px 24px 80px">

    <div style="text-align:center;margin-bottom:32px">
        <div style="width:56px;height:56px;border-radius:14px;background:linear-gradient(135deg,rgba(0,245,212,0.15),rgba(123,97,255,0.15));border:1px solid rgba(255,255,255,0.06);display:inline-flex;align-items:center;justify-content:center;font-size:22px;color:#00f5d4;margin-bottom:16px">
            <i class="fa-solid fa-right-to-bracket"></i>
        </div>
        <h1 class="heading-lg" style="margin-bottom:6px">Iniciar Sesión</h1>
        <p style="font-size:13px;color:rgba(255,255,255,0.35)">Accedé a tu cuenta para comparar precios</p>
    </div>

    @if($error)
        <div style="padding:12px 16px;border-radius:10px;background:rgba(255,107,107,0.08);border:1px solid rgba(255,107,107,0.18);margin-bottom:20px;font-size:13px;color:#ff6b6b">
            <i class="fa-solid fa-circle-exclamation" style="margin-right:6px"></i> {{ $error }}
        </div>
    @endif

    @if(isset($_GET['success']))
        <div style="padding:12px 16px;border-radius:10px;background:rgba(0,255,136,0.08);border:1px solid rgba(0,255,136,0.18);margin-bottom:20px;font-size:13px;color:#00ff88">
            <i class="fa-solid fa-circle-check" style="margin-right:6px"></i> {{ $_GET['success'] }}
        </div>
    @endif

    <form method="POST" action="/login" class="card" style="padding:28px">
        <div style="margin-bottom:16px">
            <label style="font-size:12px;font-weight:600;color:rgba(255,255,255,0.4);display:block;margin-bottom:6px">Email</label>
            <input type="email" name="email" required placeholder="tu@email.com"
                style="width:100%;padding:12px 14px;border-radius:10px;border:1px solid rgba(255,255,255,0.08);background:rgba(255,255,255,0.03);color:#fff;font-size:14px;outline:none;transition:border-color 0.3s"
                onfocus="this.style.borderColor='rgba(0,245,212,0.3)'" onblur="this.style.borderColor='rgba(255,255,255,0.08)'">
        </div>
        <div style="margin-bottom:24px">
            <label style="font-size:12px;font-weight:600;color:rgba(255,255,255,0.4);display:block;margin-bottom:6px">Contraseña</label>
            <input type="password" name="password" required placeholder="••••••••"
                style="width:100%;padding:12px 14px;border-radius:10px;border:1px solid rgba(255,255,255,0.08);background:rgba(255,255,255,0.03);color:#fff;font-size:14px;outline:none;transition:border-color 0.3s"
                onfocus="this.style.borderColor='rgba(0,245,212,0.3)'" onblur="this.style.borderColor='rgba(255,255,255,0.08)'">
        </div>
        <div style="text-align:right;margin-bottom:20px">
            <a href="/forgot-password" style="font-size:12px;color:rgba(255,255,255,0.3);text-decoration:none;transition:color 0.25s" onmouseover="this.style.color='#ff6b9d'" onmouseout="this.style.color='rgba(255,255,255,0.3)'">
                ¿Olvidaste tu contraseña?
            </a>
        </div>
        <button type="submit" class="btn btn--primary" style="width:100%;justify-content:center;padding:12px">
            <i class="fa-solid fa-arrow-right-to-bracket"></i> Iniciar Sesión
        </button>
    </form>

    <div style="text-align:center;margin-top:20px;font-size:13px;color:rgba(255,255,255,0.35)">
        ¿No tienes cuenta? <a href="/register" style="color:#00f5d4;text-decoration:none;font-weight:600">Registrate aquí</a>
    </div>
</div>
@endsection
