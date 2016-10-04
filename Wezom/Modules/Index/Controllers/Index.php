<?php
namespace Wezom\Modules\Index\Controllers;

use Core\View;
use Core\QB\DB;

class Index extends \Wezom\Modules\Base
{

    function indexAction()
    {

        $counts = [];
        $counts['orders'] = (int)DB::select([DB::expr('COUNT(id)'), 'count'])->from('orders')->count_all();
        $counts['reviews'] = (int)DB::select([DB::expr('COUNT(id)'), 'count'])->from('reviews')->count_all();
        $counts['cap'] = (int)DB::select([DB::expr('COUNT(id)'), 'count'])->from('cap')->count_all();
        $counts['discount'] = (int)DB::select([DB::expr('COUNT(id)'), 'count'])->from('orders_simple')->count_all();

        $this->_seo['h1'] = 'Панель управления';
        $this->_seo['title'] = 'Панель управления';
        $this->_content = View::tpl(compact('counts'), 'Index/Main');
    }
}