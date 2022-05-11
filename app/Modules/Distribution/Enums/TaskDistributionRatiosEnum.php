<?php

namespace App\Modules\Distribution\Enums;

use Spatie\Enum\Laravel\Enum;

final class TaskDistributionRatiosEnum extends Enum
{
    /* ALL AVAILABLE RATIOS TYPES */

    public const PER_SHIFT  = 'per_shift';

    public const ZENDESK  = 'zendesk';

    public const TYPES_RATIOS = [
        self::PER_SHIFT => 0.6,
        self::ZENDESK   => 0.4,
    ];

    /* ALL AVAILABLE RATIOS TYPES */
}
