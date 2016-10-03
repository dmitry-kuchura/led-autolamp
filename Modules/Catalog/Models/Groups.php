<?php
    namespace Modules\Catalog\Models;

    use Core\QB\DB;

    class Groups extends \Core\Common {

        public static $table = 'catalog_tree';


        public static function getInnerGroups($parent_id, $sort = NULL, $type = NULL, $limit = NULL, $offset = NULL) {
            $result = DB::select()
                ->from(static::$table)
                ->where(static::$table.'.parent_id', '=', $parent_id)
                ->where(static::$table.'.status', '=', 1);
            if( $sort !== NULL ) {
                if( $type !== NULL ) {
                    $result->order_by(static::$table.'.'.$sort, $type);
                } else {
                    $result->order_by(static::$table.'.'.$sort);
                }
            }
            if( $limit !== NULL ) {
                $result->limit($limit);
                if( $offset !== NULL ) {
                    $result->offset($offset);
                }
            }
            return $result->find_all();
        }


        public static function countInnerGroups($parent_id) {
            $result = DB::select(array(DB::expr('COUNT('.static::$table.'.id)'), 'count'))
                ->from(static::$table)
                ->where(static::$table.'.parent_id', '=', $parent_id)
                ->where(static::$table.'.status', '=', 1);
            return $result->count_all();
        }

    }