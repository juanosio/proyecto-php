@extends('layouts.app')
@section('title', 'ChanchullApp — Canasta Básica')

@section('content')
<div style="max-width:1100px;margin:0 auto;padding:32px 24px 80px">

    <div style="margin-bottom:32px">
        <div class="label" style="color:#00ff88;margin-bottom:4px">Simulador</div>
        <h1 class="heading-lg">Canasta Básica</h1>
        <p style="font-size:13px;color:rgba(255,255,255,0.3);margin-top:4px">Seleccioná los productos que necesitás y conocé el costo estimado</p>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;align-items:start">

        {{-- Columna izquierda: Checklist --}}
        <div class="card" style="padding:24px">
            <div style="font-size:13px;font-weight:600;color:rgba(255,255,255,0.5);margin-bottom:16px">
                <i class="fa-solid fa-list-check" style="color:#00f5d4;margin-right:6px"></i> Productos
            </div>

            {{-- Buscador --}}
            <div class="search-box" style="margin-bottom:14px">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input id="canasta-search" type="text" placeholder="Buscar producto...">
            </div>

            {{-- Filtros de categoría --}}
            <div id="canasta-filters" style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:14px">
                <button class="cat-filter active" data-cat="todos">Todos</button>
                <button class="cat-filter" data-cat="lacteos">Lácteos</button>
                <button class="cat-filter" data-cat="proteinas">Proteínas</button>
                <button class="cat-filter" data-cat="viveres">Víveres</button>
                <button class="cat-filter" data-cat="panaderia">Panadería</button>
                <button class="cat-filter" data-cat="frutas">Frutas</button>
                <button class="cat-filter" data-cat="condimentos">Condimentos</button>
                <button class="cat-filter" data-cat="bebidas">Bebidas</button>
                <button class="cat-filter" data-cat="limpieza">Limpieza</button>
                <button class="cat-filter" data-cat="higiene">Higiene</button>
            </div>

            <div id="canasta-form" style="display:flex;flex-direction:column;gap:8px">
                @foreach($canasta_items ?? [] as $item)
                    <div class="check-item" data-price="{{ $item['price'] }}" data-cat="{{ $item['category'] }}" data-name="{{ strtolower($item['name']) }}">
                        <div class="check-box"></div>
                        <div style="flex:1">
                            <div style="font-size:14px;font-weight:500">{{ $item['name'] }}</div>
                            <div style="font-size:11px;color:rgba(255,255,255,0.25)">{{ ucfirst($item['category']) }}</div>
                        </div>
                        <div style="text-align:right">
                            <div style="font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:14px;color:#00f5d4">${{ number_format($item['price'],2) }}</div>
                            <div style="font-size:10px;color:rgba(255,255,255,0.2)">Bs {{ number_format($item['price'] * ($bs_rate ?? 592.52), 2, ',', '.') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div id="canasta-empty" style="display:none;text-align:center;padding:32px;color:rgba(255,255,255,0.25);font-size:13px">
                No se encontraron productos
            </div>
        </div>

        {{-- Columna derecha: Odómetro + Chart --}}
        <div style="display:flex;flex-direction:column;gap:20px">
            <div class="card glow-border" style="padding:40px;text-align:center">
                <div class="label" style="margin-bottom:16px">Total Estimado</div>
                <div id="canasta-total" class="odometer">$0.00</div>
                <div id="canasta-total-bs" style="font-size:14px;color:rgba(255,255,255,0.25);margin-top:4px;font-family:'Space Grotesk',sans-serif">Bs 0.00</div>
                <div class="odometer-sub">Costo total de la canasta seleccionada</div>
            </div>

            <div class="card" style="padding:24px">
                <div style="font-size:13px;font-weight:600;color:rgba(255,255,255,0.5);margin-bottom:16px">
                    <i class="fa-solid fa-chart-pie" style="color:#7b61ff;margin-right:6px"></i> Distribución
                </div>
                <div style="height:260px;position:relative">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .cat-filter {
        padding: 5px 12px; border-radius: 999px; font-size: 11px; font-weight: 600;
        background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);
        color: rgba(255,255,255,0.4); cursor: pointer; transition: all 0.25s;
    }
    .cat-filter:hover { border-color: rgba(0,245,212,0.2); color: rgba(255,255,255,0.7); }
    .cat-filter.active { background: rgba(0,245,212,0.08); border-color: rgba(0,245,212,0.25); color: #00f5d4; }
</style>
@endsection
