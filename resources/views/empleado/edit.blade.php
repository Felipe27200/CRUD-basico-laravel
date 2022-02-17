@extends('layouts.app')
@section('content')
<div class="container">
<!-- la variable $empleado es la que se obtiene del método edit() en 
EmpleadoController -->
<form action="{{url('/empleado/'.$empleado->id)}}" method="post" enctype="multipart/form-data">
    @csrf

    <!-- Este método es el que usa empleado.update para modificar un registro.
        Esto se puede visualizar con php artisan rout:list
        en |Method| y en |Name|
    -->
    {{method_field("PATCH")}}

    <!-- Se le envía una variable al form.blade, en
    el segundo argumento, es una array asociado con clave
    modo y valor editar -->
    @include('empleado.form', ['modo' => 'Editar'])
</form>
@endsection
