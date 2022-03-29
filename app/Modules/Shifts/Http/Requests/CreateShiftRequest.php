<?php

namespace App\Modules\Shifts\Http\Requests;

use Illuminate\Validation\Rule;
use App\Modules\Shifts\Enums\DaysEnum;
use Illuminate\Foundation\Http\FormRequest;

class CreateShiftRequest extends FormRequest
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
            'days' => [
                'required',
                'array',
            ],
            'days.*' => [
                Rule::in(array_keys(DaysEnum::DAYSValues)),
            ],
            'teams' => [
                'required',
                'array',
            ],
            'teams.*'=> [
                Rule::exists('teams', 'id'),
            ],
            'time_from' => [
                'required',
                'date_format:H:i:s',
            ],
            'time_to' => [
                'required',
                'date_format:H:i:s',
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
