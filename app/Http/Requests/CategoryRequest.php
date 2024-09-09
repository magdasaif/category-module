<?php

namespace Modules\Category\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'name_ar'           => 'required|string|min:3|max:190',
            'name_en'           => 'required|string|min:3|max:190|unique:categories,name_en,'.$this->request->get('id'),
            'type'              => ['required',Rule::in(['product', 'service']),],
            'description_ar'    => 'required|string|min:15',
            'description_en'    => 'required|string|min:15',
            'icon'              => 'required',
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'name_ar'           => trans('category::main.form.name_ar'),
            'name_en'           => trans('category::main.form.name_en'),
            'description_ar'    => trans('category::main.form.description_ar'),
            'description_en'    => trans('category::main.form.description_en'),
            'icon'              => trans('category::main.form.icon'),
            'type'              => trans('category::main.form.type'),
        ];
    }

   
}
