<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrecosRequest extends FormRequest
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

        $rulePreco = 'required|regex:/^\d{1,2}(?:\.\d{1,2})?$/i';

        return [
            'precoCatalogo' => $rulePreco,
            'precoCatalogoDisc' => $rulePreco,
            'precoCliente' => $rulePreco,
            'precoClienteDisc' => $rulePreco,
            'quantDesc' => 'required|digits:1,2',
        ];
    }

    public function messages()
    {
        return [
            'precoCatalogo.required' => 'O preço de catálogo é obrigatório',
            'precoCatalogo.regex' => 'Preço de catálogo inválido - 2 unidades e 2 casas decimais máximo',
            'precoCatalogoDisc.required' => 'O desconto do preço de catálogo é obrigatório',
            'precoCatalogoDisc.regex' => 'Desconto do preço de catálogo é inválido - 2 unidades e 2 casas decimais máximo',
            'precoCliente.required' => 'O preço de cliente é obrigatório',
            'precoCliente.regex' => 'Preço de cliente inválido - 2 unidades e 2 casas decimais máximo',
            'precoClienteDisc.required' => 'O desconto do preço de cliente é obrigatório',
            'precoClienteDisc.regex' => 'Desconto do preço de cliente inválido - 2 casas decimais máximo',
            'quantDesc.required' => 'A quantidade de desconto é obrigatória',
            'quantDesc.digits' => 'Quntidade de desconto é inválida - 1 ou 2 digitos',
        ];
    }
}
