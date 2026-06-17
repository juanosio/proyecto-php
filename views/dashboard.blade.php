@extends('layouts.app')
@section('title', 'ChanchullApp — Dashboard')

@section('content')
<div style="max-width:1100px;margin:0 auto;padding:32px 24px 80px">

    <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:32px;flex-wrap:wrap;gap:12px">
        <div>
            <div class="label" style="color:#00f5d4;margin-bottom:4px">Dashboard</div>
            <h1 class="heading-lg">Resultados y Ranking</h1>
            <p style="font-size:13px;color:rgba(255,255,255,0.3);margin-top:4px">Factura procesada el {{ date('d/m/Y') }}</p>
        </div>
        <a href="/" class="btn btn--primary"><i class="fa-solid fa-plus" style="font-size:12px"></i> Nueva factura</a>
    </div>

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:32px">
        <div class="card glow-border stat-card reveal">
            <div class="stat-icon stat-icon--cyan"><i class="fa-solid fa-wallet"></i></div>
            <div class="label">Total Gastado</div>
            <div class="value-xl gradient-text" style="margin-top:6px" data-count="42.50" data-prefix="$" data-decimals="2">$0.00</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.2);margin-top:4px">Bs {{ number_format(42.50 * ($bs_rate ?? 592.52), 2, ',', '.') }}</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.2);margin-top:2px">Últimos 30 días</div>
        </div>
        <div class="card glow-border stat-card reveal">
            <div class="stat-icon stat-icon--violet"><i class="fa-solid fa-cubes"></i></div>
            <div class="label">Ítems Leídos</div>
            <div class="value-xl" style="margin-top:6px;color:#7b61ff" data-count="47" data-suffix="">0</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.2);margin-top:8px">Productos normalizados</div>
        </div>
        <div class="card glow-border stat-card reveal">
            <div class="stat-icon stat-icon--rose"><i class="fa-solid fa-piggy-bank"></i></div>
            <div class="label">Ahorro Potencial</div>
            <div class="value-xl" style="margin-top:6px;color:#00ff88" data-count="6.80" data-prefix="$" data-decimals="2">$0.00</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.2);margin-top:4px">Bs {{ number_format(6.80 * ($bs_rate ?? 592.52), 2, ',', '.') }}</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.2);margin-top:2px">16% del total</div>
        </div>
    </div>

    <div class="search-box" style="margin-bottom:24px">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input id="search-input" type="text" placeholder="Buscá un producto...">
    </div>

    <div class="card reveal" style="overflow:hidden">
        <div style="padding:16px 20px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(255,255,255,0.04)">
            <span style="font-size:13px;font-weight:600;color:rgba(255,255,255,0.6)"><i class="fa-solid fa-receipt" style="color:#00f5d4;margin-right:8px"></i>Productos detectados</span>
            <span style="font-size:11px;color:rgba(255,255,255,0.25)">{{ count($products ?? []) }} ítems</span>
        </div>
        <div style="overflow-x:auto">
            <table class="gtable">
                <thead>
                    <tr>
                        <th>Producto</th><th>Precio</th><th>Tienda</th><th>Más barato en</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products ?? [] as $p)
                        <tr>
                            <td style="font-weight:500">{{ $p['name'] }}</td>
                            <td>
                                <div style="font-family:'Space Grotesk',sans-serif;font-weight:600">${{ number_format($p['price'],2) }}</div>
                                <div style="font-size:11px;color:rgba(255,255,255,0.2)">Bs {{ number_format($p['price'] * ($bs_rate ?? 592.52), 2, ',', '.') }}</div>
                            </td>
                            <td style="color:rgba(255,255,255,0.45)">{{ $p['store'] }}</td>
                            <td>
                                @if($p['cheaper_store'] && $p['cheaper_price'] < $p['price'])
                                    <span class="badge badge--green"><i class="fa-solid fa-bolt" style="font-size:10px"></i> {{ $p['cheaper_store'] }} — ${{ number_format($p['cheaper_price'],2) }}</span>
                                @else
                                    <span style="color:rgba(255,255,255,0.15)">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="text-align:center;padding:48px;color:rgba(255,255,255,0.25)">No hay productos para mostrar</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
