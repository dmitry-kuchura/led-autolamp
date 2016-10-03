<?php
    namespace Wezom\Modules\Orders\Models;

    use Core\QB\DB;
    use Core\Arr;
    use Core\Message;
    use Core\Validation\Valid;

    class Orders extends \Core\Common {

        public static $table = 'orders';
        public static $filters = array(
            'uid' => array(
                'action' => '=',
                'field' => 'user_id',
            ),
        );
        public static $rules = array(
            'name' => array(
                array(
                    'error' => 'Имя не может быть пустым!',
                    'key' => 'not_empty',
                ),
            ),
            'last_name' => array(
                array(
                    'error' => 'Фамилия не может быть пустым!',
                    'key' => 'not_empty',
                ),
            ),
            'email' => array(
                array(
                    'error' => 'E-Mail не может быть пустым!',
                    'key' => 'not_empty',
                ),
                array(
                    'error' => 'E-Mail указан некорректно!',
                    'key' => 'email',
                ),
            ),
            'phone' => array(
                array(
                    'error' => 'Укажите верный номер телефона!',
                    'key' => 'not_empty',
                ),
            ),
            'delivery' => array(
                array(
                    'error' => 'Укажите корректный способ доставки!',
                    'key' => 'regexp',
                    'value' => '/1|2/',
                ),
            ),
            'payment' => array(
                array(
                    'error' => 'Укажите корректный способ оплаты!',
                    'key' => 'regexp',
                    'value' => '/1|2/',
                ),
            ),
        );


        public static function getRow($value) {
            $result = DB::select(
                static::$table.'.*',
                array(DB::expr('SUM(orders_items.count)'), 'count'),
                array(DB::expr('SUM(orders_items.cost * orders_items.count)'), 'amount')
            )
                ->from(static::$table)
                ->join('orders_items', 'LEFT')->on('orders_items.order_id', '=', static::$table.'.id')
                ->where(static::$table.'.id', '=', $value);
            return $result->find();
        }


        public static function getRows($status = NULL, $date_s = NULL, $date_po = NULL, $sort = NULL, $type = NULL, $limit = NULL, $offset = NULL) {
            $result = DB::select(
                static::$table.'.*',
                array(DB::expr('SUM(orders_items.count)'), 'count'),
                array(DB::expr('SUM(orders_items.cost * orders_items.count)'), 'amount')
            )
                ->from(static::$table)
                ->join('orders_items', 'LEFT')->on('orders_items.order_id', '=', static::$table.'.id');
            if( $status !== NULL ) {
                $result->where(static::$table.'.status', '=', $status);
            }
            if( $date_s ) {
                $result->where(static::$table . '.created_at', '>=', $date_s);
            }
            if( $date_po ) {
                $result->where(static::$table.'.created_at', '<=', $date_po + 24 * 60 * 60 - 1);
            }
            $result = parent::setFilter($result);
            $result->group_by(static::$table.'.id');
            if( $sort !== NULL ) {
                if( $type !== NULL ) {
                    $result->order_by($sort, $type);
                } else {
                    $result->order_by($sort);
                }
            }
            if( $limit !== NULL ) {
                $result->limit($limit);
            }
            if( $offset !== NULL ) {
                $result->offset($offset);
            }
            return $result->find_all();
        }


        public static function countRows($status = NULL, $date_s = NULL, $date_po = NULL) {
            $result = DB::select(array(DB::expr('COUNT('.static::$table.'.id)'), 'count'))->from(static::$table);
            if( $status !== NULL ) {
                $result->where(static::$table.'.status', '=', $status);
            }
            if( $date_s ) {
                $result->where(static::$table . '.created_at', '>=', $date_s);
            }
            if( $date_po ) {
                $result->where(static::$table.'.created_at', '<=', $date_po + 24 * 60 * 60 - 1);
            }
            $result = parent::setFilter($result);
            return $result->count_all();
        }


        public static function getAmount($status = NULL, $date_s = NULL, $date_po = NULL) {
            $result = DB::select(array(DB::expr('SUM(orders_items.count * orders_items.cost)'), 'amount'))
                ->from(static::$table)
                ->join('orders_items')->on('orders_items.order_id', '=', 'orders.id');
            if( $status !== NULL ) {
                $result->where(static::$table.'.status', '=', $status);
            }
            if( $date_s ) {
                $result->where(static::$table . '.created_at', '>=', $date_s);
            }
            if( $date_po ) {
                $result->where(static::$table.'.created_at', '<=', $date_po + 24 * 60 * 60 - 1);
            }
            $result = parent::setFilter($result);
            return (int) $result->find()->amount;
        }

    }