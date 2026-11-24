<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePreferenceRequest extends FormRequest
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
            'dark_mode_set' => 'required|numeric',
            'items_per_page' => 'required|numeric',
            'flat_nav_bar_set' => 'required|numeric',
            'fixed_header_set' => 'required|numeric',
        ];
    }
}
