<?php
    namespace Wezom\Modules\Menu\Models;

    use Core\Arr;
    use Core\Message;

    class Menu extends \Core\Common {

        public static $table = 'sitemenu';
        public static $rules = array(
            'name' => array(
                array(
                    'error' => 'Название пункта меню не может быть пустым!',
                    'key' => 'not_empty',
                ),
            ),
            'url' => array(
                array(
                    'error' => 'Ссылка не может быть пустой!',
                    'key' => 'not_empty',
                ),
                array(
                    'error' => 'Ссылка должна содержать только латинские буквы в нижнем регистре, цифры, "/", "?", "&", "=", "-" или "_"!',
                    'key' => 'regex',
                    'value' => '/^[a-z0-9\-_\/\?\=\&]*$/',
                ),
            ),
        );

    }