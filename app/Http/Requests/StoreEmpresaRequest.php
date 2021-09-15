<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreEmpresaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /* No hay que hacer validacion ya que se esta validando en el middleware*/
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
            'nombre' => 'required|string',
            'logo' => 'mimes:jpg,jpeg,png|max:100|dimensions:max_width=100,max_height=100',
            'email' => 'required|email',
            'sitio_web' => 'string'
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'Es necesario agregar un nombre',
            'nombre.string' => 'Este campo solo acepta caracteres',
            'logo.dimensions' => 'La imagen debe ser de 100 x 100 pixeles',
            'email.required' => 'Es necesario indicar el correo electronico',
            'email.email' => 'Formato incorrecto para el email'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'nombre' => Str::ucfirst(Str::lower($this->nombre)),
        ]);
    }
}
