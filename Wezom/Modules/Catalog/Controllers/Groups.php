<?php
    namespace Wezom\Modules\Catalog\Controllers;

    use Core\Support;
    use Core\Route;
    use Core\Widgets;
    use Core\Message;
    use Core\Arr;
    use Core\HTTP;
    use Core\View;
    use Core\QB\DB;

    use Wezom\Modules\Catalog\Models\Groups AS Model;
    use Wezom\Modules\Catalog\Models\Brands;
    use Wezom\Modules\Catalog\Models\Specifications;

    class Groups extends \Wezom\Modules\Base {

        public $tpl_folder = 'Catalog/Groups';

        function before() {
            parent::before();
            $this->_seo['h1'] = 'Группы товаров';
            $this->_seo['title'] = 'Группы товаров';
            $this->setBreadcrumbs('Группы товаров', 'wezom/'.Route::controller().'/index');
        }

        function indexAction () {
            $result = Model::getRows(NULL, 'sort', 'ASC');
            $arr = array();
            foreach($result AS $obj) {
                $arr[$obj->parent_id][] = $obj;
            }
            $this->_filter = Widgets::get( 'Filter_Pages', array( 'open' => 1 ) );
            $this->_toolbar = Widgets::get( 'Toolbar_List', array( 'add' => 1 ) );
            $this->_content = View::tpl(
                array(
                    'result' => $arr,
                    'tpl_folder' => $this->tpl_folder,
                    'tablename' => Model::$table,
                    'pageName' => $this->_seo['h1'],
                ), $this->tpl_folder.'/Index');
        }

        function editAction () {
            if ($_POST) {
                $post = $_POST['FORM'];
                $groupBrands = Arr::get( $_POST, 'BRANDS', array() );
                $groupSpec = Arr::get( $_POST, 'SPEC', array() );
                $post['status'] = Arr::get($_POST, 'status', 0);
                if( Model::valid($post) ) {
                    $post['alias'] = Model::getUniqueAlias(Arr::get($post, 'alias'), Route::param('id'));
                    $res = Model::update($post, Route::param('id'));
                    if($res) {
                        Model::uploadImage(Route::param('id'));
                        Model::changeBrandsCommunications($groupBrands, Route::param('id'));
                        Model::changeSpecificationsCommunications($groupSpec, Route::param('id'));
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
                $groupBrands = Model::getGroupBrandsIDS((int) Route::param('id'));
                $groupSpec = Model::getGroupSpecificationsIDS((int) Route::param('id'));
            }
            $this->_toolbar = Widgets::get( 'Toolbar_Edit' );
            $this->_seo['h1'] = 'Редактирование';
            $this->_seo['title'] = 'Редактирование';
            $this->setBreadcrumbs('Редактирование', 'wezom/'.Route::controller().'/edit/'.(int) Route::param('id'));
            $this->_content = View::tpl(
                array(
                    'obj' => $result,
                    'tpl_folder' => $this->tpl_folder,
                    'tree' => Support::getSelectOptions('Catalog/Groups/Select', 'catalog_tree', $result->parent_id, $result->id),
                    'brands' => Brands::getRows(NULL, 'name', 'ASC'),
                    'specifications' => Specifications::getRows(NULL, 'name', 'ASC'),
                    'groupBrands' => $groupBrands,
                    'groupSpec' => $groupSpec,
                ), $this->tpl_folder.'/Form');
        }

        function addAction () {
            $groupBrands = Arr::get( $_POST, 'BRANDS', array() );
            $groupSpec = Arr::get( $_POST, 'SPEC', array() );
            if ($_POST) {
                $post = $_POST['FORM'];
                $post['status'] = Arr::get($_POST, 'status', 0);
                if( Model::valid($post) ) {
                    $post['alias'] = Model::getUniqueAlias(Arr::get($post, 'alias'));
                    $res = Model::insert($post);
                    if($res) {
                        Model::uploadImage($res);
                        Model::changeBrandsCommunications($groupBrands, $res);
                        Model::changeSpecificationsCommunications($groupSpec, $res);
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
            $this->_toolbar = Widgets::get( 'Toolbar_Edit' );
            $this->_seo['h1'] = 'Добавление';
            $this->_seo['title'] = 'Добавление';
            $this->setBreadcrumbs('Добавление', 'wezom/'.Route::controller().'/add');
            $this->_content = View::tpl(
                array(
                    'obj' => $result,
                    'tpl_folder' => $this->tpl_folder,
                    'tree' => Support::getSelectOptions('Catalog/Groups/Select', 'catalog_tree', $result->parent_id, $result->id),
                    'brands' => Brands::getRows(NULL, 'name', 'ASC'),
                    'specifications' => Specifications::getRows(NULL, 'name', 'ASC'),
                    'groupBrands' => $groupBrands,
                    'groupSpec' => $groupSpec,
                ), $this->tpl_folder.'/Form');
        }

        function deleteAction() {
            $id = (int) Route::param('id');
            $page = Model::getRow($id);
            if(!$page) {
                Message::GetMessage(0, 'Данные не существуют!');
                HTTP::redirect('wezom/'.Route::controller().'/index');
            }
            $countChildGroups = Model::countKids($id);
            if ( $countChildGroups ) {
                Message::GetMessage(0, 'Нельзя удалить эту группу, так как у нее есть подгруппы!');
                HTTP::redirect('wezom/'.Route::controller().'/index');
            }
            $countChildItems = Model::countItems($id);
            if ( $countChildItems ) {
                Message::GetMessage(0, 'Нельзя удалить эту группу, так как в ней содержатся товары!');
                HTTP::redirect('wezom/'.Route::controller().'/index');
            }
            Model::deleteImage($page->image);
            Model::delete($id);
            Message::GetMessage(1, 'Данные удалены!');
            HTTP::redirect('wezom/'.Route::controller().'/index');
        }

        function deleteImageAction() {
            $id = (int) Route::param('id');
            $page = Model::getRow($id);
            if(!$page) {
                Message::GetMessage(0, 'Данные не существуют!');
                HTTP::redirect('wezom/'.Route::controller().'/index');
            }
            Model::deleteImage($page->image, $page->id);
            Message::GetMessage(1, 'Данные удалены!');
            HTTP::redirect('wezom/'.Route::controller().'/edit/'.$id);
        }
    }