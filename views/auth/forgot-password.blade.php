@extends('layouts.app')
@section('title', 'ChanchullApp — Recuperar Contraseña')

@section('content')
<div style="max-width:420px;margin:0 auto;padding:80px 24px 80px">

    <div style="text-align:center;margin-bottom:32px">
        <div style="width:56px;height:56px;border-radius:14px;background:linear-gradient(135deg,rgba(255,107,157,0.15),rgba(123,97,255,0.15));border:1px solid rgba(255,255,255,0.06);display:inline-flex;align-items:center;justify-content:center;font-size:22px;color:#ff6b9d;margin-bottom:16px">
            <i class="fa-solid fa-lock"></i>
        </div>
        <h1 class="heading-lg" style="margin-bottom:6px">Recuperar Contraseña</h1>
        <p style="font-size:13px;color:rgba(255,255,255,0.35)">Te enviaremos un enlace para crear una nueva contraseña</p>
    </div>

    @if($error)
        <div style="padding:12px 16px;border-radius:10px;background:rgba(255,107,107,0.08);border:1px solid rgba(255,107,107,0.18);margin-bottom:20px;font-size:13px;color:#ff6b6b">
            <i class="fa-solid fa-circle-exclamation" style="margin-right:6px"></i> {{ $error }}
        </div>
    @endif

    @if($success)
        <div class="card glow-border" style="padding:28px;text-align:center;margin-bottom:20px">
            <div style="width:56px;height:56px;border-radius:50%;background:rgba(0,255,136,0.08);border:1px solid rgba(0,255,136,0.18);display:inline-flex;align-items:center;justify-content:center;font-size:22px;color:#00ff88;margin-bottom:16px">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <h3 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:16px;margin-bottom:8px;color:#fff">Enlace enviado</h3>
            <p style="font-size:13px;color:rgba(255,255,255,0.4);line-height:1.6;margin-bottom:20px">
                Si el email existe en nuestro sistema, recibirás un enlace para restablecer tu contraseña.
            </p>
            @if($reset_link)
                <div style="padding:12px;border-radius:10px;background:rgba(0,245,212,0.06);border:1px solid rgba(0,245,212,0.15);margin-bottom:16px">
                    <div style="font-size:11px;color:rgba(255,255,255,0.3);margin-bottom:6px">
                        <i class="fa-solid fa-circle-info" style="color:#00f5d4"></i> Modo demo — Enlace de recuperación:
                    </div>
                    <a href="{{ $reset_link }}" style="color:#00f5d4;font-size:13px;font-weight:600;text-decoration:none;word-break:break-all">
                        {{ $reset_link }}
                    </a>
                </div>
            @endif
            <a href="/login" class="btn btn--primary" style="width:100%;justify-content:center;padding:12px">
                <i class="fa-solid fa-arrow-left"></i> Volver al login
            </a>
        </div>
    @else
        <form method="POST" action="/forgot-password" class="card" style="padding:28px">
            <div style="margin-bottom:24px">
                <label style="font-size:12px;font-weight:600;color:rgba(255,255,255,0.4);display:block;margin-bottom:6px">Email</label>
                <input type="email" name="email" required placeholder="tu@email.com"
                    style="width:100%;padding:12px 14px;border-radius:10px;border:1px solid rgba(255,255,255,0.08);background:rgba(255,255,255,0.03);color:#fff;font-size:14px;outline:none;transition:border-color 0.3s"
                    onfocus="this.style.borderColor='rgba(0,245,212,0.3)'" onblur="this.style.borderColor='rgba(255,255,255,0.08)'">
            </div>
            <button type="submit" class="btn btn--primary" style="width:100%;justify-content:center;padding:12px">
                <i class="fa-solid fa-paper-plane"></i> Enviar enlace de recuperación
            </button>
        </form>
    @endif

    <div style="text-align:center;margin-top:20px;font-size:13px;color:rgba(255,255,255,0.35)">
        <a href="/login" style="color:#00f5d4;text-decoration:none;font-weight:600"><i class="fa-solid fa-arrow-left" style="margin-right:4px"></i> Volver al login</a>
    </div>
</div>
@endsection
