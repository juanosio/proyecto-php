@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-md">

    <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">
        bienvenido a chanchullapp
    </h1>

    <p class="text-gray-600 mt-2">
        sube la captura de tu ticket fiscal para normalizar y comparar productos automaticamente.
    </p>

    <div class="mt-6 p-4 border-2 border-dashed border-gray-300 rounded-md text-center">
        <span class="text-sm text-gray-500 block mb-4">
            el area interactiva del frontend va en esta seccion
        </span>
        <button class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded shadow">
            simular carga de factura
        </button>
    </div>

</div>
@endsection
