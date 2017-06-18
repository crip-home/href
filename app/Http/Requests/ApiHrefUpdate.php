<?php namespace App\Http\Requests;

use App\Services\HrefService;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

/**
 * Class ApiHrefUpdate
 * @package App\Http\Requests
 */
class ApiHrefUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => 'required|between:3,255',
            'url' => 'nullable|url|max:500',
            'visible' => 'required|boolean',
            'category_id' => 'nullable|exists:categories,id',
        ];

        if ($this->get('parent_id') > 0) {
            $rules['parent_id'] = 'exists:hrefs,id';
        }

        return $rules;
    }

    /**
     * Apply custom validations after rules applied.
     * @param Validator $validator
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            if (!$this->canAddUrl()) {
                $validator->errors()->add(
                    'url', 'Can`t add URL for folder with child records.'
                );
            }
        });
    }

    public function canAddUrl(): bool
    {
        /** @var HrefService $hrefService */
        $hrefService = app(HrefService::class);
        $id = $this->get('id');

        if ($this->get('url')) {
            return $hrefService->hasChildRecords($id);
        }

        return true;
    }
}
