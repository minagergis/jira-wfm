<?php

namespace App\Modules\TeamMembers\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeamMemberRequest extends FormRequest
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
            'email' => [
                'nullable',
                'string',
                Rule::unique('team_members', 'email')
                    ->ignore($this->id, 'id'),
            ],
            'jira_integration_id' => [
                'required',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
            'color' => [
                'required',
                'string',
            ],
            'weight' => [
                'required',
                'integer',
            ],
            'team' => [
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
}
