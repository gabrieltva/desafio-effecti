<?php

namespace App\Http\Requests;

use App\Enums\UserStatus;
use App\Rules\Cpf;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

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
        return [
            'name' => 'required|string|max:255',
            'cpf' => ['required', 'unique:users', new Cpf],
            'birth_date' => 'required|date',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'cep' => 'required|string|max:9',
            'state' => 'required|string|max:2',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'status' => ['required', new Enum(UserStatus::class)],
        ];
    }
}
