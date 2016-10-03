<?php
    namespace Wezom\Modules\Blog\Models;

    use Core\Arr;
    use Core\HTML;
    use Core\Message;
    use Core\QB\DB;

    class Blog extends \Core\Common {

        public static $table = 'blog';
        public static $image = 'blog';
        public static $filters = array(
            'name' => array(
                'table' => NULL,
                'action' => 'LIKE',
            ),
            'rubric_id' => array(
                'table' => NULL,
                'action' => '=',
            ),
        );
        public static $rules = array(
            'name' => array(
                array(
                    'error' => 'Название новости не может быть пустым!',
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

        public static function getRow($value, $field = 'id', $status = NULL) {
            $result = DB::select('blog.*', array('blog_rubrics.name', 'rubric'))
                ->from(static::$table)
                ->join('blog_rubrics', 'LEFT')->on('blog_rubrics.id', '=', 'blog.rubric_id')
                ->where('blog.'.$field, '=', $value);
            if( $status !== NULL ) {
                $result->where('blog.status', '=', $status);
            }
            return $result->find();
        }

        public static function getRows($status = NULL, $date_s = NULL, $date_po = NULL, $sort = NULL, $type = NULL, $limit = NULL, $offset = NULL, $filter = true) {
            $result = DB::select('blog.*', array('blog_rubrics.name', 'rubric'))->from(static::$table)->join('blog_rubrics', 'LEFT')->on('blog_rubrics.id', '=', 'blog.rubric_id');
            if( $status !== NULL ) {
                $result->where(static::$table.'.status', '=', $status);
            }
            if( $date_s ) {
                $result->where(static::$table . '.date', '>=', $date_s);
            }
            if( $date_po ) {
                $result->where(static::$table.'.date', '<=', $date_po + 24 * 60 * 60 - 1);
            }
            if( $filter ) {
                $result = static::setFilter($result);
            }
            if( $sort !== NULL ) {
                if( $type !== NULL ) {
                    $result->order_by('blog.'.$sort, $type);
                } else {
                    $result->order_by('blog.'.$sort);
                }
            }
            $result->order_by('blog.id', 'DESC');
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
            $result = parent::setFilter($result);
            return $result->count_all();
        }

        public static function valid($post) {
            if( !trim(Arr::get($post, 'alias')) ) {
                Message::GetMessage(0, 'Алиас не может быть пустым!');
                return 0;
            }
            if( !trim(Arr::get($post, 'date')) OR !strtotime(Arr::get($post, 'date')) ) {
                Message::GetMessage(0, 'Дата не может быть пустой!');
                return 0;
            }
            if( !trim(Arr::get($post, 'name')) ) {
                Message::GetMessage(0, 'Наименование страницы не может быть пустым!');
                return 0;
            }
            return 1;
        }

    }