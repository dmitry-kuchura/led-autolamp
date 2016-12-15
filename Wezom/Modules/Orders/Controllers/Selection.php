<?php
namespace Wezom\Modules\Orders\Controllers;

use Core\Config;
use Core\Route;
use Core\Widgets;
use Core\Message;
use Core\Arr;
use Core\HTTP;
use Core\View;
use Core\Pager\Pager;
use Wezom\Modules\Orders\Models\Selection AS Model;

class Selection extends \Wezom\Modules\Base
{

    public $tpl_folder = 'Orders/Selection';
    public $page;
    public $limit;
    public $offset;

    function before()
    {
        parent::before();
        $this->_seo['h1'] = 'Подборы цоколя';
        $this->_seo['title'] = 'Подборы цоколя';
        $this->setBreadcrumbs('Подборы цоколя', 'wezom/' . Route::controller() . '/index');
        $this->page = (int)Route::param('page') ? (int)Route::param('page') : 1;
        $this->limit = Config::get('static.limit_backend');
        $this->offset = ($this->page - 1) * $this->limit;
    }

    function indexAction()
    {
        $date_s = NULL;
        $date_po = NULL;
        $status = NULL;
        if (Arr::get($_GET, 'date_s')) {
            $date_s = strtotime(Arr::get($_GET, 'date_s'));
        }
        if (Arr::get($_GET, 'date_po')) {
            $date_po = strtotime(Arr::get($_GET, 'date_po'));
        }
        if (isset($_GET['status'])) {
            $status = Arr::get($_GET, 'status', 1);
        }
        $page = (int)Route::param('page') ? (int)Route::param('page') : 1;
        $count = Model::countRows($status, $date_s, $date_po);
        $result = Model::getRows($status, $date_s, $date_po, 'id', 'DESC', $this->limit, ($page - 1) * $this->limit);
        $pager = Pager::factory($page, $count, $this->limit)->create();
        $this->_toolbar = Widgets::get('Toolbar_List', ['delete' => 1]);
        $this->_content = View::tpl(
            [
                'result' => $result,
                'tpl_folder' => $this->tpl_folder,
                'tablename' => Model::$table,
                'count' => $count,
                'pager' => $pager,
                'pageName' => $this->_seo['h1'],
            ], $this->tpl_folder . '/Index');
    }

    function editAction()
    {
        if ($_POST) {
            $post = $_POST['FORM'];
            $post['status'] = Arr::get($_POST, 'status', 0);
            $res = Model::update($post, Route::param('id'));
            if ($res) {
                Message::GetMessage(1, 'Вы успешно изменили данные!');
                HTTP::redirect('wezom/' . Route::controller() . '/edit/' . Route::param('id'));
            } else {
                Message::GetMessage(0, 'Не удалось изменить данные!');
            }
            $result = Arr::to_object($post);
        } else {
            $result = Model::getRow(Route::param('id'));
        }
        if ($result == null) {
            $tpl = '/Noresult';
        } else {
            $this->_toolbar = Widgets::get('Toolbar_Edit', ['noAdd' => true]);
            $tpl = '/Form';
        }
        $this->_seo['h1'] = 'Редактирование';
        $this->_seo['title'] = 'Редактирование';
        $this->setBreadcrumbs('Редактирование', 'wezom/' . Route::controller() . '/edit/' . Route::param('id'));
        $this->_content = View::tpl(
            [
                'obj' => $result,
                'tpl_folder' => $this->tpl_folder,
            ], $this->tpl_folder . $tpl);
    }

    function deleteAction()
    {
        $id = (int)Route::param('id');
        $page = Model::getRow($id);
        if (!$page) {
            Message::GetMessage(0, 'Данные не существуют!');
            HTTP::redirect('wezom/' . Route::controller() . '/index');
        }
        Model::delete($id);
        Message::GetMessage(1, 'Данные удалены!');
        HTTP::redirect('wezom/' . Route::controller() . '/index');
    }
}
