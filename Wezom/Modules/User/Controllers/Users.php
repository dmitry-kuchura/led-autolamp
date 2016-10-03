<?php
    namespace Wezom\Modules\User\Controllers;

    use Core\Common;
    use Core\Config;
    use Core\Files;
    use Core\HTML;
    use Core\QB\DB;
    use Core\Route;
    use Core\User;
    use Core\Widgets;
    use Core\Message;
    use Core\Arr;
    use Core\Image;
    use Core\HTTP;
    use Core\View;
    use Core\Pager\Pager;

    use Wezom\Modules\User\Models\Users AS Model;

    class Users extends \Wezom\Modules\Base {

        public $tpl_folder = 'Users';
        public $page;
        public $limit;
        public $offset;

        function before() {
            parent::before();
            $this->_seo['h1'] = 'Пользователи';
            $this->_seo['title'] = 'Пользователи';
            $this->setBreadcrumbs('Пользователи', 'wezom/'.Route::controller().'/index');
            $this->page = (int) Route::param('page') ? (int) Route::param('page') : 1;
            $this->limit = (int) Arr::get($_GET, 'limit', Config::get('basic.limit_backend')) < 1 ?: Arr::get($_GET, 'limit', Config::get('basic.limit_backend'));
            $this->offset = ($this->page - 1) * $this->limit;
        }


        function indexAction () {
            $status = NULL;
            if ( isset($_GET['status']) && $_GET['status'] != '' ) { $status = Arr::get($_GET, 'status', 1); }
            $page = (int) Route::param('page') ? (int) Route::param('page') : 1;
            $count = Model::countRows($status);
            $result = Model::getRows($status, 'id', 'DESC', $this->limit, ($page - 1) * $this->limit);
            $pager = Pager::factory( $page, $count, $this->limit )->create();
            $this->_toolbar = Widgets::get( 'Toolbar/List', array( 'add' => 1, 'delete' => 1 ) );
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
            if ($_POST) {
                $post = $_POST['FORM'];
                $post['status'] = Arr::get( $_POST, 'status', 0 );
                $post['password'] = trim( Arr::get($_POST, 'password') );
                if( Model::valid($post) ) {
                    if( $post['password'] ) {
                        $post['password'] = User::factory()->hash_password($post['password']);
                    } else {
                        unset($post['password']);
                    }
                    $res = Model::update($post, Route::param('id'));
                    if($res) {
                        Message::GetMessage(1, 'Вы успешно изменили данные!');
                        if(Arr::get($_POST, 'button', 'save') == 'save-close') {
                            HTTP::redirect('wezom/'.Route::controller().'/index');
                        } else if(Arr::get($_POST, 'button', 'save') == 'save-add') {
                            HTTP::redirect('wezom/'.Route::controller().'/add');
                        } else {
                            HTTP::redirect('wezom/' . Route::controller() . '/edit/' . Route::param('id'));
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
            $this->setBreadcrumbs('Редактирование', 'wezom/'.Route::controller().'/edit/'.Route::param('id'));
            $this->_content = View::tpl(
                array(
                    'obj' => $result,
                    'tpl_folder' => $this->tpl_folder,
                    'count_orders' => (int) DB::select(array(DB::expr('COUNT(id)'), 'count'))->from('orders')->where('user_id', '=', Route::param('id'))->count_all(),
                    'count_good_orders' => (int) DB::select(array(DB::expr('COUNT(id)'), 'count'))->from('orders')->where('status', '=', 1)->where('user_id', '=', Route::param('id'))->count_all(),
                    'amount_good_orders' => (int) DB::select(array(DB::expr('SUM(orders_items.count * orders_items.cost)'), 'amount'))
                        ->from('orders')
                        ->join('orders_items')->on('orders_items.order_id', '=', 'orders.id')
                        ->where('status', '=', 1)
                        ->where('user_id', '=', Route::param('id'))
                        ->find()
                        ->amount,
                    'socials' => DB::select()->from('users_networks')->where('user_id', '=', $result->id)->find_all(),
                ), $this->tpl_folder.'/Form');
        }

        function addAction () {
            if ($_POST) {
                $post = $_POST['FORM'];
                $post['status'] = Arr::get( $_POST, 'status', 0 );
                $post['password'] = trim( Arr::get($_POST, 'password') );
                if( Model::valid($post) ) {
                    $post['password'] = User::factory()->hash_password($post['password']);
                    $post['hash'] = User::factory()->hash_user($post['email'], $post['password']);
                    $res = Model::insert($post);
                    if($res) {
                        $file_name = Files::uploadFile(HTML::media("files/agreements"));
                        Model::update(array('file_agreement' => $file_name), $res);
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
                unset($post['password']);
                $result = Arr::to_object($post);
            } else {
                $result = array();
            }
            $this->_toolbar = Widgets::get( 'Toolbar_Edit' );
            $this->_seo['h1'] = 'Редактирование';
            $this->_seo['title'] = 'Редактирование';
            $this->setBreadcrumbs('Редактирование', 'wezom/'.Route::controller().'/edit/'.Route::param('id'));
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
                HTTP::redirect('wezom/'.Route::controller().'/index');
            }
            Model::delete($id);
            Message::GetMessage(1, 'Данные удалены!');
            HTTP::redirect('wezom/'.Route::controller().'/index');
        }

    }