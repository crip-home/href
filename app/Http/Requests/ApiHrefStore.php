<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ApiHrefStore
 * @package App\Http\Requests
 */
class ApiHrefStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
        $rules = [
            'title' => 'required|between:3,255',
            'url' => 'nullable|url|max:500|unique:hrefs,url',
            'visible' => 'required|boolean',
            'category_id' => 'nullable|exists:categories,id',
        ];

        if ($this->get('parent_id') > 0) {
            $rules['parent_id'] = 'exists:hrefs,id';
        }

        return $rules;
    }
}
