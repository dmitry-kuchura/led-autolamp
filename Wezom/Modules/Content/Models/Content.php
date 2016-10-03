<?php
    namespace Wezom\Modules\Content\Models;

    use Core\Arr;
    use Core\Message;

    class Content extends \Core\Common {

        public static $table = 'content';
        public static $rules = array(
            'name' => array(
                array(
                    'error' => 'Название страницы не может быть пустым!',
                    'key' => 'not_empty',
                ),
            ),
            'alias' => array(
                array(
                    'error' => 'Алиас не может быть пустым!',
                    'key' => 'not_empty',
                ),
                array(
                    'error' => 'Алиас должен содержать только латинские буквы в нижнем регистре, цифры, "-" или "_"!',
                    'key' => 'regex',
                    'value' => '/^[a-z0-9\-_]*$/',
                ),
            ),
        );

    }