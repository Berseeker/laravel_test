<?php

namespace App\Http\Controllers\API\Empleados;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use App\Http\Requests\StoreColaboradorRequest;

use App\Models\Empleado;
use App\Models\Empresa;

class EmpleadoController extends ApiController
{
    public function index()
    {
        $empleados = Empleado::all();
        $message = 'Mostrando '.count($empleados).' empleados en total';
        if($empleados->isEmpty())
            $message = 'No hay empleados registrados';

        return $this->successResponse($message,$empleados,200);
    }

    public function byCompany($id)
    {
        $empresa = Empresa::findOrFail($id);

        $empleados = Empleado::where('company_id',$empresa->id)->get();
        $message = 'Mostrando '.count($empleados).' empleados en total';
        if($empleados->isEmpty())
            $message = 'No hay empleados registrados en la compañia '.$empresa->nombre;

        return $this->successResponse($message,$empleados,200);
    }

    public function store(StoreColaboradorRequest $request)
    {
        $validated = $request->validated();
        //dd($validated);

        $empresa = Empresa::findOrFail($validated['company_id']);

        $empleado = new Empleado();
        $empleado->nombre = $validated['nombre'];
        $empleado->apellido = $validated['apellido'];
        $empleado->email = $validated['email'];
        $empleado->telefono = $validated['telefono'];
        $empleado->company_id = $empresa->id;
        $empleado->save();

        return $this->successResponse('El empleado se dio de alta con exito',$empleado,201);
    }

    public function update(StoreColaboradorRequest $request,$id)
    {
        $validated = $request->validated();

        $empresa = Empresa::findOrFail($validated['company_id']);

        $empleado = Empleado::findOrFail($id);
        $empleado->nombre = $validated['nombre'];
        $empleado->apellido = $validated['apellido'];
        $empleado->email = $validated['email'];
        $empleado->telefono = $validated['telefono'];
        $empleado->company_id = $empresa->id;
        $message = 'El empleado se dio de alta con exito';
        if($empleado->isDirty())
        {
            $empleado->save();
            $message = "No hay nada que modificar";
        }
        
        return $this->successResponse($message,$empleado,201);
    }

    public function delete($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();

        return $this->successResponse('El empleado se dio de baja satisfactoriamente',NULL,200);
    }
}
