<?php

namespace Wezom\Modules\Multimedia\Controllers;

use Core\Config;
use Core\Route;
use Core\Widgets;
use Core\Message;
use Core\Arr;
use Core\Image;
use Core\HTTP;
use Core\View;
use Wezom\Modules\Multimedia\Models\Slider AS Model;

class Slider extends \Wezom\Modules\Base {

    public $tpl_folder = 'Multimedia/Slider';
    public $page;
    public $limit;
    public $offset;

    function before() {
        parent::before();
        $this->_seo['h1'] = 'Слайдшоу';
        $this->_seo['title'] = 'Слайдшоу';
        $this->setBreadcrumbs('Слайдшоу', 'wezom/' . Route::controller() . '/index');
        $this->page = (int) Route::param('page') ? (int) Route::param('page') : 1;
        $this->limit = Config::get('basic.limit_backend');
        $this->offset = ($this->page - 1) * $this->limit;
    }

    function indexAction() {
        $count = Model::countRows();
        $result = Model::getRows(NULL, 'sort', 'ASC', $this->limit, $this->offset);
        $this->_filter = Widgets::get('Filter_Pages');
        $this->_toolbar = Widgets::get('Toolbar_List', array('add' => 1, 'delete' => 1));
        $this->_content = View::tpl(array(
                    'result' => $result,
                    'count' => $count,
                    'tpl_folder' => $this->tpl_folder,
                    'tablename' => Model::$table,
                        ), $this->tpl_folder . '/Index');
    }

    function editAction() {
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
            $result = Model::getRow(Route::param('id'));
        }
        $this->_toolbar = Widgets::get('Toolbar_Edit');
        $this->_seo['h1'] = 'Редактирование';
        $this->_seo['title'] = 'Редактирование';
        $this->setBreadcrumbs('Редактирование', 'wezom/' . Route::controller() . '/edit/' . Route::param('id'));
        $this->_content = View::tpl(
                        array(
                    'obj' => $result,
                    'tpl_folder' => $this->tpl_folder,
                        ), $this->tpl_folder . '/Form');
    }

    function addAction() {
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
        $this->_toolbar = Widgets::get('Toolbar_Edit');
        $this->_seo['h1'] = 'Добавление';
        $this->_seo['title'] = 'Добавление';
        $this->setBreadcrumbs('Добавление', 'wezom/' . Route::controller() . '/add');
        $this->_content = View::tpl(
                        array(
                    'obj' => $result,
                    'tpl_folder' => $this->tpl_folder,
                        ), $this->tpl_folder . '/Form');
    }

    function deleteAction() {
        $id = (int) Route::param('id');
        $page = Model::getRow($id);
        if (!$page) {
            Message::GetMessage(0, 'Данные не существуют!');
            HTTP::redirect('wezom/' . Route::controller() . '/index');
        }
        Model::deleteImage($page->image);
        Model::delete($id);
        Message::GetMessage(1, 'Данные удалены!');
        HTTP::redirect('wezom/' . Route::controller() . '/index');
    }

    function deleteImageAction() {
        $id = (int) Route::param('id');
        $page = Model::getRow($id);
        if (!$page) {
            Message::GetMessage(0, 'Данные не существуют!');
            HTTP::redirect('wezom/' . Route::controller() . '/index');
        }
        Model::deleteImage($page->image);
        Message::GetMessage(1, 'Данные удалены!');
        HTTP::redirect('wezom/' . Route::controller() . '/edit/' . $id);
    }

}
