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
            Sube tu factura del mercado y te decimos donde puedes conseguir los mismos productos más baratos.
        </p>
    </div>

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
