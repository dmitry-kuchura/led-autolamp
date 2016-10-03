<?php
    namespace Wezom\Modules\Seo\Models;

    use Core\Arr;
    use Core\Message;

    class Links extends \Core\Common {

        public static $table = 'seo_links';
        public static $filters = array(
            'name' => array(
                'table' => NULL,
                'action' => 'LIKE',
            ),
            'link' => array(
                'table' => NULL,
                'action' => 'LIKE',
            ),
        );
        public static $rules = array(
            'name' => array(
                array(
                    'error' => 'Название не может быть пустым!',
                    'key' => 'not_empty',
                ),
            ),
        );

    }