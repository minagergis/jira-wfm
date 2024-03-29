<?php

namespace App\Modules\Shifts\Http\Requests\MemberSchedules;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Modules\Shifts\Rules\NoOverlappedSchedule;

class CreateMemberScheduleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'team_member_id' => [
                'required',
                Rule::exists('team_members', 'id'),
                new NoOverlappedSchedule($this->start_date, $this->end_date),
            ],
            'name' => [
                'required',
                'string',
            ],
            'start_date' => [
                'required',
                'after_or_equal:now',
            ],
            'end_date' => [
                'required',
                'after:start_date',
            ],
            'time_from'   => ['required'],
            'date_from'   => ['required'],
            'time_to'     => ['required'],
            'date_to'     => ['required'],
            'shift_hours' => [
                'required',
                'gte:5',
                'lte:10',
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

        $fromDate = Carbon::parse($requestData['start']->_date)->timezone(config('shifts.shifts_timezone'));
        $toDate   = Carbon::parse($requestData['end']->_date)->timezone(config('shifts.shifts_timezone'));

        $shiftHours = $toDate->diffInHours($fromDate);


        $memberSchedule = [
            'name'           => $requestData['title'],
            'team_member_id' => $requestData['calendarId'],

            'start_date'     => $fromDate->toDateTimeString(),
            'time_from'      => $fromDate->toTimeString(),
            'date_from'      => $fromDate->toDateString(),

            'end_date'       => $toDate->toDateTimeString(),
            'time_to'        => $toDate->toTimeString(),
            'date_to'        => $toDate->toDateString(),
            'shift_hours'    => $shiftHours,
        ];

        $this->merge($memberSchedule);
    }

}
