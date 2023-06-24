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

        $isCreating = $this->method() == 'POST';

        $ruleCode = [
            'required',
            'regex:/^([a-fA-F0-9]{6}|[a-fA-F0-9]{3})|([a-zA-Z]+)$/i',
            'max:15',
        ];

        if ($isCreating){
            $ruleCode[] = Rule::unique('colors', 'code');
            
        }else{
            $rulesCode = Rule::unique('colors', 'code')->ignore($cor->code, 'code');
        }

        return [
            'code' => $ruleCode,
            'name' => [
                'required',
                'string',
                'max:30',
            ],
            'image' => 'required|image|max:2048',
            // 'codeValid' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'O código é obrigatório',
            'code.regex' => 'Código inválido - Tem de ser código hexadecimal',
            'code.max' => 'O código não pode ter mais de 15 caracteres',
            'code.unique' => 'O código tem de ser único',
            'name.required' => 'O nome é obrigatório',
            'name.string' => 'Nome inválido',
            'name.max' => 'O nome não pode ter mais de 30 caracteres',
            'image.required' => 'Imagem é obrigatória',
            'image.image' => 'O ficheiro tem de ser uma imagem',
            'image.max' => 'A imagem não pode ter mais de 2MB',
        ];
    }
}
