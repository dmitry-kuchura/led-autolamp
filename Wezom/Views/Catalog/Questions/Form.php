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
                    <?php if ($obj->created_at): ?>
                        <div class="form-group">
                            <label class="control-label">Дата</label>
                            <?php echo date( 'd.m.Y H:i:s', $obj->created_at ); ?>
                        </div>
                    <?php endif ?>
                    <div class="form-group">
                        <label class="control-label">IP</label>
                        <?php echo $obj->ip; ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Товар</label>
                        <?php if (!$item): ?>
                            <span style="color: #ccc; font-style: italic;">( Удален )</span>
                        <?php else: ?>
                            <a href="/wezom/catalog/new/id/<?php echo $obj->id; ?>" target="_blank"><?php echo $item->name; ?></a>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Имя</label>
                        <?php echo $obj->name; ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">E-mail</label>
                        <a href="mailto:<?php echo $obj->email; ?>"><?php echo $obj->email; ?></a>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Сообщение</label>
                        <?php echo $obj->text; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo \Forms\Form::close(); ?>