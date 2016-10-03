<?php
    namespace Core;

    use Core\QB\DB;
    use Core\QB\Database;
    use Core\Validation\Valid;

    class Common {

        public static $table;
        public static $image;
        public static $filters = array(); // Filter that gets parameters from global array $_GET. This is array with trusted filter keys
        public static $rules = array(); // Fields and their rules for validation

        public static function factory($table, $image = NULL) {
            return new Common($table, $image);
        }

        public function __construct($table = NULL, $image = NULL) {
            if( $table !== NULL ) {
                static::$table = $table;
            }
            if( $image !== NULL ) {
                static::$image = $image;
            }
        }


        public static function table() {
            return static::$table;
        }


        public static function image() {
            return static::$image;
        }


        /**
         * @param null $ip - current ip
         * @param null $email - email in POST
         * @param null $phone - phone in POST
         * @param null $date - 0 or 1 (60 seconds timeout)
         * @return int
         */
        public static function isBot($ip = NULL, $email = NULL, $phone = NULL, $date = NULL) {
            if( $ip === NULL && $email === NULL && $phone === NULL && $date === NULL ) {
                return false;
            }
            $result = DB::select(array(DB::expr('COUNT(id)'), 'count'))->from(static::$table);
            $result->where_open();
            if( $ip !== NULL ) {
                $result->or_where('ip', '=', $ip);
            }
            if( $email !== NULL ) {
                $result->or_where('email', '=', $email);
            }
            if( $phone !== NULL ) {
                $result->or_where('phone', '=', $phone);
            }
            $result->where_close();
            if( $date !== NULL ) {
                $result->where('created_at', '>', time() - 60);
            }
            return $result->count_all();
        }


        /**
         * @param array $data - associative array with insert data
         * @return integer - inserted row ID
         */
        public static function insert( $data ) {
            if( !isset($data['created_at']) AND Common::checkField(static::$table, 'created_at')) {
                $data['created_at'] = time();
            }
            $keys = $values = array();
            foreach( $data AS $key => $value ) {
                $keys[] = $key;
                $values[] = $value;
            }
            $result = DB::insert(static::$table, $keys)->values($values)->execute();
            if( !$result ) {
                return false;
            }
            return $result[0];
        }


        /**
         * @param array $data - associative array with data to update
         * @param string/integer $value - value for where clause
         * @param string $field - field for where clause
         * @return bool
         */
        public static function update( $data, $value, $field = 'id' ) {
            if( !isset($data['updated_at']) AND Common::checkField(static::$table, 'updated_at') ) {
                $data['updated_at'] = time();
            }
            return DB::update(static::$table)->set($data)->where($field, '=', $value)->execute();
        }


        /**
         * @param mixed $value - value
         * @param string $field - field
         * @return object
         */
        public static function delete($value, $field = 'id') {
            return DB::delete(static::$table)->where($field, '=', $value)->execute();
        }


        /**
         * @param string $table - table where we check the field
         * @param string $field - check this field
         * @return bool
         */
        public static function checkField($table, $field) {
            $cResult = DB::query(Database::SELECT, 'SHOW FIELDS FROM `'.$table.'`')->execute();
            $found = FALSE;
            foreach( $cResult AS $arr ) {
                if( $arr['Field'] == $field ) {
                    $found = TRUE;
                }
            }
            return $found;
        }


        /**
         * @param string $value - checked alias
         * @param int $id - ID if need off current row with ID = $id
         * @return string - unique alias
         */
        public static function getUniqueAlias($value, $id = NULL) {
            $value = Text::translit($value);
            $count = DB::select(array(DB::expr('COUNT(id)'), 'count'))
                ->from(static::$table)
                ->where('alias', '=', $value);
            if( $id !== NULL ) {
                $count->where('id', '!=', $id);
            }
            $count = $count->count_all();
            if($count) {
                return $value.rand(1000, 9999);
            }
            return $value;
        }


        /**
         * @param mixed $value - value
         * @param string $field - field
         * @param null/integer $status - 0 or 1
         * @return object
         */
        public static function getRow($value, $field = 'id', $status = NULL) {
            $result = DB::select()->from(static::$table)->where($field, '=', $value);
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
        public static function getRows($status = NULL, $sort = NULL, $type = NULL, $limit = NULL, $offset = NULL, $filter = true) {
            $result = DB::select()->from(static::$table);
            if( $status !== NULL ) {
                $result->where('status', '=', $status);
            }
            if( $filter ) {
                $result = static::setFilter($result);
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


        public static function setFilter($result) {
            if (!is_array(static::$filters)) {
                return $result;
            }
            foreach (static::$filters as $key => $value) {
                if (isset($key) && isset($_GET[$key]) && trim($_GET[$key])) {
                    $get = strip_tags($_GET[$key]);
                    $get = trim($get);
                    if (!Arr::get($value, 'action', NULL)) {
                        $action = '=';
                    } else {
                        $action = Arr::get($value, 'action');
                    }
                    $table = false;
                    if (Arr::get($value, 'table', NULL)) {
                        $table = Arr::get($value, 'table');
                    } else if(Arr::get($value, 'table', NULL) === NULL) {
                        $table = static::$table;
                    }
                    if ($action == 'LIKE') {
                        $get = '%'.$get.'%';
                    }
                    if( Arr::get($value, 'field') ) {
                        $key = Arr::get($value, 'field');
                    }
                    if ($table !== false) {
                        $result->where($table.'.'.$key, $action, $get);
                    } else {
                        $result->where(DB::expr($key), $action, $get);
                    }
                }
            }
            return $result;
        }


        /**
         * @param null/integer $status - 0 or 1
         * @return int
         */
        public static function countRows($status = NULL, $filter = true) {
            $result = DB::select(array(DB::expr('COUNT('.static::$table.'.id)'), 'count'))->from(static::$table);
            if( $status !== NULL ) {
                $result->where(static::$table.'.status', '=', $status);
            }
            if( $filter ) {
                $result = static::setFilter($result);
            }
            return $result->count_all();
        }


        /**
         * Upload images for current type
         * @param integer $id - ID in the table for this image
         * @param string $name - name of the input in form for uploaded image
         * @param string $field - field name in the table to save new image name
         * @return bool|object
         */
        public static function uploadImage($id, $name = 'file', $field = 'image') {
            if( !static::$image OR !$id ) {
                return false;
            }
            $filename = Files::uploadImage(static::$image, $name);
            if( !$filename ) {
                return false;
            }
            if( !Common::checkField(static::$table, $field) ) {
                return true;
            }
            return DB::update(static::$table)->set(array($field => $filename))->where(static::$table.'.id', '=', $id)->execute();
        }


        /**
         * Delete images for current type
         * @param string $filename - file name
         * @param null|integer $id - ID in the table for this image
         * @param string $field - field name in the table to save new image name
         * @return bool
         */
        public static function deleteImage($filename, $id = NULL, $field = 'image') {
            if( !static::$image OR !$filename ) {
                return false;
            }
            $result = Files::deleteImage(static::$image, $filename);
            if( !$result ) {
                return false;
            }
            if( !Common::checkField(static::$table, $field) ) {
                return true;
            }
            if( $id !== NULL ) {
                return DB::update(static::$table)->set(array($field => NULL))->where(static::$table.'.id', '=', $id)->execute();
            }
            return true;
        }


        /**
         *  Adding +1 in field `views`
         *  @param object $row - object
         *  @return object
         */
        public static function addView($row) {
            $row->views = $row->views + 1;
            static::update(array('views' => $row->views), $row->id);
            return $row;
        }


        /**
         * @param array $data
         * @return bool
         */
        public static function valid($data = array()) {
            if( !static::$rules ) {
                return TRUE;
            }
            $valid = new Valid($data, static::$rules);
            $errors = $valid->execute();
            if( !$errors ) {
                return TRUE;
            }
            $message = Valid::message($errors);
            Message::GetMessage(0, $message, FALSE);
            return FALSE;
        }
    }