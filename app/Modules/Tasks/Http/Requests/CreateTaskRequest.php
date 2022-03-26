<?php

namespace App\Modules\Tasks\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTaskRequest  extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
            ],
            'is_automatic' => [
                'required',
                'boolean',
            ],
            'points' => [
                'required',
                'integer'
            ],
            'frequency' => [
                'required',
                'string'
            ],
            'team_id' => [
                'required',
                'integer',
                Rule::exists('teams', 'id'),
            ],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}