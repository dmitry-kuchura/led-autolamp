<?php
    namespace Wezom\Modules\Content\Controllers;

    use Core\Route;
    use Core\Widgets;
    use Core\View;
    use Core\Message;
    use Core\HTTP;
    use Core\Support;
    use Core\Arr;

    use Wezom\Modules\Content\Models\Content AS Model;

    class Content extends \Wezom\Modules\Base {

        public $tpl_folder = 'Content/Pages'; // Tpl folder

        function before() {
            parent::before();
            $this->_seo['h1'] = 'Страницы';
            $this->_seo['title'] = 'Страницы';
            $this->setBreadcrumbs('Страницы', 'wezom/'.Route::controller().'/index');
        }

        function indexAction () {
            $result = Model::getRows(NULL, 'sort', 'ASC');
            $arr = array();
            foreach($result AS $obj) {
                $arr[$obj->parent_id][] = $obj;
            }
            $this->_filter = Widgets::get( 'Filter/Pages', array( 'open' => 1 ) );
            $this->_toolbar = Widgets::get( 'Toolbar/List', array( 'add' => 1, 'delete' => 1 ) );
            $this->_content = View::tpl(
                array(
                    'result'        => $arr,
                    'tpl_folder'    => $this->tpl_folder,
                    'tablename'     => Model::$table,
                ), $this->tpl_folder.'/Index');
        }

        function editAction () {
            if ($_POST) {
                $post = $_POST['FORM'];
                $post['status'] = Arr::get( $_POST, 'status', 0 );
                if( Model::valid($post) ) {
                    $post['alias'] = Model::getUniqueAlias(Arr::get($post, 'alias'), Route::param('id'));
                    $res = Model::update($post, Route::param('id'));
                    if ($res) {
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
                $result = Arr::to_object($post);
            } else {
                $result = Model::getRow((int) Route::param('id'));
            }

            $this->_toolbar = Widgets::get( 'Toolbar/Edit' );
            $this->_seo['h1'] = 'Редактирование';
            $this->_seo['title'] = 'Редактирование';
            $this->setBreadcrumbs('Редактирование', 'wezom/'.Route::controller().'/'.Route::action().'/'.Route::param('id'));

            $this->_content = View::tpl(
                array(
                    'obj' => $result,
                    'tpl_folder' => $this->tpl_folder,
                    'tree' => Support::getSelectOptions('Content/Pages/Select', 'content', $result->parent_id),
                ), $this->tpl_folder.'/Form');
        }
        
        function addAction () {
            if ($_POST) {
                $post = $_POST['FORM'];
                $post['status'] = Arr::get( $_POST, 'status', 0 );
                if( Model::valid($post) ) {
                    $post['alias'] = Model::getUniqueAlias(Arr::get($post, 'alias'));
                    $res = Model::insert($post);
                    if($res) {
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

            $this->_toolbar = Widgets::get( 'Toolbar/Edit' );
            $this->_seo['h1'] = 'Добавление';
            $this->_seo['title'] = 'Добавление';
            $this->setBreadcrumbs('Добавление', 'wezom/'.Route::controller().'/'.Route::action());

            $this->_content = View::tpl(
                array(
                    'obj' => $result,
                    'tpl_folder' => $this->tpl_folder,
                    'tree' => Support::getSelectOptions('Content/Pages/Select', 'content', $result->parent_id),
                ), $this->tpl_folder.'/Form');
        }

        function deleteAction() {
            $id = (int) Route::param('id');
            $page = Model::getRow($id);
            if(!$page) {
                Message::GetMessage(0, 'Данные не существуют!');
                HTTP::redirect('wezom/'.Route::controller().'/index');
            }
            Model::update(array( 'parent_id' => $page->parent_id ), $id, 'parent_id');
            Model::delete($id);
            Message::GetMessage(1, 'Данные удалены!');
            HTTP::redirect('wezom/'.Route::controller().'/index');
        }
    }