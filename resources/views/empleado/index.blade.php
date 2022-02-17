<!-- Se aplica el template de \views\layouts\app.blade.php 
de esta forma se aplican los estilos de bootstrap a esta pág.-->
@extends('layouts.app')

<!-- Establece que todo lo que esté dentro de las etiquetas
corresponde a esa sección -->
@section('content')
<div class="container">
    <!-- Se verifica si hay un mensaje o variable creada
    durante la sesión -->
    @if(Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
            <!-- Se imprime el mensaje si existe -->
            {{Session::get('mensaje')}}
        </div>    
    @endif

    <a href="{{url('/empleado/create')}}" class="btn btn-success mb-2">Registrar Nuevo Empleado</a>
    <br>

    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- $empleado hace referencia al elemento de $datos['empleado'] -->
            @foreach($empleados as $empleado)
            <tr>
                <!-- Las variabels deben coincidir con los nombres en la BD -->
                <td>{{$empleado->id}}</td>
                <td>
                    <!-- asset() nos da el acceso al deposito storage que contiene la foto -->
                    <img class="img-thumbnail img-fluid" src="{{asset('storage').'/'.$empleado->Foto}}" width="100" alt=""> 
                </td>
                <td>{{$empleado->Nombre}}</td>
                <td>{{$empleado->ApellidoPaterno}}</td>
                <td>{{$empleado->ApellidoMaterno}}</td>
                <td>{{$empleado->Correo}}</td>
                <td>
                    <!-- Se debe hacer una concatenación más, para que redirecciones
                    a la vista edit.blade.php -->
                    <a href="{{url('/empleado/'.$empleado->id.'/edit')}}" class="btn btn-primary"> Editar </a>

                    |
                    <!-- El formulario contiene un input:submit que al ser clickeado
                    enviara la ejecución al empleado junto con el id para eliminar el dato -->
                    <form method="post" action="{{url('/empleado/'.$empleado->id)}}" class="d-inline">
                        <!-- Laravel siempre exige la llave, para evitar que cualquier formulario
                        tenga acceso a la BD -->
                        @csrf

                        <!-- El borrado se hace mediante el método destroy(), 
                        pero destruy() usa el método DELETE y no el método POST.

                        De esta forma se crea un método que se encarga de llamar 
                        al método DELETE para que acepte los valores enviados mediante POST-->
                        {{method_field("DELETE")}}

                        <!-- El onclik="" mostrará una alert() para que el usuario confirme si
                            desea eliminar o no -->
                        <input type="submit" onclick="return confirm('¿Quieres Borrar?');" value="Borrar" class="btn btn-danger">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- indica que todos los registros de $empleados 
    los va a mostrar paginados o en links -->
    {!! $empleados->links() !!}
</div>
<!-- Finaliza la sección -->
@endsection