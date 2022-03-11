<?php

namespace App\Http\Requests;

// use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseFormRequest;

class FilmRequest extends BaseFormRequest
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
        if ($this->isMethod('post')) {
            return $this->createRules();
        } elseif ($this->isMethod('put')) {
            return $this->updateRules();
        }
    }

    /**
     * Define validation rules to store method for resource creation
     *
     * @return array
     */
    public function createRules(): array
    {
        return [
            'name' => 'required|string|max:128',
            'description' => 'required|string|max:2048',
            // 'date' => 'required|date_format:Y-m-d\TH:i:sO',
            'note' => 'nullable|integer|min:0|max:5'
        ];
    }

    /**
     * Define validation rules to update method for resource update
     *
     * @return array
     */
    public function updateRules(): array
    {
        return [
            'name' => 'string|max:128',
            'description' => 'string|max:2048',
            // 'date' => 'date_format:Y-m-d\TH:i:sO',
            'note' => 'integer|min:0|max:5'
        ];
    }
}
