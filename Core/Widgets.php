<?php
namespace Core;

use Core\QB\DB;

class Widgets
{

    static $_instance; // Constant that consists self class

    public $_data = []; // Array of called widgets
    public $_tree = []; // Only for catalog menus on footer and header. Minus one query

    static function factory()
    {
        if (self::$_instance == NULL) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public static function get($name, $array = [], $save = true, $cache = false)
    {
        $arr = explode('_', $name);
        $viewpath = implode('/', $arr);

        if (APPLICATION == 'backend' && !Config::get('error')) {
            $w = WidgetsBackend::factory();
        } else {
            $w = Widgets::factory();
        }

        $_cache = Cache::instance();
        if ($cache) {
            if (!$_cache->get($name)) {
                $data = NULL;
                if ($save && isset($w->_data[$name])) {
                    $data = $w->_data[$name];
                } else {
                    if ($save && isset($w->_data[$name])) {
                        $data = $w->_data[$name];
                    } else if (method_exists($w, $name)) {
                        $result = $w->$name($array);
                        if ($result !== NULL && $result !== FALSE) {
                            $array = array_merge($array, $result);
                            $data = View::widget($array, $viewpath);
                        } else {
                            $data = NULL;
                        }
                    } else {
                        $data = $w->common($viewpath, $array);
                    }
                }
                $_cache->set($name, HTML::compress($data, true));
                return $w->_data[$name] = $data;
            } else {
                return $_cache->get($name);
            }
        }
        if ($_cache->get($name)) {
            $_cache->delete($name);
        }
        if ($save && isset($w->_data[$name])) {
            return $w->_data[$name];
        }
        if (method_exists($w, $name)) {
            $result = $w->$name($array);
            if ($result !== NULL && $result !== FALSE) {
                if (is_array($result)) {
                    $array = array_merge($array, $result);
                }
                return $w->_data[$name] = View::widget($array, $viewpath);
            } else {
                return $w->_data[$name] = NULL;
            }
        }
        return $w->_data[$name] = $w->common($viewpath, $array);
    }

    public function common($viewpath, $array)
    {
        if (file_exists(HOST . '/Views/Widgets/' . $viewpath . '.php')) {
            return View::widget($array, $viewpath);
        }
        return NULL;
    }

    public function Head()
    {
        $styles = [
            HTML::media('css/components.css'),
            HTML::media('css/style.css'),
            HTML::media('css/responsive.css'),
        ];
        $scripts = [
            HTML::media('js/libs.js'),
            HTML::media('js/components.js'),
            HTML::media('js/inits.js'),
            HTML::media('js/validation.js'),
        ];

        return compact('scripts', 'styles');
    }

    public function Header()
    {
        $contentMenu = Common::factory('sitemenu')->getRows(1, 'sort');
        $array['contentMenu'] = $contentMenu;
        return $array;
    }

    public function Footer()
    {
        $contentMenu = Common::factory('sitemenu')->getRows(1, 'sort');
        $array['contentMenu'] = $contentMenu;
        return $array;
    }

    public function Main_Reviews()
    {
        $result = DB::select()->from('reviews')->where('status', '=', 1)->find_all();

        return compact('result');
    }

    public function Main_Top()
    {
        $result = DB::select()->from('cap')->where('status', '=', 1)->find_all();

        return compact('result');
    }

    public function Main_Compare()
    {
        $result = DB::select()->from('cap')->where('status', '=', 1)->find_all();

        return compact('result');
    }

}