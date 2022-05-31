<?php

namespace App\Modules\Distribution\Enums;

final class ZendeskTaskPriorityPointsEnum
{
    /* ALL AVAILABLE PRIORITY POINTS */

    public const URGENT  = 'Urgent';

    public const HIGH  = 'High';

    public const NORMAL  = 'Normal';

    public const LOW  = 'Low';

    public const PRIORITY_POINTS = [
        self::URGENT => 30,
        self::HIGH   => 20,
        self::NORMAL => 15,
        self::LOW    => 10,
    ];

    /* ALL AVAILABLE PRIORITY POINTS */
}
