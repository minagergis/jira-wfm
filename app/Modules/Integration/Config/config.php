<?php

return [
    'name' => 'Integration',
    'hrms' => [
        'host'          => env('HRMS_BASE_LINK', 'http://hrms.test/'),
        'client_id'     => env('HRMS_CLIENT_ID', ''),
        'client_secret' => env('HRMS_CLIENT_SECRET', ''),
    ],
];
