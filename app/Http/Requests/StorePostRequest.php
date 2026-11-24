<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'featured_image' => 'required_without:existing_media_id|nullable|image|max:2048',
            'existing_media_id' => 'nullable|integer|exists:media,id',
            'tags' => 'nullable|array',
            'editors_pick' => 'nullable|boolean',
            'author' => 'required|numeric',
            'is_archived' => 'nullable|boolean',
            'publish_at' => 'nullable|date|after:now',
        ];
    }

    public function messages()
    {
        return [
            'featured_image.required_without' => 'Please upload a featured image or choose one from already uploaded photos.',
        ];
    }
}
