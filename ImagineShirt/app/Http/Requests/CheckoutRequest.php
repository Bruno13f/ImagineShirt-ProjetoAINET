<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Auth;

class CheckoutRequest extends FormRequest
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

        $user = Auth::user();

        switch($this->default_payment_type){
            case 'VISA':
            case 'MC':
                $ruleRefPagamento = 'required_with:default_payment_type|digits:16';
                break;
            case 'PAYPAL':
                $ruleRefPagamento = 'required_with:default_payment_type|email';
                break;
        }

        return [
            'nif' => [
                'required',
                'digits:9',
                Rule::unique('customers', 'nif')->ignore($user->id),
            ],
            'address' => 'required|string|max:200',
            'notas' => 'nullable|string|max:300',
            'default_payment_type' => 'required|in:PAYPAL,MC,VISA',
            'default_payment_ref' => $ruleRefPagamento,
        ];
    }

    public function messages()
    {
        return [
            'nif.required' => 'O NIF é obrigatório',
            'nif.digits' => 'O NIF deve ter exatamente 9 dígitos',
            'nif.unique' => 'O NIF tem que ser único',
            'address.required' => 'A Morada é obrigatória',
            'address.string' => 'Morada inválida',
            'address.max' => 'A morada não pode ter mais de 200 caracteres',
            'notas.string' => 'Nota inválida',
            'notas.max' => 'A nota não pode ter mais de 300 caracteres',
            'default_payment_type.required' => 'O tipo de pagamento é obrigatório',
            'default_payment_type.in' => 'O tipo de pagamento selecionado não é válido',
            'default_payment_ref.required_with' => 'A referência de pagamento é obrigatória',
            'default_payment_ref.digits' => 'A referência de pagamento deve ter 16 dígitos',
            'default_payment_ref.email' => 'A referência de pagamento deve ter um formato de e-mail válido',
        ];
    }
}
