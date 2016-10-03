<?php
namespace Wezom\Modules\Index\Controllers;

use Core\View;

class Index extends \Wezom\Modules\Base
{

    function indexAction()
    {
        $this->_seo['h1'] = 'Панель управления';
        $this->_seo['title'] = 'Панель управления';
        $this->_content = View::tpl([], 'Index/Main');
    }
}