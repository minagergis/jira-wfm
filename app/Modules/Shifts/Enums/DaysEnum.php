<?php

namespace App\Modules\Shifts\Enums;

class DaysEnum
{
    /* AVAILABLE DAYS VALUES */

    public const SUNDAY = 'Sunday';

    public const MONDAY = 'Monday';

    public const TUESDAY = 'Tuesday';

    public const WEDNESDAY = 'Wednesday';

    public const THURSDAY = 'Thursday';

    public const FRIDAY = 'Friday';

    public const SATURDAY = 'Saturday';

    public const DAYSValues = [
        'sun'  => self::SUNDAY,
        'mon'  => self::MONDAY,
        'tues' => self::TUESDAY,
        'wed'  => self::WEDNESDAY,
        'thur' => self::THURSDAY,
        'fri'  => self::FRIDAY,
        'sat'  => self::SATURDAY,

    ];

    /* AVAILABLE  DAYS VALUES */
}
