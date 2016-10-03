<?php
    namespace Wezom\Modules\Blacklist\Models;

    class Blacklist extends \Core\Common {

        public static $table = 'blacklist';
        public static $filters = array(
            'ip' => array(
                'table' => NULL,
                'action' => 'LIKE',
            ),
        );
        public static $rules = array(
            'ip' => array(
                array(
                    'error' => 'IP не может быть пустым!',
                    'key' => 'not_empty',
                ),
            ),
        );

    }