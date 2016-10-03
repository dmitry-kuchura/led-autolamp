<?php
    namespace Wezom\Modules\Seo\Controllers;

    use Core\Route;
    use Core\Widgets;
    use Core\View;
    use Core\Message;
    use Core\HTTP;
    use Core\Arr;

    use Wezom\Modules\Seo\Models\Templates AS Model;

    class Templates extends \Wezom\Modules\Base {
        
        public $tpl_folder = 'Seo/Templates';

        function before() {
            parent::before();
            $this->_seo['h1'] = 'СЕО шаблоны';
            $this->_seo['title'] = 'СЕО шаблоны';
            $this->setBreadcrumbs('СЕО шаблоны', 'wezom/seo_templates/index');
        }

        function indexAction () {
            $result = Model::getRows(NULL, 'id', 'DESC');
            $this->_filter = Widgets::get( 'Filter_Pages' );
            $this->_toolbar = Widgets::get( 'Toolbar_List' );
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
                $post['status'] = Arr::get($_POST, 'status', 0);
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
                $result     = Arr::to_object($post);
            } else {
                $result = Model::getRow(Route::param('id'));
            }
            $this->_toolbar = Widgets::get( 'Toolbar_Edit', array('list_link' => '/wezom/seo_templates/index', 'noAdd' => true) );
            $this->_seo['h1'] = 'Редактирование';
            $this->_seo['title'] = 'Редактирование';
            $this->setBreadcrumbs('Редактирование', 'wezom/seo_templates/edit/'.Route::param('id'));
            $this->_content = View::tpl(
                array(
                    'obj' => $result,
                    'tpl_folder' => $this->tpl_folder,
                ), $this->tpl_folder.'/Form');
        }
        
    } 