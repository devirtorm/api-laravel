<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarPacienteRequest extends FormRequest
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
        $id = $this->route('paciente')->id;
        return [
            //
            "nombres" => "required",
            "apellidos" => "required",
            "sexo" => "required",
            "edad" => "required",
            "dni" => "required | unique:pacientes,dni,".$id,
            "tipo_sangre" => "required",
            "telefono" => "required | unique:pacientes,telefono,".$id,
            "correo" => "required",
            "direccion" => "required",
        ];
    }
    
    
}
