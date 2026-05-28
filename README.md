# chanchullapp 🐙

sistema para normalizar precios de tickets fiscales usando ocr con inteligencia artificial.

---

## requisitos

| herramienta | para que sirve |
|---|---|
| php 8.0 o superior | el lenguaje que ejecuta el sistema |
| composer | descarga librerias de php automaticamente |
| mysql (xampp, mamp, etc.) | la base de datos donde se guarda la informacion |
| tailwind css | (se descarga solo) framework de diseño visual |

---

## instalacion paso a paso

### 1. instalar php y composer

- **windows**: descarga [xampp](https://www.apachefriends.org/) (incluye php y mysql)
- **composer**: descargalo desde [getcomposer.org](https://getcomposer.org/download/)

### 2. abrir la terminal

- **windows**: busca "cmd" o "powershell" en el menu inicio

navega hasta la carpeta del proyecto:

```bash
cd ruta/donde/descargaste/chanchullapp
```

> si no sabes que ruta poner, escribe `cd` y arrastra la carpeta
> a la terminal, luego presiona enter

### 3. instalar las dependencias

```bash
composer install
```

esto hara tres cosas:
1. descarga las librerias php que necesita el sistema
2. descarga automaticamente tailwind css (el binario)
3. prepara todo para funcionar

### 4. configurar la base de datos

copia el archivo `.env.example` y renombralo a `.env`

abrelo con bloc de notas y ajusta estos datos:

```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=chanchullapp
DB_USER=root
DB_PASS=
```

si usas xampp, los valores de arriba ya funcionan sin cambios.

### 5. crear la base de datos

abre xampp y enciende mysql. luego abre phpmyadmin
(http://localhost/phpmyadmin) y crea una base de datos llamada
`chanchullapp`.

### 6. iniciar el servidor

```bash
composer server
```

esto enciende el sistema en http://localhost:8000

abre esa direccion en tu navegador. si ves la pantalla de
"bienvenido a chanchullapp", todo funciona.

### 7. (opcional) activar tailwind

si vas a modificar el diseño, abre otra terminal y corre:

```bash
composer tailwind
```

esto se queda escuchando y compila el css cada vez que guardes
cambios en el html.

---

## como funciona el sistema (diagrama de flujo)

cuando alguien entra a http://localhost:8000, pasa esto:

```
navegador                    servidor php                     base de datos
    │                            │                                │
    │  pide la pagina "/"        │                                │
    │ ─────────────────────────► │                                │
    │                            │                                │
    │                            │  1. public/index.php           │
    │                            │     - lee .env                 │
    │                            │     - conecta mysql            │
    │                            │     - prepara blade (vistas)   │
    │                            │     - prepara el router        │
    │                            │                                │
    │                            │  2. routes/web.php             │
    │                            │     - busca la ruta "/"        │
    │                            │     - la ruta dice:            │
    │                            │       "ejecuta HomeController" │
    │                            │                                │
    │                            │  3. HomeController@index       │
    │                            │     - (opcional) pide datos    │
    │                            │       al modelo ──────────────►│
    │                            │     ◄─── datos de la db ───────│
    │                            │     - renderiza la vista       │
    │                            │       "home" con blade         │
    │                            │                                │
    │  ◄─── html + css + js ─────│                                │
```

---

## estructura del proyecto (explicada)

```
chanchullapp/
│
├── .env                     # tus claves y contraseñas (no se sube a git)
├── .env.example             # ejemplo de .env (para que sepas que poner)
├── composer.json            # configuracion del proyecto php
├── input.css                # archivo base de tailwind
├── tailwindcss              # binario de tailwind (se descarga solo)
│
├── public/                  # lo unico que ve el navegador
│   ├── index.php            # puerta de entrada (front controller)
│   ├── css/
│   │   └── app.css          # tus estilos personalizados
│   ├── js/
│   │   └── app.js           # tus scripts personalizados
│   └── uploads/             # las fotos que suban los usuarios
│
├── app/                     # el codigo php del sistema
│   ├── controllers/         # reciben peticiones y deciden que hacer
│   │   └── HomeController.php
│   └── models/              # hablan con la base de datos
│       ├── Model.php        # clase base (conexion pdo + metodos utiles)
│       └── Product.php      # ejemplo de modelo
│
├── routes/
│   └── web.php              # mapa de rutas (urls del sistema)
│
├── views/                   # las plantillas html
│   ├── layouts/             # el esqueleto general de la pagina
│   │   └── app.blade.php
│   └── home.blade.php       # la pagina de bienvenida
│
├── cache/                   # archivos temporales de blade (no tocar)
└── scripts/                 # scripts auxiliares
    ├── install-tailwind.php # descarga tailwind automaticamente
    └── tailwind.php         # ejecuta tailwind (composer tailwind)
```

---

## como crear una pagina nueva (tutorial paso a paso)

imagina que quieres crear una pagina "productos" que muestre
una lista desde la base de datos.

### paso 1: crear la ruta

abre `routes/web.php` y agrega esta linea:

```php
$router->get('/productos', 'app\controllers\ProductoController@index');
```

esto le dice al sistema: "cuando alguien entre a /productos,
ejecuta el metodo index del controlador ProductoController".

### paso 2: crear el controlador

crea el archivo `app/controllers/ProductoController.php`:

```php
<?php

namespace app\controllers;

use app\models\Producto;

class ProductoController
{
    public function index(): void
    {
        // 1. pedir datos al modelo
        $productos = Producto::getAll();

        // 2. pasar los datos a la vista
        global $blade;
        echo $blade->render('productos/index', [
            'productos' => $productos,
        ]);
    }
}
```

### paso 3: crear el modelo

crea el archivo `app/models/Producto.php`:

```php
<?php

namespace app\models;

class Producto extends Model
{
    protected string $table = 'productos';

    // ya hereda: getAll, getById, create, update, delete
    // aqui agregas metodos personalizados si los necesitas
}
```

### paso 4: crear la vista

crea la carpeta `views/productos/` y dentro el archivo
`views/productos/index.blade.php`:

```html
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold">lista de productos</h1>
    <ul>
        @foreach ($productos as $producto)
            <li>{{ $producto->nombre }} - ${{ $producto->precio }}</li>
        @endforeach
    </ul>
</div>
@endsection
```

### paso 5: probar

entra a http://localhost:8000/productos

si ves la lista, todo funciona.

---

## como manejar imagenes (subida de fotos)

cuando un usuario sube una foto (ej: un ticket), se guarda
en `public/uploads/`.

### ejemplo en un controlador:

```php
public function upload(): void
{
    $archivo = $_FILES['foto'];

    // crear un nombre unico para evitar duplicados
    $nombre = 'ticket_' . time() . '_' . uniqid() . '.' . pathinfo($archivo['name'], PATHINFO_EXTENSION);

    // mover el archivo a la carpeta uploads
    move_uploaded_file($archivo['tmp_name'], __DIR__ . '/../../public/uploads/' . $nombre);

    // guardar la referencia en la base de datos
    // ...
}
```

### para mostrar la foto:

```html
<img src="/uploads/<?= $nombre ?>" alt="ticket">
```

---

## comandos utiles

| comando | que hace |
|---|---|
| `composer server` | inicia el servidor en http://localhost:8000 |
| `composer tailwind` | compila tailwind en modo vigilancia |
| `composer tailwind:build` | compila tailwind una sola vez |
| `composer install` | instala dependencias y descarga tailwind |
| `composer dump-autoload` | refresca el autoload (si creaste nuevas clases) |

---

## problemas comunes

### "no se pudo conectar a mysql"

1. abre xampp y enciende mysql
2. revisa que los datos en `.env` sean correctos
3. asegurate de haber creado la base de datos

### "class not found"

corre este comando para refrescar el autoload:

```bash
composer dump-autoload
```

### pantalla en blanco (sin errores)

abre `.env` y asegurate de tener:

```
APP_ENV=development
APP_DEBUG=true
```

### 404 not found

la ruta que escribiste no existe en `routes/web.php`.
agregala ahi.

### "tailwindcss no se reconoce"

el binario de tailwind no se descargo. corre:

```bash
composer install
```

o descargalo manualmente desde:
https://github.com/tailwindlabs/tailwindcss/releases

---

## consejos finales

- **todo en minusculas y en ingles**: los nombres de carpetas,
  clases, metodos y variables van en ingles y minusculas
  para evitar errores en servidores linux
- **una responsabilidad por archivo**: los controladores solo
  controlan, los modelos solo hablan con la db, las vistas solo
  muestran html. no mezcles logica con diseño
- **usa prepared statements**: nunca concatenes variables en sql.
  el modelo base ya lo hace por ti con `create()`, `update()`,
  `query()` y los marcadores `:parametro`
