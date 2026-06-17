<?php

namespace app\controllers;

class HomeController
{
    private const BS_RATE = 592.52;

    private function bs(float $usd): string
    {
        return number_format($usd * self::BS_RATE, 2, ',', '.');
    }

    public function index(): void
    {
        global $blade;
        echo $blade->render('home');
    }

    public function dashboard(): void
    {
        global $blade;
        $bs = self::BS_RATE;
        $products = [
            ['name' => 'Leche Entera 1L', 'price' => 2.30, 'store' => 'Farmatodo', 'cheaper_store' => 'Excelsior Gama', 'cheaper_price' => 2.10],
            ['name' => 'Pan de Sandwich Bimbo 500g', 'price' => 3.00, 'store' => 'Excelsior Gama', 'cheaper_store' => 'Farmatodo', 'cheaper_price' => 2.75],
            ['name' => 'Arroz Mary 1kg', 'price' => 1.50, 'store' => 'Bodega La Economía', 'cheaper_store' => 'Abasto Don Pedro', 'cheaper_price' => 1.35],
            ['name' => 'Aceite de Girasol 900ml', 'price' => 4.70, 'store' => 'Farmatodo', 'cheaper_store' => 'Excelsior Gama', 'cheaper_price' => 4.40],
            ['name' => '1/2 Cartón de Huevos', 'price' => 4.30, 'store' => 'Abasto Don Pedro', 'cheaper_store' => null, 'cheaper_price' => null],
            ['name' => 'Yogur YOLO Natural 500g', 'price' => 6.00, 'store' => 'Excelsior Gama', 'cheaper_store' => 'Farmatodo', 'cheaper_price' => 5.50],
            ['name' => 'Queso Llanero 250g', 'price' => 3.50, 'store' => 'Farmatodo', 'cheaper_store' => 'Bodega La Economía', 'cheaper_price' => 3.20],
            ['name' => 'Spaghetti Sindoni 500g', 'price' => 1.70, 'store' => 'Excelsior Gama', 'cheaper_store' => 'Abasto Don Pedro', 'cheaper_price' => 1.55],
        ];
        echo $blade->render('dashboard', ['products' => $products, 'bs_rate' => $bs]);
    }

    public function historial(): void
    {
        global $blade;
        $bs = self::BS_RATE;
        $invoices = [
            ['id' => 1, 'date' => '2026-06-15', 'store' => 'Farmatodo', 'items_count' => 12, 'total' => 42.50, 'status' => 'Procesada', 'products' => ['Leche', 'Pan', 'Arroz', 'Aceite', 'Huevos']],
            ['id' => 2, 'date' => '2026-06-10', 'store' => 'Excelsior Gama', 'items_count' => 8, 'total' => 31.80, 'status' => 'Procesada', 'products' => ['Pollo', 'Carne Molida', 'Queso', 'Café']],
            ['id' => 3, 'date' => '2026-06-05', 'store' => 'Bodega La Economía', 'items_count' => 15, 'total' => 55.40, 'status' => 'Procesada', 'products' => ['Arroz', 'Azúcar', 'Sal', 'Aceite', 'Mayonesa']],
            ['id' => 4, 'date' => '2026-05-28', 'store' => 'Abasto Don Pedro', 'items_count' => 6, 'total' => 18.70, 'status' => 'Pendiente', 'products' => ['Sardinas', 'Jabón', 'Papel']],
            ['id' => 5, 'date' => '2026-05-20', 'store' => 'Farmatodo', 'items_count' => 10, 'total' => 38.90, 'status' => 'Procesada', 'products' => ['Pañales', 'Pasta Dental', 'Cepillo', 'Bolsas']],
        ];
        echo $blade->render('historial', ['invoices' => $invoices, 'bs_rate' => $bs]);
    }

