<?php
    namespace Wezom\Modules\Multimedia\Models;

    use Core\Arr;
    use Core\Message;

    class Slider extends \Core\Common {

        public static $table = 'slider';
        public static $image = 'slider';
        public static $rules = array(
            'name' => array(
                array(
                    'error' => 'Название не может быть пустым!',
                    'key' => 'not_empty',
                ),
            ),
        );

    }