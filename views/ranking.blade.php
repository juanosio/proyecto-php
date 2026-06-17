@extends('layouts.app')
@section('title', 'ChanchullApp — Ranking de Comercios')

@section('content')
<div style="max-width:1100px;margin:0 auto;padding:32px 24px 80px">

    <div style="margin-bottom:32px">
        <div class="label" style="color:#ff6b9d;margin-bottom:4px">Directorio</div>
        <h1 class="heading-lg">Ranking de Comercios</h1>
        <p style="font-size:13px;color:rgba(255,255,255,0.3);margin-top:4px">Los locales más escaneados por la comunidad</p>
    </div>

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px">
        @foreach($stores ?? [] as $store)
            <div class="card rank-card glow-border reveal">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                    <div style="width:40px;height:40px;border-radius:10px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:center">
                        <i class="fa-solid fa-store" style="color:{{ $store['temp'] === 'green' ? '#00ff88' : ($store['temp'] === 'amber' ? '#ffd166' : '#ff6b6b') }};font-size:14px"></i>
                    </div>
                    <span class="badge {{ $store['temp'] === 'green' ? 'badge--green' : ($store['temp'] === 'amber' ? 'badge--amber' : 'badge--red') }}">
                        {{ $store['temp'] === 'green' ? 'Económico' : ($store['temp'] === 'amber' ? 'Regular' : 'Caro') }}
                    </span>
                </div>
                <div class="rank-name">{{ $store['name'] }}</div>
                <div class="rank-count">{{ $store['count'] }} facturas escaneadas</div>
                <div class="thermometer">
                    <div class="thermometer-fill thermometer-fill--{{ $store['temp'] }}" style="width:{{ $store['score'] }}%"></div>
                </div>
                <div style="font-size:11px;color:rgba(255,255,255,0.2);margin-top:8px">
                    Puntuación: {{ $store['score'] }}/100
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