    public function historialDetalle($id): void
    {
        global $blade;
        $bs = self::BS_RATE;
        $allInvoices = [
            1 => [
                'id' => 1, 'date' => '2026-06-15', 'store' => 'Farmatodo', 'items_count' => 12, 'total' => 42.50, 'status' => 'Procesada',
                'items' => [
                    ['name' => 'Leche Entera 1L', 'price' => 2.30],
                    ['name' => 'Pan de Sandwich Bimbo 500g', 'price' => 3.00],
                    ['name' => 'Arroz Mary 1kg', 'price' => 1.50],
                    ['name' => 'Aceite de Girasol 900ml', 'price' => 4.70],
                    ['name' => '1/2 Cartón de Huevos', 'price' => 4.30],
                    ['name' => 'Queso Llanero 250g', 'price' => 3.50],
                    ['name' => 'Spaghetti Sindoni 500g', 'price' => 1.70],
                    ['name' => 'Yogur YOLO Natural 500g', 'price' => 6.00],
                    ['name' => 'Café Amanecer 250g', 'price' => 3.00],
                    ['name' => 'Azúcar Motalban 1kg', 'price' => 1.50],
                    ['name' => 'Jabón para Lavar 500ml', 'price' => 7.00],
                    ['name' => 'Sal 1kg', 'price' => 0.90],
                ],
            ],
            2 => [
                'id' => 2, 'date' => '2026-06-10', 'store' => 'Excelsior Gama', 'items_count' => 8, 'total' => 31.80, 'status' => 'Procesada',
                'items' => [
                    ['name' => 'Pollo 1kg', 'price' => 6.00],
                    ['name' => 'Carne Molida 1kg', 'price' => 12.00],
                    ['name' => 'Leche Entera 1L', 'price' => 2.30],
                    ['name' => 'Queso Llanero 250g', 'price' => 3.50],
                    ['name' => 'Café La Nona 250g', 'price' => 3.00],
                    ['name' => 'Cambur 1kg', 'price' => 1.40],
                    ['name' => 'Salsa de Tomate Pampero', 'price' => 2.00],
                    ['name' => 'Mayonesa Mavesa 500g', 'price' => 5.50],
                ],
            ],
            3 => [
                'id' => 3, 'date' => '2026-06-05', 'store' => 'Bodega La Economía', 'items_count' => 15, 'total' => 55.40, 'status' => 'Procesada',
                'items' => [
                    ['name' => 'Arroz Mary 1kg', 'price' => 1.50],
                    ['name' => 'Azúcar Motalban 1kg', 'price' => 1.50],
                    ['name' => 'Sal 1kg', 'price' => 0.90],
                    ['name' => 'Aceite de Girasol 900ml', 'price' => 4.70],
                    ['name' => 'Mayonesa Kraft 500g', 'price' => 6.50],
                    ['name' => 'Salsa de Tomate Heinz', 'price' => 2.20],
                    ['name' => 'Mostaza 200g', 'price' => 2.00],
                    ['name' => 'Spaghetti Sindoni 500g', 'price' => 1.70],
                    ['name' => 'Lata de Sardinas', 'price' => 0.70],
                    ['name' => 'Café Madrid 250g', 'price' => 3.00],
                    ['name' => 'Pan de Sandwich Bimbo 500g', 'price' => 3.00],
                    ['name' => 'Leche Entera 1L', 'price' => 2.30],
                    ['name' => 'Huevos 1/2 Cartón', 'price' => 4.30],
                    ['name' => 'Jabón para Usar x3', 'price' => 4.00],
                    ['name' => 'Pasta Dental Colgate', 'price' => 5.00],
                ],
            ],
            4 => [
                'id' => 4, 'date' => '2026-05-28', 'store' => 'Abasto Don Pedro', 'items_count' => 6, 'total' => 18.70, 'status' => 'Pendiente',
                'items' => [
                    ['name' => 'Lata de Sardinas x2', 'price' => 1.40],
                    ['name' => 'Jabón para Lavar 500ml', 'price' => 7.00],
                    ['name' => 'Papel Higiénico x4', 'price' => 4.00],
                    ['name' => 'Bolsas de Basura x30', 'price' => 5.00],
                    ['name' => 'Cepillo de Dientes', 'price' => 3.00],
                    ['name' => 'Pasta Dental Colgate', 'price' => 5.00],
                ],
            ],
            5 => [
                'id' => 5, 'date' => '2026-05-20', 'store' => 'Farmatodo', 'items_count' => 10, 'total' => 38.90, 'status' => 'Procesada',
                'items' => [
                    ['name' => 'Pañales Pampers x24', 'price' => 4.00],
                    ['name' => 'Pañales Farmatodo x24', 'price' => 4.00],
                    ['name' => 'Pasta Dental Colgate', 'price' => 5.00],
                    ['name' => 'Cepillo de Dientes', 'price' => 3.00],
                    ['name' => 'Bolsas de Basura x30', 'price' => 5.00],
                    ['name' => 'Papel Higiénico x6', 'price' => 6.00],
                    ['name' => 'Jabón para Usar x4', 'price' => 4.00],
                    ['name' => 'Jabón para Lavar 500ml', 'price' => 7.00],
                    ['name' => 'Sal 1kg', 'price' => 0.90],
                    ['name' => 'Azúcar Motalban 1kg', 'price' => 1.50],
                ],
            ],
        ];

        $invoice = $allInvoices[(int)$id] ?? null;
        if (!$invoice) {
            header('Location: /historial');
            exit;
        }

        echo $blade->render('historial-detalle', ['invoice' => $invoice, 'bs_rate' => $bs]);
    }

