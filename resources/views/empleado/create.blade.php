@extends('layouts.app')
@section('content')
<div class="container">
<!-- Formulario de creación de empleados
Este archivo agrega de forma automática las etiquetas
que definen un archivo como HTML

enctype="multipart/form-data" permite recibir
archivos como fotos u otros -->

<form method="POST" action="{{url('empleado')}}" enctype="multipart/form-data">
    <!-- Es una llave de seguridad que exige laravel, para saber que este 
        formulario proviene del mismo sistema -->
    @csrf

    <!-- Se incluye el formulario 
        Sintaxis: carpeta.vista
    -->
    @include('empleado.form', ['modo' => 'Crear'])
</form>
@endsection
