<?php echo \Forms\Builder::open(); ?>
    <div class="form-actions" style="display: none;">
        <?php echo \Forms\Form::submit(array('name' => 'name', 'value' => 'Отправить', 'class' => 'submit btn btn-primary pull-right')); ?>
    </div>
    <div class="col-md-12">
        <div class="widget box">
            <div class="widgetHeader">
                <div class="widgetTitle">
                    <i class="fa-reorder"></i>
                    Общая информация
                </div>
            </div>
            <div class="widgetContent">
                <div class="form-vertical row-border">
                    <div class="form-group">
                        <?php echo \Forms\Builder::input(array(
                            'name' => 'FORM[name]',
                            'value' => $obj->name,
                            'class' => 'valid',
                        ), 'Название'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo \Forms\Builder::input(array(
                            'name' => 'FORM[description]',
                            'value' => $obj->description,
                        ), 'Описание'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="widget box">
            <div class="widgetHeader">
                <div class="widgetTitle">
                    <i class="fa-reorder"></i>
                    Доступ к разделам
                </div>
            </div>
            <div class="widgetContent">
                <div class="form-vertical row-border">
                    <?php foreach( \Core\Config::get('access') AS $el ): ?>
                        <?php $ac = \Core\Arr::get($access, $el['controller'], 'no'); ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $el['name']; ?></label>
                            <div class="clear"></div>
                            <label class="checkerWrap-inline">
                                <?php echo \Forms\Builder::radio($ac == 'no' ? true : false, array(
                                    'name' => $el['controller'],
                                    'value' => 'no',
                                )); ?>
                                Нет прав
                            </label>
                            <?php if( \Core\Arr::get($el, 'view', 1) ): ?>
                                <label class="checkerWrap-inline">
                                    <?php echo \Forms\Builder::radio($ac == 'view' ? true : false, array(
                                        'name' => $el['controller'],
                                        'value' => 'view',
                                    )); ?>
                                    Только просмотр
                                </label>
                            <?php endif; ?>
                            <?php if( \Core\Arr::get($el, 'edit', 1) ): ?>
                                <label class="checkerWrap-inline">
                                    <?php echo \Forms\Builder::radio($ac == 'edit' ? true : false, array(
                                        'name' => $el['controller'],
                                        'value' => 'edit',
                                    )); ?>
                                    Просмотр и редактирование
                                </label>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php echo \Forms\Form::close(); ?>