<?php

namespace App\Modules\Distribution\Enums;



final class ZendeskTaskPriorityPointsEnum
{
    /* ALL AVAILABLE PRIORITY POINTS */

    public const HIGH  = 'High';

    public const MEDIUM  = 'Medium';

    public const LOW  = 'Low';

    public const PRIORITY_POINTS = [
        self::HIGH     => 20,
        self::MEDIUM   => 15,
        self::LOW      => 10,
    ];

    /* ALL AVAILABLE PRIORITY POINTS */
}
