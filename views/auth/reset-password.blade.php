@extends('layouts.app')
@section('title', 'ChanchullApp — Nueva Contraseña')

@section('content')
<div style="max-width:420px;margin:0 auto;padding:80px 24px 80px">

    <div style="text-align:center;margin-bottom:32px">
        <div style="width:56px;height:56px;border-radius:14px;background:linear-gradient(135deg,rgba(0,245,212,0.15),rgba(123,97,255,0.15));border:1px solid rgba(255,255,255,0.06);display:inline-flex;align-items:center;justify-content:center;font-size:22px;color:#00f5d4;margin-bottom:16px">
            <i class="fa-solid fa-key"></i>
        </div>
        <h1 class="heading-lg" style="margin-bottom:6px">Nueva Contraseña</h1>
        <p style="font-size:13px;color:rgba(255,255,255,0.35)">Elegí una contraseña segura para tu cuenta</p>
    </div>

    @if($error)
        <div style="padding:12px 16px;border-radius:10px;background:rgba(255,107,107,0.08);border:1px solid rgba(255,107,107,0.18);margin-bottom:20px;font-size:13px;color:#ff6b6b">
            <i class="fa-solid fa-circle-exclamation" style="margin-right:6px"></i> {{ $error }}
        </div>
    @endif

    <form method="POST" action="/reset-password" class="card" style="padding:28px">
        <input type="hidden" name="token" value="{{ $token }}">
        <div style="margin-bottom:16px">
            <label style="font-size:12px;font-weight:600;color:rgba(255,255,255,0.4);display:block;margin-bottom:6px">Nueva contraseña</label>
            <input type="password" name="password" required placeholder="Mínimo 6 caracteres"
                style="width:100%;padding:12px 14px;border-radius:10px;border:1px solid rgba(255,255,255,0.08);background:rgba(255,255,255,0.03);color:#fff;font-size:14px;outline:none;transition:border-color 0.3s"
                onfocus="this.style.borderColor='rgba(0,245,212,0.3)'" onblur="this.style.borderColor='rgba(255,255,255,0.08)'">
        </div>
        <div style="margin-bottom:24px">
            <label style="font-size:12px;font-weight:600;color:rgba(255,255,255,0.4);display:block;margin-bottom:6px">Confirmar contraseña</label>
            <input type="password" name="confirm_password" required placeholder="Repetí tu contraseña"
                style="width:100%;padding:12px 14px;border-radius:10px;border:1px solid rgba(255,255,255,0.08);background:rgba(255,255,255,0.03);color:#fff;font-size:14px;outline:none;transition:border-color 0.3s"
                onfocus="this.style.borderColor='rgba(0,245,212,0.3)'" onblur="this.style.borderColor='rgba(255,255,255,0.08)'">
        </div>
        <button type="submit" class="btn btn--primary" style="width:100%;justify-content:center;padding:12px">
            <i class="fa-solid fa-check"></i> Guardar nueva contraseña
        </button>
    </form>

    <div style="text-align:center;margin-top:20px;font-size:13px;color:rgba(255,255,255,0.35)">
        <a href="/login" style="color:#00f5d4;text-decoration:none;font-weight:600"><i class="fa-solid fa-arrow-left" style="margin-right:4px"></i> Volver al login</a>
    </div>
</div>
@endsection
