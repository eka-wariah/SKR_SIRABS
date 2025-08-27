<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Scheduled Commands
    |--------------------------------------------------------------------------
    |
    | Define your scheduled commands here.
    |
    */

    'commands' => [
        [
            'command' => 'app:generate-monthly-invoices',
            'schedule' => '* * * * *', // tanggal 1 jam 00:00
            'description' => 'Generate monthly invoices on 1st day of month at midnight',
        ],
    ],

];
