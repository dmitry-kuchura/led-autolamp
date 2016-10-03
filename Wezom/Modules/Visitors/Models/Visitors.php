<?php
    namespace Wezom\Modules\Visitors\Models;

    use Core\QB\DB;

    class Visitors extends \Core\Common {

        public static $table = 'visitors';
        public static $filters = array(
            'ip' => array(
                'table' => NULL,
                'action' => 'LIKE',
            ),
            'place' => array(
                'table' => false,
                'action' => 'LIKE',
                'field' => 'CONCAT(IF(country IS NOT NULL, CONCAT(country, ", "), ""), IF(region IS NOT NULL, CONCAT(region, ", "), ""), city)',
            ),
        );

    }