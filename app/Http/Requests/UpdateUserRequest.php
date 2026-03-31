<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Mengambil ID user dari route (misal: users/{user}) untuk pengecualian unique email
        $userId = $this->route('user')->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$userId],
            'role' => ['required', 'in:admin,pimpinan'], // Validasi role
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ];
    }
}
