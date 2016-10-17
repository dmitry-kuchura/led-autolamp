<?php
namespace Wezom\Modules\Reviews\Controllers;

use Core\Config;
use Core\Pager\Pager;
use Core\Route;
use Core\Validation\Rules;
use Core\Widgets;
use Core\Message;
use Core\Arr;
use Core\HTTP;
use Core\View;

use Wezom\Modules\Reviews\Models\Reviews AS Model;

class Reviews extends \Wezom\Modules\Base
{

    public $tpl_folder = 'Reviews';
    public $page;
    public $limit;
    public $offset;

    function before()
    {
        parent::before();
        $this->_seo['h1'] = 'Отзывы клиентов';
        $this->_seo['title'] = 'Отзывы клиентов';
        $this->setBreadcrumbs('Отзывы клиентов', 'wezom/' . Route::controller() . '/index');
        $this->page = (int)Route::param('page') ? (int)Route::param('page') : 1;
        $this->limit = Arr::get($_GET, 'limit') > 0 ? (int)$_GET['limit'] : Config::get('static.limit_backend');
        $this->offset = ($this->page - 1) * $this->limit;
    }

    function indexAction()
    {
        $date_s = NULL;
        $name = NULL;
        $date_po = NULL;
        $status = NULL;
        if (isset($_GET['status']) && $_GET['status'] != '') {
            $status = Arr::get($_GET, 'status', 1);
        }
        if (isset($_GET['name']) && $_GET['name'] != '') {
            $name = Arr::get($_GET, 'name', 1);
        }
        $count = Model::countRows($status, $date_s, $date_po, $name);
        $result = Model::getRows($status, $date_s, $date_po, $name, 'date', 'DESC', $this->limit, $this->offset);
        $pager = Pager::factory($this->page, $count, $this->limit)->create();
        $this->_toolbar = Widgets::get('Toolbar_ListReviews', array('delete' => 1, 'add' => 1));
        $this->_content = View::tpl(
            array(
                'result' => $result,
                'tpl_folder' => $this->tpl_folder,
                'tablename' => Model::$table,
                'count' => $count,
                'pager' => $pager,
                'pageName' => $this->_seo['h1'],
            ), $this->tpl_folder . '/Index');
    }

    function editAction()
    {
        if ($_POST) {
            $post = $_POST['FORM'];
            $post['status'] = Arr::get($_POST, 'status', 0);
            if (Model::valid($post)) {
                $res = Model::update($post, Route::param('id'));
                if ($res) {
                    Model::uploadImage(Route::param('id'));
                    Message::GetMessage(1, 'Вы успешно изменили данные!');
                    if (Arr::get($_POST, 'button', 'save') == 'save-close') {
                        HTTP::redirect('wezom/' . Route::controller() . '/index');
                    } else if (Arr::get($_POST, 'button', 'save') == 'save-add') {
                        HTTP::redirect('wezom/' . Route::controller() . '/add');
                    } else {
                        HTTP::redirect('wezom/' . Route::controller() . '/edit/' . Route::param('id'));
                    }
                } else {
                    Message::GetMessage(0, 'Не удалось изменить данные!');
                }
            }
            $result = Arr::to_object($post);
        } else {
            $result = Model::getRow((int)Route::param('id'));
        }
        $this->_toolbar = Widgets::get('Toolbar/Edit');
        $this->_seo['h1'] = 'Редактирование';
        $this->_seo['title'] = 'Редактирование';
        $this->setBreadcrumbs('Редактирование', 'wezom/' . Route::controller() . '/edit/' . Route::param('id'));
        $this->_content = View::tpl(
            array(
                'obj' => $result,
                'tpl_folder' => $this->tpl_folder,
            ), $this->tpl_folder . '/Form');
    }

    function addAction()
    {
        if ($_POST) {
            $post = $_POST['FORM'];
            $post['status'] = Arr::get($_POST, 'status', 0);
            if (Model::valid($post)) {
                $res = Model::insert($post);
                if ($res) {
                    Model::uploadImage($res);
                    Message::GetMessage(1, 'Вы успешно добавили данные!');
                    if (Arr::get($_POST, 'button', 'save') == 'save-close') {
                        HTTP::redirect('wezom/' . Route::controller() . '/index');
                    } else if (Arr::get($_POST, 'button', 'save') == 'save-add') {
                        HTTP::redirect('wezom/' . Route::controller() . '/add');
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
        $this->_toolbar = Widgets::get('Toolbar/Edit');
        $this->_seo['h1'] = 'Добавление';
        $this->_seo['title'] = 'Добавление';
        $this->setBreadcrumbs('Добавление', 'wezom/' . Route::controller() . '/add');
        $this->_content = View::tpl(
            array(
                'obj' => $result,
                'tpl_folder' => $this->tpl_folder,
            ), $this->tpl_folder . '/Form');
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

    function deleteImageAction()
    {
        $id = (int)Route::param('id');
        $page = Model::getRow($id);
        if (!$page) {
            Message::GetMessage(0, 'Данные не существуют!');
            HTTP::redirect('wezom/' . Route::controller() . '/index');
        }
        Model::deleteImage($page->image, $id);
        Message::GetMessage(1, 'Данные удалены!');
        HTTP::redirect('wezom/' . Route::controller() . '/edit/' . $id);
    }

}