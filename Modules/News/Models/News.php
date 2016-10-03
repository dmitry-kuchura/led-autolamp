<?php
    namespace Modules\News\Models;

    use Core\QB\DB;

    class News extends \Core\Common {

        public static $table = 'news';

        /**
         * @param mixed $value - value
         * @param string $field - field
         * @param null/integer $status - 0 or 1
         * @return object
         */
        public static function getRow($value, $field = 'id', $status = NULL) {
            $result = DB::select()
                ->from(static::$table)
                ->where($field, '=', $value)
                ->where('date', '<=', time());
            if( $status !== NULL ) {
                $result->where('status', '=', $status);
            }
            return $result->find();
        }


        /**
         * @param null/integer $status - 0 or 1
         * @param null/string $sort
         * @param null/string $type - ASC or DESC. No $sort - no $type
         * @param null/integer $limit
         * @param null/integer $offset - no $limit - no $offset
         * @return object
         */
        public static function getRows($status = NULL, $sort = NULL, $type = NULL, $limit = NULL, $offset = NULL) {
            $result = DB::select()
                ->from(static::$table)
                ->where('date', '<=', time());
            if( $status !== NULL ) {
                $result->where('status', '=', $status);
            }
            if( $sort !== NULL ) {
                if( $type !== NULL ) {
                    $result->order_by($sort, $type);
                } else {
                    $result->order_by($sort);
                }
            }
            $result->order_by('id', 'DESC');
            if( $limit !== NULL ) {
                $result->limit($limit);
                if( $offset !== NULL ) {
                    $result->offset($offset);
                }
            }
            return $result->find_all();
        }


        /**
         * @param null/integer $status - 0 or 1
         * @return int
         */
        public static function countRows($status = NULL) {
            $result = DB::select(array(DB::expr('COUNT('.static::$table.'.id)'), 'count'))
                ->from(static::$table)
                ->where('date', '<=', time());
            if( $status !== NULL ) {
                $result->where(static::$table.'.status', '=', $status);
            }
            return $result->count_all();
        }

    }