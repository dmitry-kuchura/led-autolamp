<?php echo \Forms\Builder::open(); ?>
    <div class="form-actions" style="display: none;">
        <?php echo \Forms\Form::submit(array('name' => 'name', 'value' => 'Отправить', 'class' => 'submit btn btn-primary pull-right')); ?>
    </div>
    <div class="col-md-12">
        <div class="widget">
            <div class="widgetContent">
                <div class="form-vertical row-border">
                    <div class="form-group">
                        <?php echo \Forms\Builder::input(array(
                            'name' => 'name',
                            'value' => $obj->name,
                            'class' => 'valid',
                        ), 'Имя'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo \Forms\Builder::input(array(
                            'name' => 'login',
                            'value' => $obj->login,
                            'class' => 'valid',
                        ), 'Логин'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo \Forms\Builder::password(array(
                            'name' => 'password',
                            'class' => 'valid',
                        ), 'Старый пароль'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo \Forms\Builder::password(array(
                            'name' => 'new_password',
                            'class' => 'valid',
                        ), 'Новый пароль'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo \Forms\Builder::password(array(
                            'name' => 'confirm_password',
                            'class' => 'valid',
                        ), 'Подтвердите пароль'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo \Forms\Form::close(); ?>