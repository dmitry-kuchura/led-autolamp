<?php
    namespace Wezom\Modules\Blog\Models;

    use Core\QB\DB;

    class BlogComments extends \Core\Common {

        public static $table = 'blog_comments';
        public static $filters = array(
            'item_name' => array(
                'table' => 'blog',
                'action' => 'LIKE',
                'field' => 'name',
            ),
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
            'text' => array(
                array(
                    'error' => 'Сообщение не может быть пустым!',
                    'key' => 'not_empty',
                ),
            ),
            'blog_id' => array(
                array(
                    'error' => 'Выберите запись в блоге!',
                    'key' => 'digit',
                ),
            ),
            'date' => array(
                array(
                    'error' => 'Дата не может быть пустой!',
                    'key' => 'not_empty',
                ),
                array(
                    'error' => 'Укажите правильную дату!',
                    'key' => 'date',
                ),
            ),
        );

        public static function getRows($status = NULL, $date_s = NULL, $date_po = NULL, $sort = NULL, $type = NULL, $limit = NULL, $offset = NULL) {
            $result = DB::select('blog_comments.*', array('blog.name', 'blog_name'), array('blog.alias', 'blog_alias'), array('users.name', 'user_name'))
                ->from(static::$table)
                ->join('blog', 'LEFT')->on('blog.id', '=', 'blog_comments.blog_id')
                ->join('users', 'LEFT')->on('users.id', '=', 'blog_comments.user_id');
            $result = parent::setFilter($result);
            if( $status !== NULL ) {
                $result->where(static::$table.'.status', '=', $status);
            }
            if( $date_s ) {
                $result->where(static::$table . '.date', '>=', $date_s);
            }
            if( $date_po ) {
                $result->where(static::$table.'.date', '<=', $date_po + 24 * 60 * 60 - 1);
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
                $result->where(static::$table . '.date', '>=', $date_s);
            }
            if( $date_po ) {
                $result->where(static::$table.'.date', '<=', $date_po + 24 * 60 * 60 - 1);
            }
            return $result->count_all();
        }

    }