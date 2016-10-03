<?php
    namespace Modules\Catalog\Models;

    use Core\Config;
    use Core\Cookie;
    use Core\QB\DB;

    class Items extends \Core\Common {

        public static $table = 'catalog';
        public static $tableImages = 'catalog_images';

        public static function searchRows($queries, $limit = NULL, $offset = NULL) {
            $result = DB::select(
                static::$table.'.*'
            )
                ->from(static::$table)
                ->join('brands')->on('brands.alias', '=', static::$table.'.brand_alias')
                ->where(static::$table.'.status', '=', 1);
            $result->and_where_open();
            $result->or_where_open();
            foreach ($queries as $query) {
                $result->where(static::$table.'.name', 'LIKE', '%' . $query . '%');
            }
            $result->or_where_close();
            $result->or_where_open();
            foreach ($queries as $query) {
                $result->where(static::$table.'.artikul', 'LIKE', '%' . $query . '%');
            }
            $result->or_where_close();
            $result->or_where_open();
            foreach ($queries as $query) {
                $result->where('brands.name', 'LIKE', '%' . $query . '%');
            }
            $result->or_where_close();
            $result->and_where_close();
            $result->order_by(static::$table.'.sort', 'ASC');
            $result->order_by(static::$table.'.id', 'DESC');
            if( $limit !== NULL ) {
                $result->limit($limit);
                if( $offset !== NULL ) {
                    $result->offset($offset);
                }
            }
            return $result->find_all();
        }


        public static function countSearchRows($queries) {
            $result = DB::select(array(DB::expr('COUNT('.static::$table.'.id)'), 'count'))
                ->from(static::$table)
                ->join('brands')->on('brands.alias', '=', static::$table.'.brand_alias')
                ->where(static::$table.'.status', '=', 1);
            $result->and_where_open();
            $result->or_where_open();
            foreach ($queries as $query) {
                $result->where(static::$table.'.name', 'LIKE', '%' . $query . '%');
            }
            $result->or_where_close();
            $result->or_where_open();
            foreach ($queries as $query) {
                $result->where(static::$table.'.artikul', 'LIKE', '%' . $query . '%');
            }
            $result->or_where_close();
            $result->or_where_open();
            foreach ($queries as $query) {
                $result->where('brands.name', 'LIKE', '%' . $query . '%');
            }
            $result->or_where_close();
            $result->and_where_close();
            return $result->count_all();
        }


        public static function getQueries($query) {
            $spaces = array('-', '_', '/', '\\', '=', '+', '*', '$', '@', '(', ')', '[', ']', '|', ',', '.', ';', ':', '{', '}');
            $query = str_replace($spaces, ' ', $query);
            $arr = preg_split("/[\s,]+/", $query);
            return $arr;
        }


        public static function getBrandItems($brand_alias, $sort = NULL, $type = NULL, $limit = NULL, $offset = NULL) {
            $result = DB::select(static::$table.'.*')
                ->from(static::$table)
                ->where(static::$table.'.brand_alias', '=', $brand_alias)
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


        public static function countBrandItems($brand_alias) {
            $result = DB::select(array(DB::expr('COUNT('.static::$table.'.id)'), 'count'))
                ->from(static::$table)
                ->where(static::$table.'.brand_alias', '=', $brand_alias)
                ->where(static::$table.'.status', '=', 1);
            return $result->count_all();
        }


        public static function getItemsByFlag($flag, $sort = NULL, $type = NULL, $limit = NULL, $offset = NULL) {
            $result = DB::select(static::$table.'.*')
                ->from(static::$table)
                ->where(static::$table.'.'.$flag, '=', 1)
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


        public static function countItemsByFlag($flag) {
            $result = DB::select(array(DB::expr('COUNT('.static::$table.'.id)'), 'count'))
                ->from(static::$table)
                ->where(static::$table.'.'.$flag, '=', 1)
                ->where(static::$table.'.status', '=', 1);
            return $result->count_all();
        }


        public static function addViewed( $id ) {
            $ids = static::getViewedIDs();
            if( !in_array($id, $ids) ) {
                $ids[] = $id;
                Cookie::setArray('viewed', $ids, 60*60*24*30);
            }
            return;
        }


        public static function getViewedIDs() {
            $ids = Cookie::getArray('viewed', array());
            return $ids;
        }


        public static function getViewedItems($sort = NULL, $type = NULL, $limit = NULL, $offset = NULL) {
            $ids = Items::getViewedIDs();
            if( !$ids ) {
                return array();
            }
            $result = DB::select(static::$table.'.*')
                ->from(static::$table)
                ->where(static::$table.'.id', 'IN', $ids)
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


        public static function countViewedItems() {
            $ids = Items::getViewedIDs();
            if( !$ids ) {
                return 0;
            }
            $result = DB::select(array(DB::expr('COUNT('.static::$table.'.id)'), 'count'))
                ->from(static::$table)
                ->where(static::$table.'.id', 'IN', $ids)
                ->where(static::$table.'.status', '=', 1);
            return $result->count_all();
        }


        public static function getRow($id) {
            $result = DB::select(
                static::$table.'.*',
                array('brands.name', 'brand_name'),
                array('models.name', 'model_name'),
                array('catalog_tree.name', 'parent_name')
            )
                ->from(static::$table)
                ->join('catalog_tree', 'LEFT')
                    ->on(static::$table.'.parent_id', '=', 'catalog_tree.id')
                ->join('brands', 'LEFT')
                    ->on(static::$table.'.brand_alias', '=', 'brands.alias')
                    ->on('brands.status', '=', DB::expr('1'))
                ->join('models', 'LEFT')
                    ->on(static::$table.'.model_alias', '=', 'models.alias')
                    ->on('models.status', '=', DB::expr('1'))
                ->where(static::$table.'.status', '=', 1)
                ->where(static::$table.'.id', '=', $id);
            return $result->find();
        }


        public static function getItemImages($item_id) {
            $result = DB::select('image')
                ->from(static::$tableImages)
                ->where(static::$tableImages.'.catalog_id', '=', $item_id)
                ->order_by(static::$tableImages.'.sort');
            return $result->find_all();
        }


        public static function getItemSpecifications($item_id, $parent_id) {
            $specifications = DB::select('specifications.*')->from('specifications')
                ->join('catalog_tree_specifications', 'LEFT')->on('catalog_tree_specifications.specification_id', '=', 'specifications.id')
                ->where('catalog_tree_specifications.catalog_tree_id', '=', $parent_id)
                ->where('specifications.status', '=', 1)
                ->order_by('specifications.name')
                ->as_object()->execute();
            $res = DB::select()->from('specifications_values')
                ->join('catalog_specifications_values', 'LEFT')->on('catalog_specifications_values.specification_value_alias', '=', 'specifications_values.alias')
                ->where('catalog_specifications_values.catalog_id', '=', $item_id)
                ->where('status', '=', 1)
                ->as_object()->execute();
            $specValues = array();
            foreach( $res AS $obj ) {
                $specValues[$obj->specification_id][] = $obj;
            }
            $spec = array();
            foreach ($specifications as $obj) {
                if( isset($specValues[$obj->id]) AND is_array($specValues[$obj->id]) AND count($specValues[$obj->id]) ) {
                    if( $obj->type_id == 3 ) {
                        $spec[$obj->name] = '';
                        foreach($specValues[$obj->id] AS $o) {
                            $spec[$obj->name] .= $o->name.', ';
                        }
                        $spec[$obj->name] = substr($spec[$obj->name], 0, -2);
                    } else {
                        $spec[$obj->name] = $specValues[$obj->id][0]->name;
                    }
                }
            }
            return $spec;
        }

    }