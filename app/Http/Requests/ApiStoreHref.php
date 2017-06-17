<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ApiStoreHref
 * @package App\Http\Requests
 */
class ApiStoreHref extends FormRequest
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
        return [
            'title' => 'required|between:3,255',
            'url' => 'nullable|url|max:500',
            'visible' => 'required|boolean',
            'category_id' => 'nullable|exists:categories,id',
            'parent_id' => 'sometimes|exists:hrefs,id'
        ];
    }
}
