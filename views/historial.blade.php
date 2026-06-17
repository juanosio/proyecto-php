@extends('layouts.app')
@section('title', 'ChanchullApp — Historial')

@section('content')
<div style="max-width:900px;margin:0 auto;padding:32px 24px 80px">

    <div style="margin-bottom:32px">
        <div class="label" style="color:#7b61ff;margin-bottom:4px">Auditoría</div>
        <h1 class="heading-lg">Historial de Facturas</h1>
        <p style="font-size:13px;color:rgba(255,255,255,0.3);margin-top:4px">{{ count($invoices ?? []) }} facturas procesadas</p>
    </div>

    <div class="timeline">
        @forelse($invoices ?? [] as $i => $inv)
            <div style="margin-bottom:20px" class="reveal">
                <div class="tl-dot {{ $i % 3 === 1 ? 'tl-dot--violet' : ($i % 3 === 2 ? 'tl-dot--rose' : '') }}"></div>
                <a href="/historial/{{ $inv['id'] }}" style="text-decoration:none;color:inherit">
                    <div class="card glow-border" style="padding:20px;cursor:pointer">
                        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px">
                            <div>
                                <div style="font-weight:600;font-size:15px">
                                    {{ $inv['store'] }}
                                    <span style="font-size:12px;color:rgba(255,255,255,0.3);font-weight:400;margin-left:6px">{{ date('d M Y', strtotime($inv['date'])) }}</span>
                                </div>
                                <div style="font-size:13px;color:rgba(255,255,255,0.35);margin-top:2px">
                                    {{ $inv['items_count'] }} ítems &middot; ${{ number_format($inv['total'],2) }}
                                    <span style="font-size:11px;color:rgba(255,255,255,0.18)">Bs {{ number_format($inv['total'] * ($bs_rate ?? 592.52), 2, ',', '.') }}</span>
                                </div>
                            </div>
                            <div style="display:flex;align-items:center;gap:10px">
                                <span class="badge {{ strtolower($inv['status']) === 'procesada' ? 'badge--green' : 'badge--amber' }}">{{ $inv['status'] }}</span>
                                <i class="fa-solid fa-chevron-right" style="color:rgba(255,255,255,0.15);font-size:12px"></i>
                            </div>
                        </div>
                        @if(!empty($inv['products']))
                            <div style="display:flex;flex-wrap:wrap;gap:6px;margin-top:12px">
                                @foreach($inv['products'] as $prod)
                                    <span style="font-size:11px;padding:4px 10px;border-radius:999px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.04);color:rgba(255,255,255,0.3)">{{ $prod }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </a>
            </div>
        @empty
            <div class="card" style="padding:48px;text-align:center;color:rgba(255,255,255,0.3)">
                <i class="fa-regular fa-clock" style="font-size:32px;display:block;margin-bottom:12px;opacity:0.3"></i>
                No hay facturas registradas
            </div>
        @endforelse
    </div>
</div>
@endsection
