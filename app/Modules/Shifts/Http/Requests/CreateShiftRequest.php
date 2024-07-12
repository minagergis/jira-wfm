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

    protected function prepareForValidation()
    {
        $this->merge([
            'time_from' => $this->formatTime($this->time_from),
            'time_to'   => $this->formatTime($this->time_to),
        ]);
    }

    public function formatTime($time)
    {
        if (count(explode(':', $time)) != 3) {
            return $time.':00';
        }

        return $time;
    }
}
