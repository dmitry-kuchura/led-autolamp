<?php
    namespace Wezom\Modules\Config\Controllers;

    use Core\Arr;
    use Core\HTML;
    use Core\QB\DB;
    use Core\Route;
    use Core\Validation\Valid;
    use Core\Widgets;
    use Core\Message;
    use Core\HTTP;
    use Core\View;
    use Core\Common;

    class Config extends \Wezom\Modules\Base {

        public $tpl_folder = 'Config';

        function before() {
            parent::before();
            $this->_seo['h1'] = 'Настройки сайта';
            $this->_seo['title'] = 'Настройки сайта';
            $this->setBreadcrumbs('Настройки сайта', 'wezom/'.Route::controller().'/index');
        }

        function editAction () {
            if ($_POST) {
                $result = Common::factory('config')->getRows(1);
                $errors = array();
                foreach($result AS $obj) {
                    if (array_key_exists($obj->group.'-'.$obj->key, $_POST)) {
                        $value = Arr::get($_POST, $obj->group.'-'.$obj->key);
                        if( $value === NULL && $obj->valid ) {
                            $errors[] = 'Параметр "'.$obj->name.'" должен быть заполнен!';
                        }
                    } else if($obj->type != 'checkbox') {
                        $errors[] = 'Параметр "'.$obj->name.'" должен быть заполнен!';
                    }
                }
                if( !$errors ) {
                    foreach($result AS $obj) {
                        if (array_key_exists($obj->group.'-'.$obj->key, $_POST)) {
                            $value = Arr::get($_POST, $obj->group.'-'.$obj->key);
                            DB::update('config')->set(array(
                                'zna' => $value
                            ))->where('key', '=', $obj->key)->where('group', '=', $obj->group)->execute();
                        } else if($obj->type == 'checkbox') {
                            DB::update('config')->set(array(
                                'zna' => 0
                            ))->where('key', '=', $obj->key)->where('group', '=', $obj->group)->execute();
                        }
                    }
                    Message::GetMessage(1, 'Вы успешно изменили данные!');
                    HTTP::redirect( 'wezom/'.Route::controller().'/edit' );
                }
                Message::GetMessage(0, Valid::message($errors), FALSE);
            }
            $result = Common::factory('config')->getRows(1, 'sort', 'ASC');
            $arr = array();
            foreach($result AS $obj) {
                $arr[$obj->group][] = $obj;
            }
            $_groups = Common::factory('config_groups')->getRows(1, 'sort', 'ASC');
            $groups = array();
            foreach($_groups AS $group) {
                $groups[$group->side][] = $group;
            }
            $this->_toolbar = Widgets::get( 'Toolbar_EditSaveOnly' );
            $this->_content = View::tpl(
                array(
                    'result' => $arr,
                    'groups' => $groups,
                ), $this->tpl_folder.'/Edit');
        }
    }