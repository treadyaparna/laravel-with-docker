<?php

namespace App\Http\Requests;

class ArticleRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'articleTitle' => 'required|string|max:250',
            'articleContent' => 'required|string|max:1000',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'articleTitle' => 'title',
            'articleContent' => 'content',
        ];
    }
}
