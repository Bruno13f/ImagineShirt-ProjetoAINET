<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class CorRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $cor = $this->route('cor');

        return [
            'code' => [
                'required',
                'regex:/^([a-f0-9]{6}|[a-f0-9]{3})|([a-zA-Z]+)$/i',
                'max:15',
                Rule::unique('colors', 'code')->ignore($cor->code, 'code')
            ],
            'name' => [
                'required',
                'string',
                'max:30',
            ],
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'O código é obrigatório',
            'code.regex' => 'Código inválido - Tem de ser código hexadecimal ou nome válido de cor',
            'code.max' => 'O código não pode ter mais de 15 caracteres',
            'code.unique' => 'O código tem de ser único',
            'name.required' => 'O nome é obrigatório',
            'name.string' => 'Nome inválido',
            'name.max' => 'O nome não pode ter mais de 30 caracteres',
        ];
    }
}
