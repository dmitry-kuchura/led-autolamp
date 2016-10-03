<?php
    namespace Wezom\Modules\Catalog\Controllers;

    use Core\Config;
    use Core\Route;
    use Core\Widgets;
    use Core\Message;
    use Core\Arr;
    use Core\HTTP;
    use Core\View;
    use Core\QB\DB;
    use Core\Pager\Pager;

    use Wezom\Modules\Catalog\Models\Specifications AS Model;
    use Wezom\Modules\Catalog\Models\SpecificationsValues AS SV;

    class Specifications extends \Wezom\Modules\Base {

        public $tpl_folder = 'Catalog/Specifications';
        public $limit;

        function before() {
            parent::before();
            $this->_seo['h1'] = 'Характеристики';
            $this->_seo['title'] = 'Характеристики';
            $this->setBreadcrumbs('Характеристики', 'wezom/'.Route::controller().'/index');
            $this->limit = (int) Arr::get($_GET, 'limit', Config::get('basic.limit_backend')) < 1 ?: Arr::get($_GET, 'limit', Config::get('basic.limit_backend'));
        }

        function indexAction () {
            $status = NULL;
            if ( isset($_GET['status']) && $_GET['status'] != '' ) { $status = Arr::get($_GET, 'status', 1); }
            $page = (int) Route::param('page') ? (int) Route::param('page') : 1;
            $count = Model::countRows($status);
            $result = Model::getRows($status, 'name', 'ASC');
            $pager = Pager::factory( $page, $count, $this->limit )->create();
            $this->_toolbar = Widgets::get( 'Toolbar/List', array( 'add' => 1, 'delete' => 1 ) );
            $t = DB::select()->from('specifications_types')->order_by('name', 'DESC')->find_all();
            $types = array();
            foreach( $t AS $_t ) {
                $types[$_t->id] = $_t->name;
            }

            $this->_content = View::tpl(
                array(
                    'result' => $result,
                    'tpl_folder' => $this->tpl_folder,
                    'tablename' => Model::$table,
                    'count' => $count,
                    'pager' => $pager,
                    'types' => $types,
                    'pageName' => $this->_seo['h1'],
                ), $this->tpl_folder.'/Index');
        }


        function editAction () {
            if ($_POST) {
                $post = $_POST['FORM'];
                $post['status'] = Arr::get( $_POST, 'status', 0 );
                if( Model::valid($post) ) {
                    $post['alias'] = Model::getUniqueAlias(Arr::get($post, 'alias'), Route::param('id'));
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
                $result = Model::getRow((int) Route::param('id'));
            }
            $this->_toolbar = Widgets::get( 'Toolbar/Edit' );
            $this->_seo['h1'] = 'Редактирование';
            $this->_seo['title'] = 'Редактирование';
            $this->setBreadcrumbs('Редактирование', 'wezom/'.Route::controller().'/edit/'.(int) Route::param('id'));
            $this->_content = View::tpl(
                array(
                    'obj' => $result,
                    'tpl_folder' => $this->tpl_folder,
                    'list' => SV::getRows(Route::param('id'), NULL, 'name', 'ASC'),
                    'types' => DB::select()->from('specifications_types')->order_by('name', 'DESC')->find_all(),
                ), $this->tpl_folder.'/Edit');
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
                $result     = Arr::to_object($post);
            } else {
                $result     = array();
            }
            $this->_toolbar = Widgets::get( 'Toolbar/Edit' );
            $this->_seo['h1'] = 'Добавление';
            $this->_seo['title'] = 'Добавление';
            $this->setBreadcrumbs('Добавление', 'wezom/'.Route::controller().'/add');
            $this->_content = View::tpl(
                array(
                    'obj' => $result,
                    'tpl_folder' => $this->tpl_folder,
                    'types' => DB::select()->from('specifications_types')->order_by('name', 'DESC')->find_all(),
                ), $this->tpl_folder.'/Add');
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