<?php
namespace Wezom\Modules;

use Core\Config;
use Core\Encrypt;
use Core\View;
use Core\System;
use Core\Cron;
use Core\Route;
use Core\HTML;
use Core\HTTP;
use Core\QB\DB;
use Core\User;
use Core\Widgets;

class Base
{

    protected $_template = 'Main';
    protected $_content;
    protected $_config = array();
    protected $_seo = array();
    protected $_breadcrumbs = array();
    protected $_filter = NULL;
    protected $_toolbar = NULL;

    protected $_access = 'no';

    public function before()
    {
        User::factory()->is_remember();
        $this->redirects();
        $cron = new Cron;
        $cron->check();
        $this->config();
        $this->access();
    }

    public function after()
    {
        $this->render();
    }

    private function redirects()
    {
        if (!User::info() AND Route::controller() != 'auth' AND Route::module() != 'ajax') {
            HTTP::redirect('wezom/auth/login?ref=' . $_SERVER['REQUEST_URI']);
        }
    }

    public function access()
    {
        if (!User::info()) {
            return false;
        }
        $this->_access = User::caccess();
        if ($this->_access == 'no') {
            $this->no_access();
        }
        if ($this->_access == 'view' && Route::action() != 'index' && Route::action() != 'edit') {
            $this->no_access();
        }
    }

    public function no_access()
    {
        $this->_breadcrumbs = HTML::backendBreadcrumbs($this->_breadcrumbs);
        $data = array();
        foreach ($this as $key => $value) {
            $data[$key] = $value;
        }
        $data['_seo']['h1'] = 'Ошибка';
        $data['_content'] = Widgets::get('NoAccess');
        ob_start();
        extract($data, EXTR_SKIP);
        include(HOST . DS . 'Wezom' . DS . 'Views' . DS . 'Main.php');
        echo ob_get_clean();
        die;
    }

    private function config()
    {
        $result = DB::select('key', 'zna', 'group')
            ->from('config')
            ->join('config_groups')->on('config.group', '=', 'config_groups.alias')
            ->where('config.status', '=', 1)
            ->where('config_groups.status', '=', 1)
            ->find_all();
        $groups = array();
        foreach ($result AS $obj) {
            $groups[$obj->group][$obj->key] = $obj->zna;
        }
        foreach ($groups AS $key => $value) {
            Config::set($key, $value);
        }
        $this->setBreadcrumbs('Главная', 'wezom');
    }

    private function render()
    {

//			$help = DB::select('link')
//					->from('instructions')
//					->where('instructions.module', '=', Route::controller())
//					->find();

//            $this->_breadcrumbs = HTML::backendBreadcrumbs($this->_breadcrumbs,$help->link);
        $this->_breadcrumbs = HTML::backendBreadcrumbs($this->_breadcrumbs);
        $data = array();
        foreach ($this as $key => $value) {
            $data[$key] = $value;
        }
        echo View::tpl($data, $this->_template);
        echo System::global_massage();
    }

    protected function setBreadcrumbs($name, $link = NULL)
    {
        $this->_breadcrumbs[] = array('name' => $name, 'link' => $link);
    }

    protected function generateParentBreadcrumbs($id, $table, $parentAlias, $pre = '/')
    {
        $bread = $this->generateParentBreadcrumbsElement($id, $table, $parentAlias, array());
        if ($bread) {
            $bread = array_reverse($bread);
        }
        foreach ($bread as $obj) {
            $this->setBreadcrumbs($obj->h1, $pre . $obj->alias);
        }
    }

    protected function generateParentBreadcrumbsElement($id, $table, $parentAlias, $bread)
    {
        $page = DB::select('id', $parentAlias, 'alias', 'status', 'h1')->from($table)->where('id', '=', $id)->as_object()->execute()->current();
        if (is_object($page) AND $page->status) {
            $bread[] = $page;
        }
        if (is_object($page) AND (int)$page->$parentAlias > 0) {
            return $this->generateParentBreadcrumbsElement($page->$parentAlias, $table, $parentAlias, $bread);
        }
        return $bread;
    }

}
