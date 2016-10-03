<?php
    namespace Wezom\Modules\Seo\Models;

    class Templates extends \Core\Common {

        public static $table = 'seo_templates';
        public static $rules = array(
            'h1' => array(
                array(
                    'error' => 'H1 не может быть пустым!',
                    'key' => 'not_empty',
                ),
            ),
            'title' => array(
                array(
                    'error' => 'Title не может быть пустым!',
                    'key' => 'not_empty',
                ),
            ),
        );

    }