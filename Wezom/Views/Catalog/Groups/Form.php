<?php echo \Forms\Builder::open(); ?>
    <div class="form-actions" style="display: none;">
        <?php echo \Forms\Form::submit(array('name' => 'name', 'value' => 'Отправить', 'class' => 'submit btn btn-primary pull-right')); ?>
    </div>
    <div class="col-md-7">
        <div class="widget box">
            <div class="widgetContent">
                <div class="form-vertical row-border">
                    <ul class="liTabs t_wrap">
                        <li class="t_item">
                            <a class="t_link" href="#">Основные данные</a>
                            <div class="t_content">
                                <div class="form-group">
                                    <?php echo \Forms\Builder::bool($obj->status); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo \Forms\Builder::select('<option value="0">Вехний уровень</option>'.$tree,
                                        NULL, array(
                                            'name' => 'FORM[parent_id]',
                                            'class' => 'valid',
                                        ), 'Группа'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo \Forms\Builder::input(array(
                                        'name' => 'FORM[name]',
                                        'value' => $obj->name,
                                        'class' => array('valid', 'translitSource'),
                                    ), 'Название'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo \Forms\Builder::alias(array(
                                        'name' => 'FORM[alias]',
                                        'value' => $obj->alias,
                                        'class' => 'valid',
                                    ), array(
                                        'text' => 'Алиас',
                                        'tooltip' => '<b>Алиас (англ. alias - псевдоним)</b><br>Алиасы используются для короткого именования страниц. <br>Предположим, имеется страница с псевдонимом «<b>about</b>». Тогда для вывода этой страницы можно использовать или полную форму: <br><b>http://domain/?go=frontend&page=about</b><br>или сокращенную: <br><b>http://domain/about.html</b>',
                                    )); ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Обложка для списков</label>
                                    <div>
                                        <?php if (is_file( HOST . Core\HTML::media('images/catalog_tree/'.$obj->image))): ?>
                                            <div class="contentImageView max212">
                                                <a href="<?php echo Core\HTML::media('images/catalog_tree/'.$obj->image); ?>" class="mfpImage">
                                                    <img src="<?php echo Core\HTML::media('images/catalog_tree/'.$obj->image); ?>" />
                                                </a> 
                                                <div class="contentImageControl">
                                                    <a class="btn btn-danger otherBtn" href="/wezom/<?php echo Core\Route::controller(); ?>/delete_image/<?php echo $obj->id; ?>" onclick="return confirm('Это действие удалит изображение безвозвратно. Продолжить?');">
                                                        <i class="fa-remove"></i>
                                                        Удалить изображение
                                                    </a> 
                                                </div>                                    
                                            </div>
                                        <?php else: ?>
                                            <?php echo \Forms\Builder::file(array('name' => 'file')); ?>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="t_item">
                            <a class="t_link" href="#">Мета-данные</a>
                            <div class="t_content">
                                <div style="font-weight: bold; margin-bottom: 10px;"><span class="red">Внимание!</span> Незаполненные данные будут подставлены по <a href="<?php echo \Core\HTML::link('wezom/seo_templates/edit/1'); ?>" target="_blank">шаблону</a></div>
                                <div class="form-group">
                                    <?php echo \Forms\Builder::input(array(
                                        'name' => 'FORM[h1]',
                                        'value' => $obj->h1,
                                    ), array(
                                        'text' => 'H1',
                                        'tooltip' => 'Рекомендуется, чтобы тег h1 содержал ключевую фразу, которая частично или полностью совпадает с title',
                                    )); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo \Forms\Builder::input(array(
                                        'name' => 'FORM[title]',
                                        'value' => $obj->title,
                                    ), array(
                                        'text' => 'Title',
                                        'tooltip' => '<p>Значимая для продвижения часть заголовка должна быть не более 12 слов</p><p>Самые популярные ключевые слова должны идти в самом начале заголовка и уместиться в первых 50 символов, чтобы сохранить привлекательный вид в поисковой выдаче.</p><p>Старайтесь не использовать в заголовке следующие знаки препинания – . ! ? – </p>',
                                    )); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo \Forms\Builder::textarea(array(
                                        'name' => 'FORM[keywords]',
                                        'rows' => 5,
                                        'value' => $obj->keywords,
                                    ), array(
                                        'text' => 'Keywords',
                                    )); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo \Forms\Builder::textarea(array(
                                        'name' => 'FORM[description]',
                                        'value' => $obj->description,
                                        'rows' => 5,
                                    ), array(
                                        'text' => 'Description',
                                    )); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo \Forms\Builder::tiny(array(
                                        'name' => 'FORM[text]',
                                        'value' => $obj->text,
                                    ), array(
                                        'text' => 'SEO текст',
                                    )); ?>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="widget box">
            <div class="widgetHeader">
                <div class="widgetTitle">
                    <i class="fa-reorder"></i>
                    Допустимые параметры товаров
                </div>
            </div>
            <div class="widgetContent">
                <div class="form-vertical row-border">
                    <div class="form-group multiSelectBlock">
                        <?php echo \Forms\Builder::select(\Core\Support::selectData($brands, 'id', 'name'), $groupBrands, array(
                            'name' => 'BRANDS[]',
                            'multiple' => 'multiple',
                        ), 'Бренды'); ?>
                    </div>
                    <div class="form-group multiSelectBlock">
                        <?php echo \Forms\Builder::select(\Core\Support::selectData($specifications, 'id', 'name'), $groupSpec, array(
                            'name' => 'SPEC[]',
                            'multiple' => 'multiple',
                        ), 'Характеристики'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo \Forms\Form::close(); ?>