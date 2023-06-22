<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Auth;

class UserRequest extends FormRequest
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

        switch($this->default_payment_type){
            case 'VISA':
            case 'MC':
                $ruleRefPagamento = 'required_with:default_payment_type|digits:16';
                break;
            case 'PAYPAL':
                $ruleRefPagamento = 'required_with:default_payment_type|email';
                break;
            default:
                $ruleRefPagamento = 'nullable';
        }

        $user = $this->route('user');

        $isCreating = $this->method() == 'POST';

        $ruleEmail = [
            'required',
            'email',
        ];

        $ruleNif = [
            'nullable',
            'digits:9',
        ];

        if ($isCreating){
            $rulesUserType = 'required|in:A,E';
            $ruleEmail[] = Rule::unique('users', 'email');
            $rulesPassword = 'required|string|min:8|max:50';
        }else{
            $ruleEmail[] = Rule::unique('users', 'email')->ignore($user->id);
            $ruleNif[] = Rule::unique('customers', 'nif')->ignore($user->id);
            $rulesPassword = 'nullable';

            if ($user->user_type != 'C'){
                $rulesUserType = 'required|in:A,E';
            }else{
                $rulesUserType = 'nullable';
            }
        }

        return [
            'name' => [
                'required',
                'string',
                'max:200',
            ],
            'password' => $rulesPassword,
            'email' => $ruleEmail,
            'nif' => $ruleNif,
            'userType' => $rulesUserType,
            'image' => 'sometimes|image|max:2048',
            'address' => 'nullable|string|max:200',
            'default_payment_type' => 'nullable|in:PAYPAL,MC,VISA',
            'default_payment_ref' => $ruleRefPagamento,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'name.string' => 'Nome inválido',
            'name.max' => 'O nome não pode ter mais de 200 caracteres',
            'email.required' => 'O email é obrigatório',
            'email.email' => 'O formato do email é inválido',
            'email.unique' => 'O email tem que ser único',
            'nif.digits' => 'O NIF deve ter exatamente 9 dígitos',
            'nif.unique' => 'O NIF tem que ser único',
            'image.image' => 'O ficheiro tem de ser uma imagem',
            'image.max' => 'A imagem não pode ter mais de 2MB',
            'address.string' => 'Morada inválida',
            'address.max' => 'A morada não pode ter mais de 200 caracteres',
            'default_payment_type.in' => 'O tipo de pagamento selecionado não é válido',
            'default_payment_ref.required_with' => 'A referência de pagamento é obrigatório',
            'default_payment_ref.digits' => 'A referência de pagamento deve ter 16 dígitos',
            'default_payment_ref.email' => 'A referência de pagamento deve ter um formato de e-mail válido',
            'userType.required' => 'Tipo de user é obrigatório',
            'userType.in' => 'Tipo de user não é valido',
            'password.required' => 'Palavra-Passe é obrigatória',
            'password.string' => 'Palavra-Passe inválida',
            'password.min' => 'Palavra-Passe tem de ter no mínimo 8 caracteres',
            'password.max' => 'Palavra-Passe não pode ter mais de 50 caracteres',
        ];
    }
}
