@extends('layouts.app')
@section('title', 'ChanchullApp — Perfil')

@section('content')
<div style="max-width:900px;margin:0 auto;padding:32px 24px 80px">

    <div style="text-align:center;margin-bottom:40px">
        <div class="avatar-ring" style="margin:0 auto 20px">
            <div class="avatar-inner"><i class="fa-solid fa-robot"></i></div>
        </div>
        <h1 class="heading-lg">Tu Perfil</h1>
        <p style="font-size:13px;color:rgba(255,255,255,0.3);margin-top:4px">Resumen de actividad y logros desbloqueados</p>
    </div>

    {{-- Stats rápidos --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:32px">
        <div class="card glow-border" style="padding:20px;text-align:center">
            <div style="font-size:24px;font-family:'Space Grotesk',sans-serif;font-weight:700;color:#00f5d4" data-count="12">0</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.3);margin-top:4px">Facturas escaneadas</div>
        </div>
        <div class="card glow-border" style="padding:20px;text-align:center">
            <div style="font-size:24px;font-family:'Space Grotesk',sans-serif;font-weight:700;color:#7b61ff" data-count="186" data-decimals="0" data-prefix="$">$0</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.3);margin-top:4px">Total analizado</div>
        </div>
        <div class="card glow-border" style="padding:20px;text-align:center">
            <div style="font-size:24px;font-family:'Space Grotesk',sans-serif;font-weight:700;color:#00ff88" data-count="34" data-decimals="0" data-prefix="$">$0</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.3);margin-top:4px">Ahorro acumulado</div>
        </div>
    </div>

    {{-- Badges / Logros --}}
    <div class="card" style="padding:24px;margin-bottom:24px">
        <div style="font-size:13px;font-weight:600;color:rgba(255,255,255,0.5);margin-bottom:20px">
            <i class="fa-solid fa-trophy" style="color:#ffd166;margin-right:6px"></i> Logros
        </div>
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px">
            @foreach($badges ?? [] as $b)
                <div class="badge-achieve {{ $b['unlocked'] ? 'unlocked' : 'locked' }}">
                    <div class="badge-icon" style="color:{{ $b['unlocked'] ? '#00f5d4' : 'rgba(255,255,255,0.15)' }}">
                        <i class="fa-solid {{ $b['icon'] }}"></i>
                    </div>
                    <div class="badge-name">{{ $b['name'] }}</div>
                    <div class="badge-desc">{{ $b['desc'] }}</div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Activity Chart --}}
    <div class="card reveal" style="padding:24px">
        <div style="font-size:13px;font-weight:600;color:rgba(255,255,255,0.5);margin-bottom:16px">
            <i class="fa-solid fa-chart-line" style="color:#00f5d4;margin-right:6px"></i> Actividad de escaneo (7 días)
        </div>
        <div style="height:220px;position:relative">
            <canvas id="activityChart"></canvas>
        </div>
    </div>
</div>
@endsection
