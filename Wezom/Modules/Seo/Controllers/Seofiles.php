<?php
    namespace Wezom\Modules\Seo\Controllers;

    use Core\Config;
    use Core\HTML;
    use Core\Route;
    use Core\Widgets;
    use Core\View;
    use Core\Message;
    use Core\HTTP;
	use Core\Files;
    use Core\Arr;
	use Core\Support;

    use Wezom\Modules\Seo\Models\Links AS Model;

    class Seofiles extends \Wezom\Modules\Base {

        public $tpl_folder = 'Seo/Files';
        public $page;
        public $limit;
        public $offset;

        function before() {
            parent::before();
            $this->_seo['h1'] = 'Список файлов';
            $this->_seo['title'] = 'Список файлов';
            $this->setBreadcrumbs('Список файлов', 'wezom/seo_files/index');

        }

        function indexAction () {
           
			$files=Support::getFiles('',array('txt','html'));
            $this->_content = View::tpl(
                array(
                    'result' => $files,
                ), $this->tpl_folder.'/Index');
        }

        function addAction () {
            if (Arr::get( $_FILES['file'], 'tmp_name')) {
				$name=Arr::get( $_FILES['file'], 'name');
				if (is_file(HOST.'/'.$name)) {
					Message::GetMessage(0, 'Файл с именем '.$name.' уже существует! Сначала удалите существующий файл!');
					HTTP::redirect('wezom/seo_files/index');
				}
				$filename=Files::uploadFileOriginal();
				if(is_file(HOST.'/'.$filename)) {
					Message::GetMessage(1, 'Вы успешно добавили данные!');
					switch (Arr::get($_POST, 'button', 'save')) {
						case 'save-close':
							HTTP::redirect('wezom/seo_files/index');
							break;
						case 'save-add':
							HTTP::redirect('wezom/seo_files/add');
							break;
						default:
							$link=urlencode(base64_encode($filename));
							HTTP::redirect('wezom/seo_files/edit/' . $link);
							break;
					}
				} else {
					Message::GetMessage(0, 'Не удалось добавить данные!');
				}
            } 
            $this->_toolbar = Widgets::get( 'Toolbar_Edit', array('list_link' => '/wezom/seo_files/index') );
            $this->_seo['h1'] = 'Добавление';
            $this->_seo['title'] = 'Добавление';
            $this->setBreadcrumbs('Добавление', 'wezom/seo_files/add');
            $this->_content = View::tpl(
                array(
                    'obj' => $result,
                    'tpl_folder' => $this->tpl_folder,
                ), $this->tpl_folder.'/Add');
        }

        function editAction () {
			
			$name=base64_decode(rawurldecode((Route::param('filename'))));
			if (!is_file(HOST.'/'.$name)) {
				Message::GetMessage(0, 'Такого файла на существует!');
				HTTP::redirect('wezom/seo_files/index');
			}
			
            if ($_POST) {
				$text= $_POST['FORM']['text'];
				file_put_contents(HOST.'/'.$name,$text);
				 Message::GetMessage(1, 'Вы успешно изменили данные!');
				switch (Arr::get($_POST, 'button', 'save')) {
					case 'save-close':
						HTTP::redirect('wezom/seo_files/index');
						break;
					case 'save-add':
						HTTP::redirect('wezom/seo_files/add');
						break;
					default:
						HTTP::redirect('wezom/seo_files/edit/' . Route::param('filename'));
						break;
				}
            } 

			$text=file_get_contents(HOST.'/'.$name);
			
            $this->_toolbar = Widgets::get( 'Toolbar_Edit', array('list_link' => '/wezom/seo_files/index','noAdd'=>1) );
            $this->_seo['h1'] = 'Редактирование';
            $this->_seo['title'] = 'Редактирование';
            $this->setBreadcrumbs('Редактирование', 'wezom/seo_links/edit/'.Route::param('id'));
            $this->_content = View::tpl(
                array(
                    'text' => $text,
					'name' => $name,
                    'tpl_folder' => $this->tpl_folder,
                ), $this->tpl_folder.'/Form');
        }

        function deleteAction() {
			$name=base64_decode(rawurldecode((Route::param('filename'))));
            if(!is_file(HOST.'/'.$name)) {
                Message::GetMessage(0, 'Данные не существуют!');
                HTTP::redirect('wezom/seo_files/index');
            }
            @unlink(HOST.'/'.$name);
            Message::GetMessage(1, 'Данные удалены!');
            HTTP::redirect('wezom/seo_files/index');
        }

    }