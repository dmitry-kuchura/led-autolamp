<?php
    namespace Wezom\Modules\User\Models;

    use Core\Config;
    use Core\Arr;
    use Core\Message;
    use Core\QB\DB;
    use Core\Route;

    class Admins extends \Core\Common {

        public static $table = 'users';
        public static $rules = array(
            'name' => array(
                array(
                    'error' => 'Имя не может быть пустым!',
                    'key' => 'not_empty',
                ),
            ),
            'login' => array(
                array(
                    'error' => 'Поле "Логин" введено некорректно!',
                    'key' => 'not_empty',
                ),
                array(
                    'error' => 'Поле "Логин" должно быть уникальным!',
                    'key' => 'unique',
                    'value' => 'users',
                ),
            ),
        );

        public static function getRows($status = NULL, $sort = NULL, $type = NULL, $limit = NULL, $offset = NULL) {
            $result = DB::select()->from(static::$table)->where('role_id', 'NOT IN', array(1, 3, 4));
            $result = parent::setFilter($result);
            if( $status !== NULL ) {
                $result->where(static::$table.'.status', '=', $status);
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
                if( $offset !== NULL ) {
                    $result->offset($offset);
                }
            }
            return $result->find_all();
        }

        public static function countRows($status = NULL) {
            $result = DB::select(array(DB::expr('COUNT('.static::$table.'.id)'), 'count'))->from(static::$table)->where('role_id', 'NOT IN', array(1, 3, 4));
            $result = parent::setFilter($result);
            if( $status !== NULL ) {
                $result->where(static::$table.'.status', '=', $status);
            }
            return $result->count_all();
        }

        public static function valid($post) {
            if(Arr::get($_POST, 'password') AND mb_strlen(Arr::get($_POST, 'password'), 'UTF-8') < Config::get('main.password_min_length')) {
                Message::GetMessage(0, 'Пароль должен быть не короче '.Config::get('main.password_min_length').' символов!');
                return FALSE;
            }
            return parent::valid($post);
        }

    }