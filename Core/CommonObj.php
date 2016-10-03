<?php
    namespace Core;

    use Core\QB\DB;
    use Core\QB\Database;
    use Core\Validation\Valid;

    class CommonObj {

        public $_table;
        public $_image;
        public $_filters = array(); // Filter that gets parameters from global array $_GET. This is array with trusted filter keys
        public $_rules = array(); // Fields and their rules for validation

        public $_params = array();

        public $_sort = array();
        public $_type = array();
        public $_limit;
        public $_offset;

        public static function factory($table, $image = NULL) {
            return new CommonObj($table, $image);
        }

        public function __construct($table = NULL, $image = NULL) {
            if( $table !== NULL ) {
                $this->param('_table', $table);
            }
            if( $image !== NULL ) {
                $this->param('_image', $image);
            }
        }


        public function param($key, $value, $sign = '=') {
            if(property_exists($this, $key)) {
                if(is_array($this->$key)) {
                    $this->{$key}[] = $value;
                } else {
                    $this->$key = $value;
                }
            } else {
                $this->_params[$key] = array('sign' => $sign, 'value' => $value);
            }
            return $this;
        }


        public function sort($sort, $type = 'ASC') {
            return $this->param('_sort', $sort)->param('_type', $type);
        }


        public function limit($limit, $offset = NULL) {
            $this->_limit = $limit;
            if($offset !== NULL) {
                $this->_offset = $offset;
            }
            return $this;
        }


        /**
         * @param array $data - associative array with insert data
         * @return integer - inserted row ID
         */
        public function insert($data = array()) {
            if( !isset($data['created_at']) AND Common::checkField($this->_table, 'created_at')) {
                $data['created_at'] = time();
            }
            $keys = $values = array();
            foreach( $data AS $key => $value ) {
                $keys[] = $key;
                $values[] = $value;
            }
            $result = DB::insert($this->_table, $keys)->values($values)->execute();
            if( !$result ) {
                return false;
            }
            return $result[0];
        }


        /**
         * @param array $data - associative array with data to update
         * value - value for where clause
         * field - field for where clause
         * @return bool
         */
        public function update($data = array()) {
            if( !isset($data['updated_at']) AND Common::checkField($this->_table, 'updated_at') ) {
                $data['updated_at'] = time();
            }
            $result = DB::update($this->_table)->set($data);
            foreach($this->_params AS $key => $arr) {
                $result->where($key, $arr['sign'], $arr['value']);
            }
            return $result->execute();
        }


        /**
         * value - value
         * field - field
         * @return object
         */
        public function delete() {
            $result = DB::delete($this->_table);
            foreach($this->_params AS $key => $arr) {
                $result->where($key, $arr['sign'], $arr['value']);
            }
            return $result->execute();
        }


        /**
         * table - table where we check the field
         * field - check this field
         * @return bool
         */
        public function checkField($field) {
            $cResult = DB::query(Database::SELECT, 'SHOW FIELDS FROM `'.$this->_table.'`')->execute();
            $found = FALSE;
            foreach( $cResult AS $arr ) {
                if( $arr['Field'] == $field ) {
                    $found = TRUE;
                }
            }
            return $found;
        }


        /**
         * value - checked alias
         * id - ID if need off current row with ID = $id
         * @return string - unique alias
         */
        public function getUniqueAlias($value) {
            $value = Text::translit($value);
            $count = $this->param('alias', $value)->countRows();
            if($count) {
                return $value.rand(1000, 9999);
            }
            return $value;
        }


        /**
         * value - value
         * field - field
         * status - 0 or 1
         * @return object
         */
        public function getRow() {
            $result = DB::select()->from($this->_table);
            foreach($this->_params AS $key => $arr) {
                $result->where($key, $arr['sign'], $arr['value']);
            }
            return $result->find();
        }


        /**
         * status - 0 or 1
         * sort
         * type - ASC or DESC. No sort - no type
         * limit
         * offset - no limit - no offset
         * @return object
         */
        public function getRows() {
            $result = DB::select()->from($this->_table);
            foreach($this->_params AS $key => $arr) {
                $result->where($key, $arr['sign'], $arr['value']);
            }
            $result = $this->setFilter($result);
            foreach($this->_sort AS $i => $sort) {
                if(isset($this->_type[$i])) {
                    $result->order_by($sort, $this->_type[$i]);
                } else {
                    $result->order_by($sort);
                }
            }
            if( $this->_limit !== NULL ) {
                $result->limit($this->_limit);
                if( $this->_offset !== NULL ) {
                    $result->offset($this->_offset);
                }
            }
            return $result->find_all();
        }


        public function setFilter($result) {
            if (!is_array($this->_filters)) {
                return $result;
            }
            foreach ($this->_filters as $key => $value) {
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
                        $table = $this->_table;
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
         * status - 0 or 1
         * @return int
         */
        public function countRows() {
            $result = DB::select(array(DB::expr('COUNT('.$this->_table.'.id)'), 'count'))->from($this->_table);
            foreach($this->_params AS $key => $arr) {
                $result->where($key, $arr['sign'], $arr['value']);
            }
            $result = $this->setFilter($result);
            return $result->count_all();
        }


        /**
         * Upload images for current type
         * @param $name - name of the input in form for uploaded image
         * @param $field - field name in the table to save new image name
         * @return bool|object
         */
        public function uploadImage($name = 'file', $field = 'image') {
            if( !$this->_image ) {
                return false;
            }
            $filename = Files::uploadImage($this->_image, $name);
            if( !$filename ) {
                return false;
            }
            if( !$this->checkField($field) ) {
                return true;
            }
            $result = DB::update($this->_table)->set(array($field => $filename));
            foreach($this->_params AS $key => $arr) {
                $result->where($key, $arr['sign'], $arr['value']);
            }
            return $result->execute();
        }


        /**
         * Delete images for current type
         * @param $filename - file name
         * @param $field - field name in the table to save new image name
         * @return bool
         */
        public function deleteImage($filename, $field = 'image') {
            if( !$this->_image OR !$filename ) {
                return false;
            }
            $result = Files::deleteImage($this->_image, $filename);
            if( $result ) {
                return false;
            }
            if( !$this->checkField($field) ) {
                return true;
            }
            if( $this->_params ) {
                $result = DB::update($this->_table)->set(array($field => NULL));
                foreach($this->_params AS $key => $arr) {
                    $result->where($key, $arr['sign'], $arr['value']);
                }
                return $result->execute();
            }
            return true;
        }


        /**
         *  Adding +1 in field `views`
         *  row - object
         *  @return object
         */
        public function addView($row) {
            $row->views = $row->views + 1;
            $this->param('views', $row->views)->param('id', $row->id)->update();
            return $row;
        }


        /**
         * @param $data
         * @return bool
         */
        public function valid($data = array()) {
            if( !$this->_rules || !is_array($this->_rules) ) {
                return TRUE;
            }
            $valid = new Valid($data, $this->_rules);
            $errors = $valid->execute();
            if( !$errors ) {
                return TRUE;
            }
            $message = Valid::message($errors);
            Message::GetMessage(0, $message, FALSE);
            return FALSE;
        }
    }