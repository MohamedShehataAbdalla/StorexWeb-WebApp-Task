<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\User;


class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(Request $request)
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string','email', 'max:255', Rule::unique(User::class,'name')->ignore($request->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'birthdate' => ['nullable', 'date'],
        ];
    }
}
