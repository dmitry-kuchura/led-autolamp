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
                        <label class="control-label">Наименование шаблона</label>
                        <div class="red" style="font-weight: bold;"><?php echo $obj->name; ?></div>
                    </div>
                    <div class="form-group">
                        <?php echo \Forms\Builder::bool($obj->status); ?>
                    </div>
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
                        ), 'Шаблон'); ?>
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
                    Переменные
                </div>
            </div>
            <div class="pageInfo alert alert-info">
                <?php if ($obj->id == 1): ?>
                    <div class="rowSection">
                        <div class="col-md-6"><strong>Имя</strong></div>
                        <div class="col-md-6">{{name}}</div>
                    </div>
                    <div class="rowSection">
                        <div class="col-md-6"><strong>Телефон</strong></div>
                        <div class="col-md-6">{{phone}}</div>
                    </div>
                    <div class="rowSection">
                        <div class="col-md-6"><strong>Цоколь</strong></div>
                        <div class="col-md-6">{{cap}}</div>
                    </div>
                    <div class="rowSection">
                        <div class="col-md-6"><strong>Кол-во</strong></div>
                        <div class="col-md-6">{{count}}</div>
                    </div>
                <?php endif; ?>
                <?php if ($obj->id == 2): ?>
                    <div class="rowSection">
                        <div class="col-md-6"><strong>Имя</strong></div>
                        <div class="col-md-6">{{name}}</div>
                    </div>
                    <div class="rowSection">
                        <div class="col-md-6"><strong>Телефон</strong></div>
                        <div class="col-md-6">{{phone}}</div>
                    </div>
                    <div class="rowSection">
                        <div class="col-md-6"><strong>Скидка</strong></div>
                        <div class="col-md-6">{{deliver}}</div>
                    </div>
                    <div class="rowSection">
                        <div class="col-md-6"><strong>% Скидки</strong></div>
                        <div class="col-md-6">{{percent}}</div>
                    </div>
                <?php endif; ?>
                <?php if ($obj->id == 2): ?>
                    <div class="rowSection">
                        <div class="col-md-6"><strong>Имя</strong></div>
                        <div class="col-md-6">{{name}}</div>
                    </div>
                    <div class="rowSection">
                        <div class="col-md-6"><strong>Телефон</strong></div>
                        <div class="col-md-6">{{phone}}</div>
                    </div>
                    <div class="rowSection">
                        <div class="col-md-6"><strong>Скидка</strong></div>
                        <div class="col-md-6">{{deliver}}</div>
                    </div>
                    <div class="rowSection">
                        <div class="col-md-6"><strong>% Скидки</strong></div>
                        <div class="col-md-6">{{percent}}</div>
                    </div>
                <?php endif; ?>
                <?php if ($obj->id == 3 OR $obj->id == 4): ?>
                    <div class="rowSection">
                        <div class="col-md-6"><strong>Имя покупателя</strong></div>
                        <div class="col-md-6">{{name}}</div>
                    </div>
                    <div class="rowSection">
                        <div class="col-md-6"><strong>Марка автомобиля</strong></div>
                        <div class="col-md-6">{{mark}}</div>
                    </div>
                    <div class="rowSection">
                        <div class="col-md-6"><strong>Модель автомобиля</strong></div>
                        <div class="col-md-6">{{model}}</div>
                    </div>
                    <div class="rowSection">
                        <div class="col-md-6"><strong>Email</strong></div>
                        <div class="col-md-6">{{email}}</div>
                    </div>
                    <div class="rowSection">
                        <div class="col-md-6"><strong>Год выпуска</strong></div>
                        <div class="col-md-6">{{year}}</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php echo \Forms\Form::close(); ?>