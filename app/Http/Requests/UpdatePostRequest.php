<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'body' => 'required|string',
            'status' => 'required|string',
            'excerpt' => 'required|string|min:160|max:200',
            'categories' => 'required|array',
            'tags' => 'nullable|array',
            'editors_pick' => 'nullable|boolean',
            'is_archived' => 'nullable|boolean',
            'author' => 'required|numeric',
            'featured_image' => 'nullable|image|max:2048',
            'existing_media_id' => 'nullable|integer|exists:media,id',
            'publish_at' => 'nullable|date',
        ];
    }
}
