<?php
    namespace Wezom\Modules\Content\Controllers;

    use Core\Route;
    use Core\Widgets;
    use Core\Message;
    use Core\Arr;
    use Core\HTTP;
    use Core\View;

    use Wezom\Modules\Content\Models\Control AS Model;

    class Control extends \Wezom\Modules\Base {

        public $tpl_folder = 'Content/Control';

        function before() {
            parent::before();
            $this->_seo['h1'] = 'Системные страницы';
            $this->_seo['title'] = 'Системные страницы';
            $this->setBreadcrumbs('Системные страницы', 'wezom/'.Route::controller().'/index');
        }

        function indexAction () {
            $result = Model::getRows(NULL, 'name', 'ASC');
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
                $result = Arr::to_object($post);
            } else {
                $result = Model::getRow(Route::param('id'));
            }
            $this->_toolbar = Widgets::get('Toolbar/Edit', array('noAdd' => true));
            $this->_seo['h1'] = 'Редактирование';
            $this->_seo['title'] = 'Редактирование';
            $this->setBreadcrumbs('Редактирование', 'wezom/'.Route::controller().'/index');
            $this->_content = View::tpl(
                array(
                    'obj' => $result,
                    'tpl_folder' => $this->tpl_folder,
                ), $this->tpl_folder.'/Form');
        }

    }