<?php

return [
    'default' => [
        'type' => 'MySQLi',
        'connection' => [
            /**
             * The following options are available for MySQL:
             *
             * string   hostname     server hostname, or socket
             * string   database     database name
             * string   username     database username
             * string   password     database password
             * boolean  persistent   use persistent connections?
             * array    variables    system variables as "key => value" pairs
             *
             * Ports and sockets may be appended to the hostname.
             */
            'hostname' => '91.206.30.13',
            'database' => 'sensitive_db',
            'username' => 'sensitive_db',
            'password' => 'H4c3O5h5',
            'persistent' => false,
        ],
        'table_prefix' => '',
        'charset' => 'utf8',
        'caching' => false,
    ],
];
