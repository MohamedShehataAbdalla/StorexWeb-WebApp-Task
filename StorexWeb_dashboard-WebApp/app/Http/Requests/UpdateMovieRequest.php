<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Movie;

class UpdateMovieRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:100', Rule::unique(Movie::class,'title')->ignore($request->id)],
            'description' => ['nullable', 'string'],
            'rate' => ['nullable', 'numeric'],
        ];
    }
}
