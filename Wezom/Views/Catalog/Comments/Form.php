<?php echo \Forms\Builder::open(); ?>
    <div class="form-actions" style="display: none;">
        <?php echo \Forms\Form::submit(array('name' => 'name', 'value' => 'Отправить', 'class' => 'submit btn btn-primary pull-right')); ?>
    </div>
    <div class="rowSection">
        <div class="col-md-6">
            <div class="widget box loadedBox">
                <div class="widgetHeader myWidgetHeader">
                    <div class="widgetTitle">
                        <i class="fa-file"></i>
                        Основный данные
                    </div>
                </div>
                <div class="widgetContent">
                    <div class="form-vertical row-border">
                        <div class="widgetContent" style="min-height: 150px;">
                            <div id="itemPlace" class="form-vertical row-border">
                                <?php if($item): ?>
                                    <?php if(is_file(HOST.\Core\HTML::media('images/catalog/big/'.$item->image))): ?>
                                        <a rel="lightbox" href="<?php echo \Core\HTML::media('images/catalog/big/'.$item->image); ?>">
                                            <img class="someImage" src="<?php echo \Core\HTML::media('images/catalog/medium/'.$item->image); ?>">
                                        </a>
                                    <?php endif; ?>
                                    <div class="someBlock">
                                        <a target="_blank" href="/wezom/items/edit/<?php echo $item->id; ?>"><?php echo $item->name; ?></a>
                                    </div>
                                    <div class="someBlock">
                                        <b>Бренд:</b> <a target="_blank" href="/wezom/brands/edit/<?php echo $item->brand_id; ?>">Nike</a>
                                    </div>
                                    <div class="someBlock">
                                        <b>Цена:</b> <?php echo $item->cost; ?> грн
                                    </div>
                                <?php else: ?>
                                    <p class="relatedMessage">Еще не выбран ни один товар!</p>
                                <?php endif; ?>
                            </div>
                            <div class="clear"></div>
                            <div class="form-group">
                                <?php echo \Forms\Builder::bool($obj->status); ?>
                            </div>
                            <div class="form-group">
                                <?php echo \Forms\Builder::input(array(
                                    'name' => 'FORM[date]',
                                    'value' => $obj->date ? date('d.m.Y', $obj->date) : NULL,
                                    'class' => 'myPicker',
                                ), 'Дата'); ?>
                            </div>
                            <div class="form-group">
                                <?php echo \Forms\Builder::input(array(
                                    'name' => 'FORM[name]',
                                    'value' => $obj->name,
                                    'class' => 'valid',
                                ), 'Имя'); ?>
                            </div>
                            <div class="form-group">
                                <?php echo \Forms\Builder::input(array(
                                    'name' => 'FORM[city]',
                                    'value' => $obj->city,
                                    'class' => 'valid',
                                ), 'Город'); ?>
                            </div>
                            <div class="form-group">
                                <?php echo \Forms\Builder::textarea(array(
                                    'name' => 'FORM[text]',
                                    'value' => str_replace(array('<br />', '<br>', '<br/>'), "", $obj->text),
                                    'class' => 'valid',
                                ), 'Сообщение'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="catalog_id" value="<?php echo $item->id; ?>" id="orderItemId" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="widget box loadedBox" id="orderItemsBlock">
                <div class="widgetHeader myWidgetHeader">
                    <div class="widgetTitle">
                        <i class="fa-file"></i>
                        Изменить товар
                    </div>
                </div>
                <div class="widgetContent">
                    <div class="form-vertical row-border">
                        <div id="orderItemsBlock">
                            <div class="form-group" style="margin-top: 10px;">
                                <div class="col-md-5">
                                    <?php echo \Forms\Builder::select('<option value="0"> - Не выбрано - </option>'.$tree,
                                        NULL, array(
                                            'data-name' => 'parent_id',
                                        )); ?>
                                </div>
                                <div class="col-md-7">
                                    <?php echo \Forms\Builder::input(array(
                                        'name' => 'search',
                                        'placeholder' => 'Начните вводить название или артикул товара',
                                    )); ?>
                                </div>
                            </div>
                            <div class="widgetContent" style="min-height: 150px;">
                                <div id="orderItemsList" class="form-vertical row-border" data-id="<?php echo \Core\Route::param('id'); ?>" data-limit="5">
                                    <p class="relatedMessage">Выберите группу или начните писать название товара или артикул в поле для ввода расположенном выше. После чего на этом месте появится список товаров</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo \Forms\Form::close(); ?>

<script>
    $(function(){
        var pickerInit = function( selector ) {
            var date = $(selector).val();
            $(selector).datepicker({
                showOtherMonths: true,
                selectOtherMonths: false
            });
            $(selector).datepicker('option', $.datepicker.regional['ru']);
            var dateFormat = $(selector).datepicker( "option", "dateFormat" );
            $(selector).datepicker( "option", "dateFormat", 'dd.mm.yy' );
            $(selector).val(date);
        };
        pickerInit('.myPicker');
    });
</script>