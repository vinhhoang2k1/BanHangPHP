<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'name' => 'required',
            'status'=> 'required',
            'price' => 'required|numeric',
            'short_content' => 'required',
            'description' => 'required',
            'quantity' => 'integer',
            'thumbnail' => 'nullable',
            'category_id' => 'required',
            'selling_product' => 'nullable',
            'common' => 'nullable',
            'new_product' => 'nullable'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên',
            'status' => 'Trạng thái',
            'price' => 'Giá',
            'short_content' => 'Mô tả ngắn',
            'description' => 'Mô tả',
            'quantity' => 'Số lượng',
            'thumbnail' => 'Hình ảnh',
            'category_id' => 'Danh mục'
        ];
    }
}
