<?php

namespace App\Modules\Shifts\Http\Requests\MemberSchedules;

use App\Modules\Shifts\Rules\MustBeFutureSchedule;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Modules\Shifts\Rules\NoOverlappedSchedule;
use App\Modules\Shifts\Services\MemberScheduleService;

class DeleteMemberScheduleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //dd($this->toArray());
        return [
            'id' => [
                'required',
                Rule::exists('member_schedules', 'id'),
                new MustBeFutureSchedule(),
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
        $requestData = (array) json_decode($this->data);

        $memberSchedule = [
            'id'         => $requestData['id'],
        ];

        $this->merge($memberSchedule);
    }
}
