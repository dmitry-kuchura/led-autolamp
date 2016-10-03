<?php echo \Forms\Builder::open(); ?>
    <div class="form-actions" style="display: none;">
        <?php echo \Forms\Form::submit(array('name' => 'name', 'value' => 'Отправить', 'class' => 'submit btn btn-primary pull-right')); ?>
    </div>
    <div class="col-md-12">
        <div class="widget">
            <div class="widgetContent">
                <div class="form-vertical row-border">
                    <div class="form-group">
                        <?php echo \Forms\Builder::bool($obj->status); ?>
                    </div>
                    <div class="form-group">
                        <?php $options = array(
                            'head' => 'Вставить перед </head>',
                            'body' => 'Вставить после </body>',
                            'counter' => 'Счетчик (в футере)',
                        ); ?>
                        <?php echo \Forms\Builder::select($options,
                            $obj->place, array(
                                'name' => 'FORM[place]',
                                'class' => 'valid',
                            ), 'Место расположения'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo \Forms\Builder::input(array(
                            'name' => 'FORM[name]',
                            'value' => $obj->name,
                            'class' => 'valid',
                        ), 'Название'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo \Forms\Builder::textarea(array(
                            'name' => 'FORM[script]',
                            'value' => $obj->script,
                            'rows' => 20,
                        ), 'Код'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo \Forms\Form::close(); ?>