<?php
    namespace Wezom\Modules\Seo\Controllers;

    use Core\Route;
    use Core\Widgets;
    use Core\View;
    use Core\Message;
    use Core\HTTP;
    use Core\Arr;

    use Wezom\Modules\Seo\Models\Scripts AS Model;

    class Scripts extends \Wezom\Modules\Base {

        public $tpl_folder = 'Seo/Scripts';

        function before() {
            parent::before();
            $this->_seo['h1'] = 'Метрика и счетчики';
            $this->_seo['title'] = 'Метрика и счетчики';
            $this->setBreadcrumbs('Метрика и счетчики', 'wezom/seo_scripts/index');
        }

        function indexAction () {
            $result = Model::getRows(NULL, 'id', 'DESC');
            $this->_filter = Widgets::get( 'Filter_Pages' );
            $this->_toolbar = Widgets::get( 'Toolbar_List', array( 'addLink' => '/wezom/seo_scripts/add', 'delete' => 1 ) );
            $this->_content = View::tpl(
                array(
                    'result'        => $result,
                    'tpl_folder'    => $this->tpl_folder,
                    'tablename'     => Model::$table,
                ), $this->tpl_folder.'/Index');
        }

        function editAction () {
            if ($_POST) {
                $post = $_POST['FORM'];
                $post['status'] = Arr::get( $_POST, 'status', 0 );
                if( Model::valid($post) ) {
                    $res = Model::update($post, Route::param('id'));
                    if($res) {
                        Message::GetMessage(1, 'Вы успешно изменили данные!');
                        switch (Arr::get($_POST, 'button', 'save')) {
                        case 'save-close':
                            HTTP::redirect('wezom/' . Route::controller() . '/index');
                            break;
                        case 'save-add':
                            HTTP::redirect('wezom/' . Route::controller() . '/add');
                            break;
                        default:
                            HTTP::redirect('wezom/' . Route::controller() . '/edit/' . Route::param('id'));
                            break;
                        }
                    } else {
                        Message::GetMessage(0, 'Не удалось изменить данные!');
                    }
                }
                $result     = Arr::to_object($post);
            } else {
                $result = Model::getRow(Route::param('id'));
            }
            $this->_toolbar = Widgets::get( 'Toolbar_Edit', array('list_link' => '/wezom/seo_scripts/index') );
            $this->_seo['h1'] = 'Редактирование';
            $this->_seo['title'] = 'Редактирование';
            $this->setBreadcrumbs('Редактирование', 'wezom/seo_scripts/edit/'.Route::param('id'));
            $this->_content = View::tpl(
                array(
                    'obj' => $result,
                    'tpl_folder' => $this->tpl_folder,
                ), $this->tpl_folder.'/Form');
        }

        function addAction () {
            if ($_POST) {
                $post = $_POST['FORM'];
                $post['status'] = Arr::get( $_POST, 'status', 0 );
                if( Model::valid($post) ) {
                    $res = Model::insert($post);
                    if($res) {
                        Message::GetMessage(1, 'Вы успешно добавили данные!');
                        if(Arr::get($_POST, 'button', 'save') == 'save-close') {
                            HTTP::redirect('wezom/seo_scripts/index');
                        } else if(Arr::get($_POST, 'button', 'save') == 'save-add') {
                            HTTP::redirect('wezom/seo_scripts/add');
                        } else {
                            HTTP::redirect('wezom/seo_scripts/edit/' . $res);
                        }
                    } else {
                        Message::GetMessage(0, 'Не удалось добавить данные!');
                    }
                }
                $result = Arr::to_object($post);
            } else {
                $result = array();
            }
            $this->_toolbar = Widgets::get( 'Toolbar_Edit', array('list_link' => '/wezom/seo_scripts/index') );
            $this->_seo['h1'] = 'Добавление';
            $this->_seo['title'] = 'Добавление';
            $this->setBreadcrumbs('Добавление', 'wezom/seo_scripts/add');
            $this->_content = View::tpl(
                array(
                    'obj' => $result,
                    'tpl_folder' => $this->tpl_folder,
                ), $this->tpl_folder.'/Form');
        }

        function deleteAction() {
            $id = (int) Route::param('id');
            $page = Model::getRow($id);
            if(!$page) {
                Message::GetMessage(0, 'Данные не существуют!');
                HTTP::redirect('wezom/seo_scripts/index');
            }
            Model::delete($id);
            Message::GetMessage(1, 'Данные удалены!');
            HTTP::redirect('wezom/seo_scripts/index');
        }

    }