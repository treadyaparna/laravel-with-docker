<?php

namespace App\Http\Requests;

class CommentRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'commentTitle' => 'required|string|max:50',
            'commentContent' => 'required|string|max:250',
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
            'commentTitle' => 'title',
            'commentContent' => 'content',
        ];
    }
}
