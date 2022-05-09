<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
        $rules =  [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
            'status' => 'required',
            'link' => 'nullable'
        ];

        if ($this->has('_method')) {
            $rules['image'] = 'nullable';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'title' => 'Tiêu đề',
            'description' => 'Mô tả',
            'image' => 'Hình ảnh',
            'link' => 'Liên kết',
            'status' => 'Trạng thái'
        ];
    }
}
