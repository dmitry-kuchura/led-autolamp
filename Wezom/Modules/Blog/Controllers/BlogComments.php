<?php
    namespace Wezom\Modules\Blog\Controllers;

    use Core\Common;
    use Core\Config;
    use Core\HTML;
    use Core\Route;
    use Core\Widgets;
    use Core\Message;
    use Core\Arr;
    use Core\HTTP;
    use Core\View;
    use Core\Pager\Pager;

    use Wezom\Modules\Blog\Models\Blog;
    use Wezom\Modules\Blog\Models\BlogComments AS Model;
    use Wezom\Modules\Blog\Models\BlogRubrics;

    class BlogComments extends \Wezom\Modules\Base {

        public $tpl_folder = 'Blog/Comments';
        public $limit;

        function before() {
            parent::before();
            $this->_seo['h1'] = 'Комментарии';
            $this->_seo['title'] = 'Комментарии';
            $this->setBreadcrumbs('Комментарии', 'wezom/'.Route::controller().'/index');
            $this->limit = (int) Arr::get($_GET, 'limit', Config::get('basic.limit_backend')) < 1 ?: Arr::get($_GET, 'limit', Config::get('basic.limit_backend'));
        }

        function indexAction () {
            if(Arr::get($_GET, 'uid')) {
                $user = Common::factory('users')->getRow(Arr::get($_GET, 'uid'));
                if($user) {
                    $name = trim($user->last_name.' '.$user->name);
                    $name = $name ?: '#'.$user->id;
                    $this->setBreadcrumbs('Комментарии '.($user->partner ? 'партнера' : 'пользователя').' '.$name);
                }
            }
            $date_s = NULL; $date_po = NULL; $status = NULL;
            if ( Arr::get($_GET, 'date_s') ) { $date_s = strtotime( Arr::get($_GET, 'date_s') ); }
            if ( Arr::get($_GET, 'date_po') ) { $date_po = strtotime( Arr::get($_GET, 'date_po') ); }
            if ( isset($_GET['status']) && $_GET['status'] != '' ) { $status = Arr::get($_GET, 'status', 1); }
            $page = (int) Route::param('page') ? (int) Route::param('page') : 1;
            $count = Model::countRows($status, $date_s, $date_po);
            $result = Model::getRows($status, $date_s, $date_po, 'id', 'DESC', $this->limit, ($page - 1) * $this->limit);
            $pager = Pager::factory( $page, $count, $this->limit )->create();
            $this->_toolbar = Widgets::get( 'Toolbar/List', array( 'delete' => 1, 'add' => 1 ) );
            $this->_content = View::tpl(
                array(
                    'result' => $result,
                    'tpl_folder' => $this->tpl_folder,
                    'tablename' => Model::$table,
                    'count' => $count,
                    'pager' => $pager,
                    'pageName' => $this->_seo['h1'],
                ), $this->tpl_folder.'/Index');
        }

        function editAction () {
            Model::update(array('watched' => 1), Route::param('id'));
            if ($_POST) {
                $post = $_POST['FORM'];
                $post['status'] = Arr::get( $_POST, 'status', 0 );
                $post['blog_id'] = Arr::get($_POST, 'blog_id');
                if( Model::valid($post) ) {
                    $post['date'] = strtotime($post['date']);
                    $post['date_answer'] = strtotime($post['date_answer']) ? strtotime($post['date_answer']) : NULL;
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
                $result = Arr::to_object($post);
            } else {
                $result = Model::getRow(Route::param('id'));
            }
            $this->_toolbar = Widgets::get( 'Toolbar_Edit' );
            $this->_seo['h1'] = 'Редактирование';
            $this->_seo['title'] = 'Редактирование';

            if($result->user_id) {
                $user = Common::factory('users')->getRow($result->user_id);
                if($user) {
                    $name = trim($user->last_name.' '.$user->name);
                    $name = $name ?: '#'.$user->id;
                    $this->setBreadcrumbs('Комментарии '.($user->partner ? 'партнера' : 'пользователя').' '.$name, HTML::link('wezom/'.Route::controller().'/index?uid='.$user->id));
                }
            }
            $this->setBreadcrumbs('Редактирование');

            $this->_content = View::tpl(
                array(
                    'obj' => $result,
                    'item' => Blog::getRow($result->blog_id),
                    'tpl_folder' => $this->tpl_folder,
                    'rubrics' => BlogRubrics::getRows(NULL, 'sort', 'ASC', NULL, NULL, false),
                ), $this->tpl_folder.'/Form');
        }


        function addAction () {
            if ($_POST) {
                $post = $_POST['FORM'];
                $post['status'] = Arr::get( $_POST, 'status', 0 );
                $post['blog_id'] = Arr::get($_POST, 'blog_id');
                $post['watched'] = 1;
                if( Model::valid($post) ) {
                    $post['date'] = strtotime($post['date']);
                    $post['date_answer'] = strtotime($post['date_answer']) ? strtotime($post['date_answer']) : NULL;
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
                $result = Model::getRow(Route::param('id'));
            }
            $this->_toolbar = Widgets::get( 'Toolbar_Edit' );
            $this->_seo['h1'] = 'Добавление';
            $this->_seo['title'] = 'Добавление';
            $this->setBreadcrumbs('Добавление', 'wezom/'.Route::controller().'/edit/'.Route::param('id'));
            $this->_content = View::tpl(
                array(
                    'obj' => $result,
                    'item' => Blog::getRow($result->blog_id),
                    'tpl_folder' => $this->tpl_folder,
                    'rubrics' => BlogRubrics::getRows(NULL, 'sort', 'ASC', NULL, NULL, false),
                ), $this->tpl_folder.'/Form');
        }


        function deleteAction() {
            $id = (int) Route::param('id');
            $page = Model::getRow($id);
            if(!$page) {
                Message::GetMessage(0, 'Данные не существуют!');
                HTTP::redirect('wezom/'.Route::controller().'/index');
            }
            Model::delete($id);
            Message::GetMessage(1, 'Данные удалены!');
            HTTP::redirect('wezom/'.Route::controller().'/index');
        }
    }