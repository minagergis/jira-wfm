<?php

$suitableTimeZone = ((bool) env('DST_SUMMER_TIME', true)) ? 'Asia/Riyadh' : 'Africa/Cairo';
dd($suitableTimeZone);
return [
    'name'            => 'Shifts',
    'shifts_timezone' => $suitableTimeZone,
];
