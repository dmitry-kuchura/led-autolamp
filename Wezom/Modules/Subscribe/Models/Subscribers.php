<?php
    namespace Wezom\Modules\Subscribe\Models;

    use Core\Arr;
    use Core\Message;

    class Subscribers extends \Core\Common {

        public static $table = 'subscribers';
        public static $filters = array(
            'email' => array(
                'table' => NULL,
                'action' => 'LIKE',
            ),
        );
        public static $rules = array(
            'email' => array(
                array(
                    'error' => 'Поле "E-Mail" введено некорректно!',
                    'key' => 'email',
                ),
            ),
        );

    }