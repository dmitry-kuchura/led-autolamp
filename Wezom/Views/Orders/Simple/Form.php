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
                        <label class="control-label">% скидки</label>
                        <?php echo $obj->percent; ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Скидка</label>
                        <?php echo $obj->deliver; ?><span style="color: #ccc; font-style: italic;"> ( грн. )</span>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Номер телефона</label>
                        <a href="tel:<?php echo $obj->phone; ?>"><?php echo $obj->phone; ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo \Forms\Form::close(); ?>