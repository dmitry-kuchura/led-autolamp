<?php
    namespace Modules\Catalog\Controllers;

    use Core\Common;
    use Core\HTML;
    use Core\Route;
    use Core\View;
    use Core\Config;
    use Core\Pager\Pager;
    use Core\Arr;
    use Modules\Catalog\Models\Filter;
    use Core\Text;

    use Modules\Catalog\Models\Groups AS Model;
    use Modules\Content\Models\Control;

    class Catalog extends \Modules\Base {

        public $current;
        public $page = 1;
        public $sort;
        public $type;
        public $limit;
        public $offset;
        protected $_template = 'Catalog';

        public function before() {
            parent::before();
            $this->current = Control::getRow(Route::controller(), 'alias', 1);
            if( !$this->current ) {
                return Config::error();
            }
            $this->setBreadcrumbs( $this->current->name, $this->current->alias );
            $this->page = !(int) Route::param('page') ? 1 : (int) Route::param('page');
            $limit = Config::get('basic.limit_groups');
            $sort = 'sort'; $type = 'ASC';
            $this->limit = (int) Arr::get($_GET, 'per_page') ? (int) Arr::get($_GET, 'per_page') : $limit;
            $this->offset = ($this->page - 1) * $this->limit;
            $this->sort = in_array(Arr::get($_GET, 'sort'), array('name', 'created_at', 'cost')) ? Arr::get($_GET, 'sort') : $sort;
            $this->type = in_array(strtolower(Arr::get($_GET, 'type')), array('asc', 'desc')) ? strtoupper(Arr::get($_GET, 'type')) : $type;
        }


        // Catalog main page with groups where parent_id = 0
        public function indexAction() {
            if( Config::get('error') ) {
                return false;
            }
            // Seo
            $this->_seo['h1'] = $this->current->h1;
            $this->_seo['title'] = $this->current->title;
            $this->_seo['keywords'] = $this->current->keywords;
            $this->_seo['description'] = $this->current->description;
            // Get groups with parent_id = 0
            $result = Model::getInnerGroups(0, $this->sort, $this->type, $this->limit, $this->offset);
            // Count of parent groups
            $count = Model::countInnerGroups(0);
            // Generate pagination
            $pager = Pager::factory($this->page, $count, $this->limit)->create();
            // Render template
            $this->_content = View::tpl( array('result' => $result, 'pager' => $pager), 'Catalog/Groups' );
        }


        // Page with groups list
        public function groupsAction() {
            if( Config::get('error') ) {
                return false;
            }
            // Check for existance
            $group = Model::getRow(Route::param('alias'), 'alias', 1);
            if( !$group ) { return Config::error(); }
            Route::factory()->setParam('group', $group->id);
            // Count of child groups
            $count = Model::countInnerGroups($group->id);
            if (!$count) {
                return $this->listAction();
            }
            // Seo
            $this->setSeoForGroup($group);
            // Add plus one to views
            Model::addView($group);
            // Get groups list
            $result = Model::getInnerGroups($group->id, $this->sort, $this->type, $this->limit, $this->offset);
            // Generate pagination
            $pager = Pager::factory($this->page, $count, $this->limit)->create();
            // Render template
            $this->_content = View::tpl( array('result' => $result, 'pager' => $pager), 'Catalog/Groups' );
        }


        // Items list page. Inside group
        public function listAction() {
            if( Config::get('error') ) {
                return false;
            }
            $this->_template = 'ItemsList';
            Route::factory()->setAction('list');
            // Filter parameters to array if need
            Filter::setFilterParameters();
            // Set filter elements sortable
            Filter::setSortElements();
            // Check for existance
            $group = Model::getRow(Route::param('alias'), 'alias', 1);
            if( !$group ) { return Config::error(); }
            // Seo
            $this->setSeoForGroup($group);
            // Add plus one to views
            Model::addView($group);
            // Get items list
            $result = Filter::getFilteredItemsList($this->limit, $this->offset, $this->sort, $this->type);
            // Generate pagination
            $pager = Pager::factory($this->page, $result['total'], $this->limit)->create();
            // Render page
            $this->_content = View::tpl( array('result' => $result['items'], 'pager' => $pager), 'Catalog/ItemsList' );
        }


        // Set seo tags from template for items groups
        public function setSeoForGroup($page) {
            $tpl = Common::factory('seo_templates')->getRow(1);
            $from = array('{{name}}', '{{content}}');
            $text = trim(strip_tags($page->text));
            $to = array($page->name, $text);
            $res = preg_match_all('/{{content:[0-9]*}}/', $tpl->description, $matches);
            if($res) {
                $matches = array_unique($matches);
                foreach($matches[0] AS $pattern) {
                    preg_match('/[0-9]+/', $pattern, $m);
                    $from[] = $pattern;
                    $to[] = Text::limit_words($text, $m[0]);
                }
            }

            $title = $page->title ? $page->title : $tpl->title;
            $h1 = $page->h1 ? $page->h1 : $tpl->h1;
            $keywords = $page->keywords ? $page->keywords : $tpl->keywords;
            $description = $page->description ? $page->description : $tpl->description;

            $this->_seo['h1'] = str_replace($from, $to, $h1);
            $this->_seo['title'] = str_replace($from, $to, $title)
                .((Arr::get($_GET, 'sort') == 'cost' && Arr::get($_GET, 'type') == 'asc') ? ', От бютжетных к дорогим' : '')
                .((Arr::get($_GET, 'sort') == 'cost' && Arr::get($_GET, 'type') == 'desc') ? ', От дорогих к бютжетным' : '')
                .((Arr::get($_GET, 'sort') == 'created_at' && Arr::get($_GET, 'type') == 'desc') ? ', От новых моделей к старым' : '')
                .((Arr::get($_GET, 'sort') == 'created_at' && Arr::get($_GET, 'type') == 'asc') ? ', От старых моделей к новым' : '')
                .((Arr::get($_GET, 'sort') == 'name' && Arr::get($_GET, 'type') == 'asc') ? ', По названию от А до Я' : '')
                .((Arr::get($_GET, 'sort') == 'name' && Arr::get($_GET, 'type') == 'desc') ? ', По названию от Я до А' : '')
                .(Arr::get($_GET, 'page', 1) > 1 ? ', Страница '.Arr::get($_GET, 'page', 1) : '');;
            $this->_seo['keywords'] = str_replace($from, $to, $keywords);
            $this->_seo['description'] = str_replace($from, $to, $description);
            $this->_seo['seo_text'] = $page->text;
            $this->generateParentBreadcrumbs( $page->parent_id, 'catalog_tree', 'parent_id', '/products/' );
            $this->setBreadcrumbs( $page->name );
        }

    }