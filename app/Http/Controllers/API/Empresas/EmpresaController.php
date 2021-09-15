<?php

namespace App\Http\Controllers\API\Empresas;

use App\Http\Controllers\ApiController;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use App\Models\Empresa;

#Form Request
use App\Http\Requests\StoreEmpresaRequest;

class EmpresaController extends ApiController
{
    public function index()
    {
        $empresas = Empresa::all();

        foreach ($empresas as $empresa) {
            $empresa->logotipo = Storage::url($empresa->logotipo);
        }

        $message = 'Mostrando '.count($empresas).' empresas solicitadas';
        if($empresas->isEmpty())
            $message = 'No hay empresas registradas';

        return $this->successResponse($message,$empresas,200);
    }

    public function show($id)
    {
        $empresa = Empresa::findOrFail($id);

        return $this->successResponse('Mostrando la empresa solicitada',$empresa,200);
    }

    public function store(StoreEmpresaRequest $request)
    {
        $validated = $request->validated();
        $path = NULL;
        
        $empresa = new Empresa();
        $empresa->nombre = $validated['nombre'];
        if(Arr::exists($validated, 'logo')){
            $file = $validated['logo'];
            $path = $file->store(
                'logos/'.Auth::user()->id, 'public'
            ); 
        }
        $empresa->logotipo = $path;
        $empresa->email = $validated['email'];
        $empresa->sitioweb = (Arr::exists($validated, 'sitio_web')) ? $validated['sitio_web'] : 'http://google.com.mx';
        $empresa->save();

        return $this->successResponse('La empresa se creó con exito',$empresa,201);

    }

    public function update(StoreEmpresaRequest $request,$id)
    {
        $validated = $request->validated();
        
        $empresa = Empresa::findOrFail($id);
        $empresa->nombre = $validated['nombre'];
        $prevPath = $empresa->logotipo;
        $path = $empresa->logotipo;

        if(Arr::exists($validated, 'logo')){
            $file = $validated['logo'];
            $path = $file->store(
                'logos/'.Auth::user()->id, 'public'
            ); 
        }
        $empresa->logotipo = $path;
        $empresa->email = $validated['email'];
        $empresa->sitioweb = (Arr::exists($validated, 'logo')) ? $validated['sitio_web'] : 'http://google.com.mx';

        if($prevPath != NULL)
            Storage::disk('public')->delete($prevPath);

        if($empresa->isDirty())
        {
            $empresa->save();
            return $this->successResponse('La empresa se actualizó con exito',$empresa,201);
        }else{
            return $this->successResponse('No habia nada que modificar',$empresa,200);
        }  
    }

    public function delete($id)
    {
        $empresa = Empresa::findOrFail($id);

        $empleados = Empleado::where('company_id',$empresa->id)->get();
        if(!$empleados->isEmpty())
            return $this->errorResponse('No se puede eliminar la empresa ya que existen empleados que dependen de ella');

        $empresa->delete();

        return $this->successResponse('La empresa se elimino de manera satisfactoria',null,200);
    }
}
