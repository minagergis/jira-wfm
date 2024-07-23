<?php

namespace App\Modules\Shifts\Http\Requests\Bulk;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BulkScheduleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'shift' => [
                'required',
                Rule::exists('shifts', 'id'),
            ],

            'team_members' => [
                'required',
                'array',
            ],
            'team_members.*' => [
                Rule::exists('team_members', 'id'),
            ],

            'recurring_from' => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:now',
            ],
            'recurring_to' => [
                'required',
                'date_format:Y-m-d',
                'after:recurring_from',
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
}
