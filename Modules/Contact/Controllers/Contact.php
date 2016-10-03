<?php
    namespace Modules\Contact\Controllers;

    use Core\Route;
    use Core\View;
    use Core\Config;

    use Modules\Content\Models\Control;

    class Contact extends \Modules\Base {

        public $current;

        public function before() {
            parent::before();
            $this->current = Control::getRow(Route::controller(), 'alias', 1);
            if( !$this->current ) {
                return Config::error();
            }
            $this->setBreadcrumbs( $this->current->name, $this->current->alias );
        }

        public function indexAction() {
            if( Config::get('error') ) {
                return false;
            }
            // Seo
            $this->_seo['h1'] = $this->current->h1;
            $this->_seo['title'] = $this->current->title;
            $this->_seo['keywords'] = $this->current->keywords;
            $this->_seo['description'] = $this->current->description;
            // Render template
            $this->_content = View::tpl( array( 'text' => $this->current->text, 'kids' => array() ), 'Contact/Index' );
        }

    }
    