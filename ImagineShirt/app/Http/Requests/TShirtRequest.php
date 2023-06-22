<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request;
use App\Models\Categorias;
use Auth;

class TShirtRequest extends FormRequest
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
        $userType = Auth::user()->user_type;
        $categorias = Categorias::whereNull('deleted_at')->orderBy('name')->pluck('name')->toArray();
    
        if ($userType !== 'C') {
            $categoryRules[] = 'nullable';
            $categoryRules[] = Rule::in($categorias);
        } else {
            $categoryRules[] = 'nullable';
        }

        $isCreating = $this->method() == 'POST';

        if ($isCreating){
            $imageRules = 'required|image|max:2048';
        }else{
            $imageRules = 'sometimes|image|max:2048';
        }

        return [
            'name' => [
                'required',
                'string',
                'max:50',
            ],

            'description' => [
                'nullable',
                'string',
                'max:200',
            ],

            'image' => $imageRules,
            'category' => $categoryRules,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'name.string' => 'Nome inválido',
            'name.max' => 'O nome não pode ter mais de 50 caracteres',
            'description.string' => 'Descrição Inválida',
            'description.max' => 'A descrição não pode ter mais de 200 caracteres',
            'image.required' => 'A imagem é obrigatória',
            'image.image' => 'O ficheiro tem de ser uma imagem',
            'image.max' => 'A imagem não pode ter mais de 2MB',
            'category.in' => 'Categoria não é válida',
        ];
    }
}
