<?php

namespace App\Modules\Shifts\Rules;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;
use App\Modules\Shifts\Entities\MemberSchedule;

class MustBeFutureSchedule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return MemberSchedule::query()->where('id', $value)
            ->where(
                DB::raw("CONCAT(`date_from`, ' ', `time_from`)"),
                '>=',
                now('Africa/Cairo')->toDateTimeString()
            )->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Cannot update past schedule !';
    }
}
