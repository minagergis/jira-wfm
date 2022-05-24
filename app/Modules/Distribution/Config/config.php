<?php

return [
    'name' => 'Distribution',
    'jira' => [
        'host'     => env('JIRA_HOST'),
        'user'     => env('JIRA_USER'),
        'password' => env('JIRA_TOKEN'),
    ],
    'distribution_hour_every_day' => env('DISTRIBUTION_HOUR_EVERY_DAY', '02:00'),
];
