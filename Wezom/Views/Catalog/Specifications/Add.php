<?php echo \Forms\Builder::open(); ?>
    <div class="form-actions" style="display: none;">
        <?php echo \Forms\Form::submit(array('name' => 'name', 'value' => 'Отправить', 'class' => 'submit btn btn-primary pull-right')); ?>
    </div>
    <div class="col-md-12">
        <div class="widget box">
            <div class="widgetHeader">
                <div class="widgetTitle">
                    <i class="fa-reorder"></i>
                    Данные
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
                        <?php echo \Forms\Builder::select(\Core\Support::selectData($types, 'id', 'name', ''),
                            $obj->type_id, array(
                                'name' => 'FORM[type_id]',
                                'class' => 'valid',
                            ), 'Тип'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo \Forms\Form::close(); ?>