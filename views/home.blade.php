@extends('layouts.app')
@section('title', 'ChanchullApp — Inicio')

@section('content')
<div style="max-width:720px;margin:0 auto;padding:48px 24px 80px;text-align:center">

    <div style="margin-bottom:32px">
        <span class="badge badge--cyan" style="margin-bottom:20px;display:inline-flex">
            <i class="fa-solid fa-microchip" style="font-size:10px"></i> IA Vision &middot; OCR
        </span>
        <h1 class="heading-xl" style="margin-bottom:12px">
            Escanéala, compárala, <span class="gradient-text">ahorrá</span>
        </h1>
        <p style="color:rgba(255,255,255,0.4);font-size:15px;max-width:500px;margin:0 auto;line-height:1.6">
            Sube tu factura del mercado y te decimos en qué tienda puedes conseguir los mismos productos más baratos.
        </p>
    </div>

    @if($auth_logged)
        {{-- DROPZONE para usuarios logueados --}}
        <div id="dropzone" class="dropzone" style="max-width:560px;margin:0 auto">
            <input type="file" id="file-input" accept="image/*" capture="environment" class="hidden">
            <div class="dropzone-icon"><i class="fa-regular fa-image"></i></div>
            <div class="dropzone-hint">
                <div style="font-size:16px;font-weight:600;color:rgba(255,255,255,0.6);margin-bottom:6px">Arrastrá tu factura aquí</div>
                <div style="font-size:13px;color:rgba(255,255,255,0.25)">o hacé clic para abrir la cámara</div>
                <div style="font-size:11px;color:rgba(255,255,255,0.15);margin-top:12px">JPG, PNG &middot; Máx. 10 MB</div>
            </div>
            <img class="dropzone-preview" alt="Vista previa">

            <div id="scan-overlay" class="scan-overlay">
                <div class="scan-beam"></div>
                <div class="scan-ring"></div>
                <div class="scan-status">Preprocesando imagen...</div>
                <div class="scan-progress"><div class="scan-progress-bar"></div></div>
            </div>
        </div>
    @else
        {{-- CARD de login para visitantes --}}
        <div class="card glow-border" style="max-width:500px;margin:0 auto;padding:48px 32px;text-align:center">
            <div style="width:72px;height:72px;border-radius:50%;background:rgba(0,245,212,0.06);border:1px solid rgba(0,245,212,0.12);display:inline-flex;align-items:center;justify-content:center;font-size:28px;color:#00f5d4;margin-bottom:20px">
                <i class="fa-solid fa-lock"></i>
            </div>
            <h2 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:20px;margin-bottom:10px;color:#fff">
                Iniciá sesión para descubrir dónde comprar más barato
            </h2>
            <p style="font-size:14px;color:rgba(255,255,255,0.35);line-height:1.6;margin-bottom:28px">
                Sube tus facturas, compara los precios entre tiendas y ahorrá en cada compra. Nosotros te ayudamos a encontrar los mejores precios.
            </p>
            <div style="display:flex;justify-content:center;gap:12px;flex-wrap:wrap">
                <a href="/login" class="btn btn--primary" style="padding:12px 28px">
                    <i class="fa-solid fa-right-to-bracket"></i> Iniciar Sesión
                </a>
                <a href="/register" class="btn btn--ghost" style="padding:12px 28px">
                    <i class="fa-solid fa-user-plus"></i> Crear Cuenta
                </a>
            </div>
        </div>
    @endif

    <div style="display:flex;justify-content:center;gap:32px;margin-top:48px;flex-wrap:wrap">
        <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:rgba(255,255,255,0.25)">
            <i class="fa-solid fa-shield-halved" style="color:rgba(0,245,212,0.3)"></i> Datos anónimos
        </div>
        <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:rgba(255,255,255,0.25)">
            <i class="fa-solid fa-bolt" style="color:rgba(123,97,255,0.3)"></i> Procesamiento rápido
        </div>
        <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:rgba(255,255,255,0.25)">
            <i class="fa-solid fa-chart-simple" style="color:rgba(255,107,157,0.3)"></i> Comparativa inteligente
        </div>
    </div>
</div>
@endsection
