<?php
    namespace Wezom\Modules\Catalog\Models;

    use Core\Arr;
    use Core\Message;
    use Core\QB\DB;

    class SpecificationsValues extends \Core\Common {

        public static $table = 'specifications_values';
        public static $rules = array(
            'name' => array(
                array(
                    'error' => 'Название значения характеристики не может быть пустым!',
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


        public static function getRowsBySpecifications($specifications) {
            $arr = array(0);
            foreach($specifications AS $s) {
                $arr[] = $s->id;
            }
            $specValues = DB::select()
                ->from(static::$table)
                ->where(static::$table.'.specification_id', 'IN', $arr)
                ->order_by(static::$table.'.name')
                ->find_all();
            return $specValues;
        }


        public static function getRowsBySpecificationsID($specifications) {
            if( !$specifications ) {
                $specifications = array();
            }
            if( !is_array($specifications) ) {
                $specifications = array($specifications);
            }
            $specValues = DB::select()
                ->from(static::$table)
                ->where(static::$table.'.specification_id', 'IN', $specifications)
                ->where(static::$table.'.status', '=', 1)
                ->order_by(static::$table.'.name')
                ->find_all();
            return $specValues;
        }


        public static function checkValue($specification_id, $alias) {
            $result = DB::select(static::$table.'.*')
                ->from(static::$table)
                ->where('alias', '=', $alias)
                ->where('specification_id', '=', $specification_id)
                ->where('status', '=', 1);
            return $result->find();
        }


        /**
         * @param integer $specification_id - Specification ID
         * @param null/integer $status - 0 or 1
         * @param null/string $sort
         * @param null/string $type - ASC or DESC. No $sort - no $type
         * @param null/integer $limit
         * @param null/integer $offset - no $limit - no $offset
         * @return object
         */
        public static function getRows($specification_id, $status = NULL, $sort = NULL, $type = NULL, $limit = NULL, $offset = NULL) {
            $result = DB::select()->from(static::$table)->where('specification_id', '=', $specification_id);
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
            if( $limit !== NULL ) {
                $result->limit($limit);
                if( $type !== NULL ) {
                    $result->offset($offset);
                }
            }
            return $result->find_all();
        }

    }