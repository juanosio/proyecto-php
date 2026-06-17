@extends('layouts.app')
@section('title', 'ChanchullApp — Detalle de Factura')

@section('content')
<div style="max-width:700px;margin:0 auto;padding:32px 24px 80px">

    <div style="margin-bottom:24px">
        <a href="/historial" style="font-size:13px;color:rgba(255,255,255,0.35);text-decoration:none;display:inline-flex;align-items:center;gap:6px">
            <i class="fa-solid fa-arrow-left" style="font-size:11px"></i> Volver al historial
        </a>
    </div>

    <div class="card glow-border" style="padding:32px;margin-bottom:24px">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;margin-bottom:24px">
            <div>
                <div class="label" style="color:#00f5d4;margin-bottom:4px">Factura #{{ $invoice['id'] }}</div>
                <h1 class="heading-lg">{{ $invoice['store'] }}</h1>
            </div>
            <span class="badge {{ strtolower($invoice['status']) === 'procesada' ? 'badge--green' : 'badge--amber' }}">{{ $invoice['status'] }}</span>
        </div>

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:28px">
            <div style="text-align:center;padding:16px;border-radius:12px;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.04)">
                <div class="label">Fecha</div>
                <div style="font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:15px;margin-top:4px">{{ date('d/m/Y', strtotime($invoice['date'])) }}</div>
            </div>
            <div style="text-align:center;padding:16px;border-radius:12px;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.04)">
                <div class="label">Ítems</div>
                <div style="font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:15px;margin-top:4px;color:#7b61ff">{{ $invoice['items_count'] }}</div>
            </div>
            <div style="text-align:center;padding:16px;border-radius:12px;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.04)">
                <div class="label">Total</div>
                <div style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:18px;margin-top:4px;color:#00ff88">${{ number_format($invoice['total'],2) }}</div>
                <div style="font-size:11px;color:rgba(255,255,255,0.2);margin-top:2px">Bs {{ number_format($invoice['total'] * ($bs_rate ?? 592.52), 2, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <div class="card" style="padding:24px">
        <div style="font-size:13px;font-weight:600;color:rgba(255,255,255,0.5);margin-bottom:16px">
            <i class="fa-solid fa-receipt" style="color:#00f5d4;margin-right:6px"></i> Productos escaneados
        </div>
        <table class="gtable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th style="text-align:right">Precio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice['items'] as $idx => $item)
                    <tr>
                        <td style="color:rgba(255,255,255,0.2);font-size:12px">{{ $idx + 1 }}</td>
                        <td style="font-weight:500">{{ $item['name'] }}</td>
                        <td style="text-align:right">
                            <div style="font-family:'Space Grotesk',sans-serif;font-weight:600">${{ number_format($item['price'],2) }}</div>
                            <div style="font-size:11px;color:rgba(255,255,255,0.2)">Bs {{ number_format($item['price'] * ($bs_rate ?? 592.52), 2, ',', '.') }}</div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top:16px;padding-top:16px;border-top:1px solid rgba(255,255,255,0.04);display:flex;justify-content:flex-end;align-items:center;gap:12px">
            <span style="font-size:13px;color:rgba(255,255,255,0.4)">Total</span>
            <div style="text-align:right">
                <span style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:22px;color:#00f5d4">${{ number_format($invoice['total'],2) }}</span>
                <div style="font-size:12px;color:rgba(255,255,255,0.2)">Bs {{ number_format($invoice['total'] * ($bs_rate ?? 592.52), 2, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
