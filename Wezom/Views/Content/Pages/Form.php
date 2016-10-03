<?php echo \Forms\Builder::open(); ?>
    <div class="form-actions" style="display: none;">
        <?php echo \Forms\Form::submit(array('name' => 'name', 'value' => 'Отправить', 'class' => 'submit btn btn-primary pull-right')); ?>
    </div>
    <div class="col-md-7">
        <div class="widget box">
            <div class="widgetHeader">
                <div class="widgetTitle">
                    <i class="fa-reorder"></i>
                    Основные данные
                </div>
            </div>
            <div class="widgetContent">
                <div class="form-vertical row-border">
                    <div class="form-group">
                        <?php echo \Forms\Builder::bool($obj->status); ?>
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
                        <?php echo \Forms\Builder::select('<option value="0">Вехний уровень</option>'.$tree,
                            $obj->parent_id, array(
                                'name' => 'FORM[parent_id]',
                                'class' => 'valid',
                            ), 'Группа'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo \Forms\Builder::tiny(array(
                            'name' => 'FORM[text]',
                            'value' => $obj->text,
                        ), 'Контент'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="widget box">
            <div class="widgetHeader">
                <div class="widgetTitle">
                    <i class="fa-reorder"></i>
                    Мета-данные
                </div>
            </div>
            <div class="widgetContent">
                <div class="form-vertical row-border">
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
                </div>
            </div>
            <div class="pageInfo alert alert-info">
                <div class="rowSection">
                    <div class="col-md-6"><strong>Опубликовано</strong></div>
                    <div class="col-md-6"><?php echo $obj->status == 1 ? 'Да' : 'Нет'; ?></div>
                </div>
                <div class="rowSection">
                    <div class="col-md-6"><strong>Дата создания</strong></div>
                    <div class="col-md-6"><?php echo $obj->created_at ? date('d.m.Y H:i:s', $obj->created_at) : '---'; ?></div>
                </div>
                <div class="rowSection">
                    <div class="col-md-6"><strong>Дата последнего изменения</strong></div>     
                    <div class="col-md-6"><?php echo $obj->updated_at ? date('d.m.Y H:i:s', $obj->updated_at) : '---'; ?></div>
                </div>
            </div>
        </div>
    </div>
<?php echo \Forms\Form::close(); ?>