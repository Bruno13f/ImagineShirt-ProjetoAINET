<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Auth;

class CategoriaRequest extends FormRequest
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

        $ruleName = [
            'required',
            'string',
            'max:50',
        ];

        $categoria = $this->route('categoria');

        $isCreating = $this->method() == 'POST';

        if ($isCreating){
            $ruleName[] = Rule::unique('categories', 'name'); 
        }else{  
            $ruleName[] = Rule::unique('categories', 'name')->ignore($categoria->id); 
        }

        return [
            'name' => $ruleName,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome da categoria é obrigatório',
            'name.string' => 'Nome inválido',
            'name.max' => 'O nome não pode ter mais de 50 caracteres',
            'name.unique' => 'O nome tem de ser único',
        ];
    }
}
