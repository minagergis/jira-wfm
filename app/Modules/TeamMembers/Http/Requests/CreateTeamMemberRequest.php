<?php

namespace App\Modules\TeamMembers\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTeamMemberRequest extends FormRequest
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
            'jira_integration_id' => [
                'required',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
            'is_in_shift_now' => [
                'required',
                'boolean',
            ],
            'team' => [
                'integer',
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
