<?php
    namespace Modules\Content\Models;

    use Core\QB\DB;

    class Content extends \Core\Common {

        public static $table = 'content';

        public static function getKids($id, $status = NULL) {
            $kids = DB::select()
                ->from(static::$table)
                ->where(static::$table.'.parent_id', '=', $id);
            if( $status !== NULL ) {
                $kids->where('status', '=', $status);
            }
            return $kids->order_by('sort', 'ASC')->find_all();
        }

    }