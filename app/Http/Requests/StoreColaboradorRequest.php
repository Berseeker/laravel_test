<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreColaboradorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email',
            'company_id' => 'required',
            'telefono' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'Es necesario agregar un nombre',
            'apellido.required' => 'Es necesario agregar un apellido',
            'telefono.required' => 'Es necesario agregar un telefono',
            'email.required' => 'Es necesario indicar el correo electronico',
            'email.email' => 'Formato incorrecto para el email',
            'company_id' => 'Es necesario asignar una compañia al empleado'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'nombre' => Str::ucfirst(Str::lower($this->nombre)),
            'apellido' => Str::ucfirst(Str::lower($this->apellido)),
        ]);
    }
}
