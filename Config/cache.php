<?php
    return array
    (
        'memcache' => array(
            'driver'             => 'memcache',
            'default_expire'     => 3600,
            'compression'        => FALSE,              // Use Zlib compression (can cause issues with integers)
            'servers'            => array(
                'local' => array(
                    'host'             => '127.0.0.1',  // Memcache Server
                    'port'             => 11211,        // Memcache port number
                    'persistent'       => FALSE,        // Persistent connection
                    'weight'           => 1,
                    'timeout'          => 1,
                    'retry_interval'   => 15,
                    'status'           => TRUE,
                ),
            ),
            'instant_death'      => TRUE,               // Take server offline immediately on first fail (no retry)
        ),
        'sqlite'   => array(
            'driver'             => 'sqlite',
            'default_expire'     => 3600,
            'database'           => HOST.DS.'Cache'.DS.'wezom-cache.sql3',
            'schema'             => 'CREATE TABLE caches(id VARCHAR(127) PRIMARY KEY, tags VARCHAR(255), expiration INTEGER, cache TEXT)',
        ),
        'file'    => array(
            'driver'             => 'file',
            'cache_dir'          => 'Cache'.DS.'TMP',
            'default_expire'     => 3600,
            'ignore_on_delete'   => array(
                '.gitignore',
                '.git',
                '.svn'
            )
        ),
    );
