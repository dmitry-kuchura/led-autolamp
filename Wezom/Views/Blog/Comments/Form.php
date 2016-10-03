<?php echo \Forms\Builder::open(array('data-action' => 'blog')); ?>
    <div class="form-actions" style="display: none;">
        <?php echo \Forms\Form::submit(array('name' => 'name', 'value' => 'Отправить', 'class' => 'submit btn btn-primary pull-right')); ?>
    </div>
    <div class="rowSection">
        <div class="col-md-6">
            <div class="widget box loadedBox">
                <div class="widgetHeader myWidgetHeader">
                    <div class="widgetTitle">
                        <i class="fa-file"></i>
                        Основные данные
                    </div>
                </div>
                <div class="widgetContent">
                    <div class="form-vertical row-border">
                        <div class="widgetContent" style="min-height: 150px;">
                            <div class="form-vertical row-border" id="itemPlace">
                                <?php if($item): ?>
                                    <?php if(is_file(HOST.\Core\HTML::media('images/blog/big/'.$item->image))): ?>
                                        <a rel="lightbox" href="<?php echo \Core\HTML::media('images/blog/big/'.$item->image); ?>">
                                            <img class="someImage" src="<?php echo \Core\HTML::media('images/blog/small/'.$item->image); ?>">
                                        </a>
                                    <?php endif; ?>
                                    <div class="someBlock">
                                        <a target="_blank" href="/wezom/blog/edit/<?php echo $item->id; ?>"><?php echo $item->name; ?></a>
                                    </div>
                                    <?php if( $item->rubric ): ?>
                                        <div class="someBlock">
                                            <b>Рубрика:</b> <?php echo $item->rubric; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if( $item->date ): ?>
                                        <div class="someBlock">
                                            <b>Дата публикации:</b> <?php echo date('d.m.Y', $item->date); ?>
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <p class="relatedMessage">Еще не выбрана ни одна запись из блога!</p>
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
                                    'class' => array('valid', 'myPicker'),
                                ), 'Дата комментария'); ?>
                            </div>
                            <div class="form-group">
                                <?php echo \Forms\Builder::input(array(
                                    'name' => 'FORM[name]',
                                    'value' => $obj->name,
                                    'class' => 'valid',
                                ), 'Имя'); ?>
                            </div>
                            <div class="form-group">
                                <?php echo \Forms\Builder::textarea(array(
                                    'name' => 'FORM[text]',
                                    'class' => 'valid',
                                    'value' => $obj->text,
                                ), 'Сообщение'); ?>
                            </div>
                            <div class="form-group">
                                <?php echo \Forms\Builder::input(array(
                                    'name' => 'FORM[date_answer]',
                                    'value' => $obj->date_answer ? date('d.m.Y', $obj->date_answer) : NULL,
                                    'class' => 'myPicker2',
                                ), 'Дата ответа администратора'); ?>
                            </div>
                            <div class="form-group">
                                <?php echo \Forms\Builder::textarea(array(
                                    'name' => 'FORM[answer]',
                                    'value' => $obj->answer,
                                ), 'Ответ администратора'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo \Forms\Form::hidden(array('name' => 'blog_id', 'id' => 'orderItemId')); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="widget box loadedBox" id="orderItemsBlock">
                <div class="widgetHeader myWidgetHeader">
                    <div class="widgetTitle">
                        <i class="fa-file"></i>
                        Указать запись из блога
                    </div>
                </div>
                <div class="widgetContent">
                    <div class="form-vertical row-border">
                        <div id="orderItemsBlock">
                            <div class="form-group" style="margin-top: 10px;">
                                <div class="col-md-5">
                                    <?php echo \Forms\Builder::select(\Core\Support::selectData($rubrics, 'id', 'name', array(
                                        0, ' - Не выбрано - '
                                    )), $obj->rubric_id, array(
                                        'name' => 'rubric_id',
                                    )); ?>
                                </div>
                                <div class="col-md-7">
                                    <?php echo \Forms\Builder::input(array(
                                        'name' => 'search',
                                        'placeholder' => 'Начните вводить название записи',
                                    )); ?>
                                </div>
                            </div>
                            <div class="widgetContent" style="min-height: 150px;">
                                <div id="orderItemsList" class="form-vertical row-border" data-id="<?php echo \Core\Route::param('id'); ?>" data-limit="16">
                                    <p class="relatedMessage">Выберите рубрику или начните писать название записи в блоге в поле для ввода расположенном выше. После чего на этом месте появится список отфильтрованных записей</p>
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
        pickerInit('.myPicker2');
    });
</script>