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
        //dd($this->toArray());
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
            'time_from' => ['required'],
            'date_from' => ['required'],
            'time_to'   => ['required'],
            'date_to'   => ['required'],
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
            'name'           => $requestData['title'],
            'team_member_id' => $requestData['calendarId'],

            'start_date'     => Carbon::parse($requestData['start']->_date)->timezone('Africa/Cairo')->toDateTimeString(),
            'time_from'      => Carbon::parse($requestData['start']->_date)->timezone('Africa/Cairo')->toTimeString(),
            'date_from'      => Carbon::parse($requestData['start']->_date)->timezone('Africa/Cairo')->toDateString(),

            'end_date'       => Carbon::parse($requestData['end']->_date)->timezone('Africa/Cairo')->toDateTimeString(),
            'time_to'        => Carbon::parse($requestData['end']->_date)->timezone('Africa/Cairo')->toTimeString(),
            'date_to'        => Carbon::parse($requestData['end']->_date)->timezone('Africa/Cairo')->toDateString(),
        ];

        $this->merge($memberSchedule);
    }
}
