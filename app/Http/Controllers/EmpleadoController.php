<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

// Clase necesaria para eliminar la foto
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Se va a consultar la información en la fuente
        Empleado y se van a tomar los 5 primeros registros */
        $datos['empleados'] = Empleado::paginate(1);

        // El segundo argumento son los datos que se le 
        // envían a esa vista, en caso contrario no 
        // obtendría a los datos de Empleado
        return view('empleado.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /* Se le está dando al controlador la información de la vista,
        de esta forma cuando se invoque create() retornará a la vista*/
        return view('empleado.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /* Recibe toda la información para almacenarla directamente en la BD
     o para acceder a esta y almacenar la información*/
    public function store(Request $request)
    {
        // VALIDAR QUE LOS CAMPOS NO ESTÉN VACÍOS

        // Se define que campos se van a validar
        $campos = [
            'Nombre' => 'required|string|max:100',
            'ApellidoPaterno' => 'required|string|max:100',
            'ApellidoMaterno' => 'required|string|max:100',
            'Correo' => 'required|email',
            'Foto' => 'required||max:10000|mimes:jpeg,png,jpg'
        ];

        // Mostrar mensajes de error en caso de que un campo no sea diligenciado
        $mensaje = [
            // Mensaje para todos los required
            // :attribute es un comodín que permite traer el nombre
            // del atributo requerido que no fue diligenciado
            'required' => 'El :attribute es requerido',

            // Este es para el caso específico en el que campo foto no sea diligenciado
            'Foto.required' => 'La foto es requerida'
        ];

        // Aquí se indica que todo lo que se esta enviando, representado por el request
        // sea validado según los $campos y que muestre los mensajes
        $this->validate($request, $campos, $mensaje);

        // Así obtiene todos los datos del empleado
        // $datosEmpleado = request()->all();

        // Para quitar el token (security key) se usa el método except()
        $datosEmpleado = request()->except('_token');

        /* Para recibir la foto, hay que comprobar si se recibio en ese
        campo un archivo */
        if ($request->hasFile('Foto'))
        {
            /* en el método file() se obtiene la ruta del archivo y en store(), se define
             que se guardará en el storage en la carpeta \public y esa ruta se la asigna la elemento
             ['Foto'], la ruta en que se guarda la imagen es sistema\storage\app\public\uploads
             en caso de que la carpeta \uploads no exista, esta se creara.
             */
            $datosEmpleado['Foto'] = $request->file('Foto')->store('uploads', 'public');
        }

        /* Para insertarlo en la BD se usa el método insert() de la clase 
        Empleado en la carpeta Models, el DTO */
        Empleado::insert($datosEmpleado);

        // Así se retornan todos los datos del empleado
        //return response()->json($datosEmpleado);

        // Se redirecciona al index y se le envía una variable con un mensaje
        return redirect('empleado')->with('mensaje', 'Empleado agregado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */

    // Recibe los datos que se van a editar
    // y los retorna para poder ser modificados
    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        /* Se debe definir la vista a la que 
        se redirigira cuando entre al método */
        // return view('empleado.edit');

        return view('empleado.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */

    // Este método es quien realiza la modificación de los datos
    // recibidos mediante edit()
    public function update(Request $request, $id)
    {
        $campos = [
            'Nombre' => 'required|string|max:100',
            'ApellidoPaterno' => 'required|string|max:100',
            'ApellidoMaterno' => 'required|string|max:100',
            'Correo' => 'required|email',
        ];

        $mensaje = [
            'required' => 'El :attribute es requerido',
        ];

        // Se válida si había una foto previamente
        if ($request->hasFile('Foto'))
        {
            // En caso de que exista se agrega la validación de la misma
            $campos = ['Foto' => 'required||max:10000|mimes:jpeg,png,jpg'];
            
            // Se añade el mensaje de error
            $mensaje = ['Foto.required' => 'La foto es requerida'];
        }

        $this->validate($request, $campos, $mensaje);

        // Es para que no incluya el método PATCH en los valores
        //  para $datosEmpleado
        $datosEmpleado = request()->except(['_token', '_method']);

        /* Se verifica si se ha ingresado una fotografía para actualizar */
        if ($request->hasFile('Foto'))
        {
            // Se verifica que haya un empleado con el id
            $empleado = Empleado::findOrFail($id);

            // Si lo hay se establece que se elimara la foto de ese empleado
            // Esto gracias a la clase importada Storage
            Storage::delete('public/'.$empleado->Foto);

            /* Si se ha recibido una foto se asigna la nueva foto a $datosEmpleado,
            si no se pone la foto, se inserta la que ya estaba */
            $datosEmpleado['Foto'] = $request->file('Foto')->store('uploads', 'public');
        }

        /* Se va a usar el modelo Empleado*/

        /* Se le indica que busque el registro con es id y
        si lo encuentra entonces que lo modifique con los datos
        en $datosEmpleado */
        Empleado::where('id','=', $id)->update($datosEmpleado);

        $empleado = Empleado::findOrFail($id);
        // return view('empleado.edit', compact('empleado'));

        return redirect('empleado')->with('mensaje', 'Empleado Modificado');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */

    /* Se define que el método debe recibir el id de un registro */
    public function destroy($id)
    {
        /* Eliminar la foto de un usuario */
        $empleado = Empleado::findOrFail($id);

        // Se verifica si ya se elimino el registro de la foto (Se elimina de la carpeta \uploads)
        if (Storage::delete('public/'.$empleado->Foto))
        {
            /* Si es así, entonces, ya se puede eliminar el registro de la BD */
            Empleado::destroy($id);
        }
        
        /* Usando el id se invoca al método destroy() de Empleado
        para que busque el registro con ese id y lo elimine */
        
        // Después se le indica la vista a la que debe redireccionar
        return redirect('empleado')->with('mensaje', 'Empleado Borrado');
    }
}
