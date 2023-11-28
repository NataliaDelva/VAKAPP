<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFincaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $fincaId = $this->route('id');

        return [
            'nombre' => 'required|string|max:155',
            'direccion' => 'required|string|max:155',
            'dimension' => 'required|string|max:155',
            'nro_finca' => ['required', 'string', 'max:155', Rule::unique('fincas')->ignore($fincaId)],
        ];
    }
}
