<?php
    namespace Backend\Modules\Translates\Controllers;

    use Core\Config;
    use Core\Route;
    use Core\Widgets;
    use Core\Image;
    use Core\View;

    class Translates extends \Backend\Modules\Base {

        public $tpl_folder = 'Translates';

        function before() {
            parent::before();
            $this->_seo['h1'] = 'Переводы';
            $this->_seo['title'] = 'Переводы';
            $this->setBreadcrumbs('Переводы', 'backend/'.Route::controller().'/index');
            $this->limit = Config::get('basic.limit_backend');
        }

        function indexAction () {
//            if( $_POST ) {
//                foreach( $this->_languages AS $_key => $lang ) {
//                    $text = "<?php";
//                    $text .= "\n\treturn array(";
//                    foreach( $_POST[$_key] AS $key => $value ) {
//                        $text .= "\n\t\t'".addslashes($key)."' => '".addslashes($value)."',";
//                    }
//                    $text .= "\n\t);";
//                    file_put_contents(HOST.'/Plugins/I18n/Translates/'.$_key.'.php', $text);
//                }
//            }
            $result = array();
            $key = '';
            foreach( $this->_languages AS $key => $lang ) {
                $result[$key] = include HOST.'/Plugins/I18n/Translates/'.$key.'.php';
            }
//            $this->_toolbar = Widgets::get( 'Toolbar/EditSaveOnly' );
            $this->_content = View::tpl(
                array(
                    'result' => $result,
                    'pageName' => 'Переводы',
                    'count' => count($result[$key]),
                    'languages' => $this->_languages,
                ), $this->tpl_folder.'/Index');
        }

    }