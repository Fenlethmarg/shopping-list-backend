<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Cambiar según las necesidades de autorización
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'articles' => 'required|array',
            'articles.*' => 'exists:articles,id',
        ];
    }
}