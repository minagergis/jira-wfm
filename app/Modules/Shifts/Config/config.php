<?php

$suitableTimeZone = ((bool) env('DST_SUMMER_TIME', true)) ? 'Asia/Riyadh' : 'Africa/Cairo';

return [
    'name'            => 'Shifts',
    'shifts_timezone' => $suitableTimeZone,
];