    public function canasta(): void
    {
        global $blade;
        $bs = self::BS_RATE;
        $canasta_items = [
            ['name' => 'Leche Entera 1L', 'price' => 2.30, 'category' => 'lacteos'],
            ['name' => 'Yogur YOLO Natural 500g', 'price' => 6.00, 'category' => 'lacteos'],
            ['name' => 'Queso Llanero 250g', 'price' => 3.50, 'category' => 'lacteos'],
            ['name' => 'Pan de Sandwich Bimbo 500g', 'price' => 3.00, 'category' => 'panaderia'],
            ['name' => 'Arroz Mary 1kg', 'price' => 1.50, 'category' => 'viveres'],
            ['name' => 'Spaghetti Sindoni 500g', 'price' => 1.70, 'category' => 'viveres'],
            ['name' => 'Aceite de Girasol 900ml', 'price' => 4.70, 'category' => 'viveres'],
            ['name' => 'Café Amanecer 250g', 'price' => 3.00, 'category' => 'viveres'],
            ['name' => 'Azúcar Motalban 1kg', 'price' => 1.50, 'category' => 'viveres'],
            ['name' => 'Sal 1kg', 'price' => 0.90, 'category' => 'viveres'],
            ['name' => '1/2 Cartón de Huevos', 'price' => 4.30, 'category' => 'proteinas'],
            ['name' => 'Pollo 1kg', 'price' => 6.00, 'category' => 'proteinas'],
            ['name' => 'Carne Molida 1kg', 'price' => 12.00, 'category' => 'proteinas'],
            ['name' => 'Lata de Sardinas', 'price' => 0.70, 'category' => 'proteinas'],
            ['name' => 'Cambur 1kg', 'price' => 1.40, 'category' => 'frutas'],
            ['name' => 'Salsa de Tomate Pampero', 'price' => 2.00, 'category' => 'condimentos'],
            ['name' => 'Mostaza 200g', 'price' => 2.00, 'category' => 'condimentos'],
            ['name' => 'Mayonesa Mavesa 500g', 'price' => 5.50, 'category' => 'condimentos'],
            ['name' => 'Agua 1.5L x6', 'price' => 4.50, 'category' => 'bebidas'],
            ['name' => 'Refresco Glup 2L', 'price' => 3.00, 'category' => 'bebidas'],
            ['name' => 'Jugo en Polvo x10', 'price' => 1.80, 'category' => 'bebidas'],
            ['name' => 'Jabón para Lavar 500ml', 'price' => 7.00, 'category' => 'limpieza'],
            ['name' => 'Bolsas de Basura x30', 'price' => 5.00, 'category' => 'limpieza'],
            ['name' => 'Detergente 1L', 'price' => 4.50, 'category' => 'limpieza'],
            ['name' => 'Esponjas x3', 'price' => 1.50, 'category' => 'limpieza'],
            ['name' => 'Jabón para Usar x3', 'price' => 4.00, 'category' => 'higiene'],
            ['name' => 'Pasta Dental Colgate', 'price' => 5.00, 'category' => 'higiene'],
            ['name' => 'Cepillo de Dientes', 'price' => 3.00, 'category' => 'higiene'],
            ['name' => 'Papel Higiénico x4', 'price' => 4.00, 'category' => 'higiene'],
            ['name' => 'Pañales Pampers x24', 'price' => 4.00, 'category' => 'higiene'],
        ];
        echo $blade->render('canasta', ['canasta_items' => $canasta_items, 'bs_rate' => $bs]);
    }

    public function ranking(): void
    {
        global $blade;
        $stores = [
            ['name' => 'Bodega La Economía', 'count' => 145, 'temp' => 'green', 'score' => 91],
            ['name' => 'Abasto Don Pedro', 'count' => 132, 'temp' => 'green', 'score' => 88],
            ['name' => 'Farmatodo', 'count' => 118, 'temp' => 'green', 'score' => 82],
            ['name' => 'Excelsior Gama', 'count' => 98, 'temp' => 'amber', 'score' => 65],
            ['name' => 'Kiosco El Pana', 'count' => 76, 'temp' => 'amber', 'score' => 55],
            ['name' => 'Supermercado X', 'count' => 54, 'temp' => 'red', 'score' => 30],
        ];
        echo $blade->render('ranking', ['stores' => $stores]);
    }

    public function perfil(): void
    {
        global $blade;
        $badges = [
            ['name' => 'Primer Escaneo', 'desc' => 'Subiste tu primera factura', 'icon' => 'fa-camera', 'unlocked' => true],
            ['name' => 'Cazador de Ofertas', 'desc' => 'Escaneaste 5 facturas', 'icon' => 'fa-magnifying-glass-dollar', 'unlocked' => true],
            ['name' => 'Auditor Maestro', 'desc' => 'Ahorraste más de $10', 'icon' => 'fa-award', 'unlocked' => true],
            ['name' => 'Frecuente', 'desc' => '10 facturas procesadas', 'icon' => 'fa-fire', 'unlocked' => true],
            ['name' => 'Ahorrador Pro', 'desc' => 'Ahorraste más de $50', 'icon' => 'fa-piggy-bank', 'unlocked' => false],
            ['name' => 'Experto en Precios', 'desc' => '25 facturas procesadas', 'icon' => 'fa-graduation-cap', 'unlocked' => false],
            ['name' => 'Leyenda', 'desc' => '100 facturas procesadas', 'icon' => 'fa-crown', 'unlocked' => false],
            ['name' => 'Comunidad', 'desc' => 'Compartiste un ranking', 'icon' => 'fa-share-nodes', 'unlocked' => false],
        ];
        echo $blade->render('perfil', ['badges' => $badges]);
    }
}
