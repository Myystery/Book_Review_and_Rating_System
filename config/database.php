<?php

use App\Drivers\Database\MySQLDriver;

return [
    'driver' => 'mysql',

    'credentials' => [
        'mysql' => [
            'host'     => 'localhost',
            'port'     => '3306',
            'username' => 'homestead',
            'password' => 'secret',
            'db_name'  => 'book-review',
            'driver'   => MySQLDriver::class,
        ]
    ],
];
