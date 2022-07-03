<?php

namespace App\Modules\Shifts\Http\Requests\MemberSchedules;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Modules\Shifts\Rules\MustBeFutureSchedule;
use App\Modules\Shifts\Rules\NoOverlappedSchedule;
use App\Modules\Shifts\Services\MemberScheduleService;

class UpdateMemberScheduleRequest extends FormRequest
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
            'team_member_id' => [
                'sometimes',
                Rule::exists('team_members', 'id'),
                new NoOverlappedSchedule($this->start_date, $this->end_date),
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
        $service     = resolve(MemberScheduleService::class);
        $requestData = (array) json_decode($this->data);
        $oldSchedule = $service->read($requestData['schedule']->id);

        $changes               = [
            'id'             => $requestData['schedule']->id,
            'name'           => $requestData['changes']->title ?? $oldSchedule->name,
            'team_member_id' => $requestData['changes']->calendarId ?? $oldSchedule->team_member_id,

            'start_date'     => $oldSchedule->date_from.' '.$oldSchedule->time_from,
            'time_from'      => $oldSchedule->time_from,
            'date_from'      => $oldSchedule->date_from,

            'end_date'       => $oldSchedule->date_to.' '.$oldSchedule->time_to,
            'time_to'        => $oldSchedule->time_to,
            'date_to'        => $oldSchedule->date_to,
        ];

        if (isset($requestData['changes']->start)) {
            $changes['start_date'] = Carbon::parse($requestData['changes']->start->_date)->timezone('Africa/Cairo')->toDateTimeString();
            $changes['time_from']  = Carbon::parse($requestData['changes']->start->_date)->timezone('Africa/Cairo')->toTimeString();
            $changes['date_from']  = Carbon::parse($requestData['changes']->start->_date)->timezone('Africa/Cairo')->toDateString();
        }

        if (isset($requestData['changes']->end)) {
            $changes['end_date'] = Carbon::parse($requestData['changes']->end->_date)->timezone('Africa/Cairo')->toDateTimeString();
            $changes['time_to']  = Carbon::parse($requestData['changes']->end->_date)->timezone('Africa/Cairo')->toTimeString();
            $changes['date_to']  = Carbon::parse($requestData['changes']->end->_date)->timezone('Africa/Cairo')->toDateString();
        }

        $this->merge($changes);
    }
}
