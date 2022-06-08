<?php

namespace App\Modules\Tasks\Http\Requests;

use App\Modules\Distribution\Enums\TaskDistributionRatiosEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
            ],
            'description' => [
                'required',
                'string',
            ],
            'is_automatic' => [
                'required',
                'boolean',
            ],
            'points' => [
                'required',
                'integer',
            ],
            'frequency' => [
                'required',
                'string',
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
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'frequency'    => TaskDistributionRatiosEnum::PER_SHIFT,
            'is_automatic' => true,
        ]);
    }
}
