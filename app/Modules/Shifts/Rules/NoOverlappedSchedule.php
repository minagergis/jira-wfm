<?php

namespace App\Modules\Shifts\Rules;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;
use App\Modules\Shifts\Entities\MemberSchedule;

class NoOverlappedSchedule implements Rule
{
    private $startDate;

    private $endDate;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return MemberSchedule::query()
            ->where('team_member_id', $value)
            ->where(function ($query) {
                return $query->where(
                    DB::raw("CONCAT(`date_from`, ' ', `time_from`)"),
                    '<=',
                    $this->startDate
                )->where(
                    DB::raw("CONCAT(`date_to`, ' ', `time_to`)"),
                    '>=',
                    $this->startDate
                );
            })
            ->orWhere(function ($query2) {
                return $query2->where(
                    DB::raw("CONCAT(`date_from`, ' ', `time_from`)"),
                    '<=',
                    $this->endDate
                )->where(
                    DB::raw("CONCAT(`date_to`, ' ', `time_to`)"),
                    '>=',
                    $this->endDate
                );
            })
            ->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'There are overlapped shift for this member';
    }
}
