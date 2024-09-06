<?php

namespace App\Http\Requests;

use App\Enums\UserStatus;
use App\Rules\Cpf;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('id');

        $rules = [
            'name' => 'required|string|max:255',
            'cpf' => ['required', 'unique:users,cpf,' . $userId, new Cpf],
            'birth_date' => 'required|date',
            'email' => 'required|string|email|max:255|unique:users,email,' . $userId,
            'phone' => 'required|regex:/^\(?\d{2}\)?[\s-]?\d{4,5}[\s-]?\d{4}$/|max:15',
            'cep' => 'required|regex:/^\d{5}-\d{3}$/|max:9',
            'state' => 'required|string|max:2',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'status' => [new Enum(UserStatus::class)],
        ];

        if ($this->isMethod('PATCH') || $this->isMethod('PUT')) {
            foreach ($rules as $key => $rule) {
                if (is_array($rule)) {
                    foreach ($rule as $index => $r) {
                        if ($r === 'required') {
                            $rules[$key][$index] = 'sometimes';
                        }
                    }
                } else {
                    $rules[$key] = str_replace('required', 'sometimes', $rule);
                }
            }
        }

        return $rules;
    }


    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}
