<?php
    namespace Wezom\Modules\User\Controllers;

    use Wezom\Modules\User\Models\Roles;
    use Core\Common;
    use Core\Config;
    use Core\Email;
    use Core\HTTP;
    use Core\Message;
    use Core\Route;
    use Core\Arr;
    use Core\Image;
    use Core\System;
    use Core\User;
    use Core\View;
    use Core\Pager\Pager;

    use Wezom\Modules\User\Models\Admins AS Model;
    use Core\Widgets;

    class Admins extends \Wezom\Modules\Base {

        public $tpl_folder = 'Users/Admins';
        public $page;
        public $limit;
        public $offset;
        public $aroles = array();

        function before() {
            parent::before();
            $this->_seo['h1'] = 'Администраторы';
            $this->_seo['title'] = 'Администраторы';
            $this->setBreadcrumbs('Администраторы', 'wezom/admins/index');
            $this->page = (int) Route::param('page') ? (int) Route::param('page') : 1;
            $this->limit = Config::get('static.limit_backend');
            $this->offset = ($this->page - 1) * $this->limit;
            $aroles = Roles::getBackendUsersRoles();
            foreach( $aroles AS $obj ) {
                $this->aroles[$obj->id] = $obj->name;
            }
        }


        function indexAction () {
            $status = NULL;
            if ( isset($_GET['status']) ) { $status = Arr::get($_GET, 'status', 1); }
            $page = (int) Route::param('page') ? (int) Route::param('page') : 1;
            $count = Model::countRows($status);
            $result = Model::getRows($status, 'users.id', 'DESC', $this->limit, ($page - 1) * $this->limit);
            $pager = Pager::factory( $page, $count, $this->limit )->create();
            $this->_toolbar = Widgets::get( 'Toolbar_List', array( 'addLink' => '/wezom/admins/add' ) );
            $this->_content = View::tpl(
                array(
                    'result' => $result,
                    'tpl_folder' => $this->tpl_folder,
                    'tablename' => Model::$table,
                    'count' => $count,
                    'pager' => $pager,
                    'pageName' => $this->_seo['h1'],
                    'roles' => $this->aroles,
                ), $this->tpl_folder.'/Index');
        }


        function addAction () {
            if ($_POST) {
                $post = $_POST['FORM'];
                $post['status'] = Arr::get( $_POST, 'status', 0 );
                if( Model::valid($post) ) {
                    $res = Model::insert($post);
                    if($res) {
                        User::factory()->update_password($res, Arr::get($_POST, 'password'));
                        Message::GetMessage(1, 'Вы успешно добавили данные!');
                        if(Arr::get($_POST, 'button', 'save') == 'save-close') {
                            HTTP::redirect('wezom/'.Route::controller().'/index');
                        } else if(Arr::get($_POST, 'button', 'save') == 'save-add') {
                            HTTP::redirect('wezom/'.Route::controller().'/add');
                        } else {
                            HTTP::redirect('wezom/' . Route::controller() . '/edit/' . $res);
                        }
                    } else {
                        Message::GetMessage(0, 'Не удалось добавить данные!');
                    }
                }
                $result = Arr::to_object($post);
            } else {
                $result = array();
            }
            $this->_toolbar = Widgets::get( 'Toolbar_Edit', array('list_link' => '/wezom/admins/index') );
            $this->_seo['h1'] = 'Добавление';
            $this->_seo['title'] = 'Добавление';
            $this->setBreadcrumbs('Добавление', 'wezom/admins/add');
            $this->_content = View::tpl(
                array(
                    'obj' => $result,
                    'tpl_folder' => $this->tpl_folder,
                    'roles' => $this->aroles,
                ), $this->tpl_folder.'/Form');
        }


        function editAction () {
            if ($_POST) {
                $post = $_POST['FORM'];
                $post['status'] = Arr::get( $_POST, 'status', 0 );
                if( Model::valid($post) ) {
                    $res = Model::update($post, Route::param('id'));
                    if($res) {
                        if( trim(Arr::get($_POST, 'password')) ) {
                            User::factory()->update_password(Route::param('id'), Arr::get($_POST, 'password'));
                        }
                        Message::GetMessage(1, 'Вы успешно добавили данные!');
                        if(Arr::get($_POST, 'button', 'save') == 'save-close') {
                            HTTP::redirect('wezom/'.Route::controller().'/index');
                        } else if(Arr::get($_POST, 'button', 'save') == 'save-add') {
                            HTTP::redirect('wezom/'.Route::controller().'/add');
                        } else {
                            HTTP::redirect('wezom/' . Route::controller() . '/edit/' . Route::param('id'));
                        }
                    } else {
                        Message::GetMessage(0, 'Не удалось добавить данные!');
                    }
                }
                $result = Arr::to_object($post);
            } else {
                $result = Model::getRow(Route::param('id'));
            }
            if( isset($result->deleted) && $result->deleted ) {
                $this->_toolbar = Widgets::get( 'Toolbar_Edit', array('list_link' => '/wezom/archive/admins') );
            } else {
                $this->_toolbar = Widgets::get( 'Toolbar_Edit', array('list_link' => '/wezom/admins/index') );
            }
            $this->_seo['h1'] = 'Редактирование';
            $this->_seo['title'] = 'Редактирование';
            $this->setBreadcrumbs('Редактирование', 'wezom/admins/edit/'.Route::param('id'));
            $this->_content = View::tpl(
                array(
                    'obj' => $result,
                    'tpl_folder' => $this->tpl_folder,
                    'roles' => $this->aroles,
                ), $this->tpl_folder.'/Form');
        }

        function deleteAction() {
            $id = (int) Route::param('id');
            $page = Model::getRow($id);
            if(!$page) {
                Message::GetMessage(0, 'Данные не существуют!');
                HTTP::redirect('wezom/admins/index');
            }
            Model::delete($id);
            Message::GetMessage(1, 'Данные удалены!');
            HTTP::redirect('wezom/admins/index');
        }

    }