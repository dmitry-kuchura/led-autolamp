<?php if (strripos($_SERVER['REQUEST_URI'], 'edit') AND $obj == null): ?>
    <p>Заказ был удален!</p>
<?php else: ?>
<?php echo \Forms\Builder::open(); ?>
    <div class="form-actions" style="display: none;">
        <?php echo \Forms\Form::submit(['name' => 'name', 'value' => 'Отправить', 'class' => 'submit btn btn-primary pull-right']); ?>
    </div>
    <div class="col-md-12">
        <div class="widget">
            <div class="widgetContent">
                <div class="form-vertical row-border">
                    <div class="form-group">
                        <?php echo \Forms\Builder::bool($obj->status); ?>
                    </div>
                    <?php if ($obj->created_at): ?>
                        <div class="form-group">
                            <label class="control-label">Дата</label>
                            <?php echo date('d.m.Y H:i:s', $obj->created_at); ?>
                        </div>
                    <?php endif ?>
                    <div class="form-group">
                        <label class="control-label">Имя</label>
                        <?php echo $obj->name; ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Марка</label>
                        <?php echo $obj->mark; ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Модель</label>
                        <?php echo $obj->model; ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Тип двигателя</label>
                        <?php echo $obj->engine; ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Год выпуска</label>
                        <?php echo $obj->year; ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Email</label>
                        <a href="mailto:<?php echo $obj->email; ?>"><?php echo $obj->email; ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo \Forms\Form::close(); ?>
<?php endif; ?>
