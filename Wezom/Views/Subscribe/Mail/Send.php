<?php echo \Forms\Builder::open(); ?>
    <div class="form-actions" style="display: none;">
        <?php echo \Forms\Form::submit(array('name' => 'name', 'value' => 'Отправить', 'class' => 'submit btn btn-primary pull-right')); ?>
    </div>
    <div class="col-md-7">
        <div class="widget box">
            <div class="widgetHeader">
                <div class="widgetTitle">
                    <i class="fa-reorder"></i>
                    Данные для отправки
                </div>
            </div>
            <div class="widgetContent">
                <div class="form-vertical row-border">
                    <div class="form-group">
                        <?php echo \Forms\Builder::input(array(
                            'name' => 'FORM[subject]',
                            'value' => $obj->subject,
                            'class' => 'valid',
                        ), 'Тема'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo \Forms\Builder::tiny(array(
                            'name' => 'FORM[text]',
                            'value' => $obj->text,
                        ), 'Содержание <span style="color:red;">*</span>'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="widget">
            <div class="widgetHeader">
                <div class="widgetTitle">
                    <i class="fa-reorder"></i>
                    Заменяемые данные
                </div>
            </div>
            <div class="pageInfo alert alert-info">
                <div class="rowSection">
                    <div class="col-md-6"><strong>Ссылка для отписки от рассылки</strong></div>
                    <div class="col-md-6">{{unsubscribe}}</div>
                </div>
                <div class="rowSection">
                    <div class="col-md-6"><strong>Доменное имя сайта</strong></div>
                    <div class="col-md-6">{{site}}</div>
                </div>
                <div class="rowSection">
                    <div class="col-md-6"><strong>Текущая дата в формате dd.mm.YYYY</strong></div>
                    <div class="col-md-6">{{date}}</div>
                </div>
            </div>
        </div>
    </div>
<?php echo \Forms\Form::close(); ?>