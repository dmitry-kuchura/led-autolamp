<?php
    namespace Wezom\Modules\Seo\Models;

    class Redirects extends \Core\Common {

        public static $table = 'seo_redirects';
        public static $filters = array(
            'link_from' => array(
                'action' => 'LIKE',
            ),
            'link_to' => array(
                'action' => 'LIKE',
            ),
            'type' => array(
                'action' => '=',
            ),
        );

    }