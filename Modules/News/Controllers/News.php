<?php
    namespace Modules\News\Controllers;

    use Core\Route;
    use Core\View;
    use Core\Config;
    use Core\Pager\Pager;

    use Modules\News\Models\News AS Model;
    use Modules\Content\Models\Control;
    
    class News extends \Modules\Base {

        public $current;
        public $page = 1;
        public $limit;
        public $offset;
        public $model;

        public function before() {
            parent::before();
            $this->current = Control::getRow(Route::controller(), 'alias', 1);
            if( !$this->current ) {
                return Config::error();
            }
            $this->setBreadcrumbs( $this->current->name, $this->current->alias );
            $this->_template = 'Text';

            $this->page = !(int) Route::param('page') ? 1 : (int) Route::param('page');
            $this->limit = (int) Config::get('basic.limit_articles');
            $this->offset = ($this->page - 1) * $this->limit;
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
            Config::set( 'content_class', 'news_block' );
            $page = !(int) Route::param('page') ? 1 : (int) Route::param('page');
            // Get Rows
            $result = Model::getRows(1, 'date', 'DESC', $this->limit, $this->offset);
            // Get full count of rows
            $count = Model::countRows(1);
            // Generate pagination
            $pager = Pager::factory($this->page, $count, $this->limit)->create();
            // Render template
            $this->_content = View::tpl( array( 'result' => $result, 'pager' => $pager ), 'News/List' );
        }

        public function innerAction() {
            if( Config::get('error') ) {
                return false;
            }
            Config::set( 'content_class', 'new_block' );
            // Check for existance
            $obj = Model::getRow(Route::param('alias'), 'alias', 1);
            if( !$obj ) { return Config::error(); }
            // Seo
            $this->_seo['h1'] = $obj->h1;
            $this->_seo['title'] = $obj->title;
            $this->_seo['keywords'] = $obj->keywords;
            $this->_seo['description'] = $obj->description;
            $this->setBreadcrumbs( $obj->name );
            // Add plus one to views
            $obj = Model::addView($obj);
            // Render template
            $this->_content = View::tpl( array( 'obj' => $obj ), 'News/Inner' );
        }
        
    }