
<h1>{{$modo}} Empleado</h1>

<!-- Se verifica si hay errores -->
@if(count($errors) > 0)
    <div class="alert alert-danger" role="alert">
        <ul>
            <!-- con el foreach y la lista se imprimen en ese formato -->
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    <!-- Va a contener el formulario para registrar y editar -->
    <label for="Nombre" class="">Nombre</label>

    <!-- con value="" se obtiene los valores de la BD, si es que se llama al 
    formulario para editar, los operadores ternarios verifican que exista el valor
    y asignan un valor para las dos posibilidades,

    old('nombreCampo') guarda el valor del input, por si acaso se da enviar antes de haber diligenciado todos los inputs,
    y así no tener que reescribirlos todos cuando la página se refresque o cuando salte el error.

    *Nota: no ocurre la inserción, ya que aun no se han diligenciado correctamente los datos*
    -->
    <input type="text" class="form-control" name="Nombre" id="Nombre" value="{{isset($empleado->Nombre) ? $empleado->Nombre : old('Nombre')}}">
    

    <label for="ApellidoPaterno">ApellidoPaterno</label>
    <input type="text" class="form-control" name="ApellidoPaterno" id="ApellidoPaterno" value="{{isset($empleado->ApellidoPaterno) ? $empleado->ApellidoPaterno : old('ApellidoPaterno')}}">
    

    <label for="ApellidoMaterno">ApellidoMaterno</label>
    <input type="text" class="form-control" name="ApellidoMaterno" id="ApellidoMaterno" value="{{isset($empleado->ApellidoMaterno) ? $empleado->ApellidoMaterno : old('ApellidoMaterno')}}">
    

    <label for="Correo">Correo</label>
    <input type="email" class="form-control" name="Correo" id="Correo" value="{{isset($empleado->Correo) ? $empleado->Correo : old('Correo')}}">
    
    <!-- Se válida que exista la foto -->
    @if(isset($empleado->Foto))
    <!-- Se debe pasar aquí para que se imprima la ruta de la foto -->
    <img src="{{asset('storage').'/'.$empleado->Foto}}" class="img-thumbnail img-fluid" width="100">
    @endif
    <input type="file" class="form-control" name="Foto" id="Foto" value="">
    

    <!-- Se toma el valor enviado por edit y create y dependiendo de 
    su valor se asigna como parte del valor del atributo value="" -->
    <input type="submit" class="btn btn-success mt-3" value="{{$modo}} Datos">
    
</div>
<a href="{{url('/empleado/')}}" class="btn btn-primary mt-3">Regresar</a>
