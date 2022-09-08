<?php

return [
    'name' => 'Distribution',
    'jira' => [
        'host'     => env('JIRA_HOST'),
        'user'     => env('JIRA_USER'),
        'password' => env('JIRA_TOKEN'),
    ],
    'next_schedule_limit_for_tasks' => env('NEXT_SCHEDULE_LIMIT_FOR_TASKS', 2),

    'distribution_hour_every_day' => env('DISTRIBUTION_HOUR_EVERY_DAY', '02:00'),

    'distribution_depends_on_priority' => (bool) env('DISTRIBUTION_DEPENDS_ON_PRIORITY', false),
];
