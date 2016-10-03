<?php
    namespace Wezom\Modules\Cap\Models;

    use Core\QB\DB;

    class Cap extends \Core\Common {

        public static $table = 'cap';
        public static $filters = array(
            'name' => array(
                'table' => NULL,
                'action' => 'LIKE',
            ),
        );
        public static $rules = array(
            'name' => array(
                array(
                    'error' => 'Название новости не может быть пустым!',
                    'key' => 'not_empty',
                ),
            ),
        );

    }