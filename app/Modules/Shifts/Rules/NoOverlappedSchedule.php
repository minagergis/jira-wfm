<?php

namespace App\Modules\Shifts\Rules;

use Illuminate\Contracts\Validation\Rule;
use Facades\App\Modules\Shifts\Facades\ShiftOverlapFacade;

class NoOverlappedSchedule implements Rule
{
    private $startDate;

    private $endDate;

    private $scheduleId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($startDate, $endDate, $scheduleId = null)
    {
        $this->startDate  = $startDate;
        $this->endDate    = $endDate;
        $this->scheduleId = $scheduleId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return ShiftOverlapFacade::isShiftDoesnotOverlapped($value, $this->startDate, $this->endDate, $this->scheduleId);
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
