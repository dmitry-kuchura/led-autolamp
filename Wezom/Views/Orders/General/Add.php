<?php echo \Forms\Builder::open(array('data-action' => 'users')); ?>
    <div class="form-actions" style="display: none;">
        <?php echo \Forms\Form::submit(array('name' => 'name', 'value' => 'Отправить', 'class' => 'submit btn btn-primary pull-right')); ?>
    </div>
    <div class="col-md-6">
        <div class="widget">
            <div class="widgetContent">
                <div class="form-vertical row-border">
                    <div id="itemPlace" class="row-border">
                        <?php if( $item ): ?>
                            <div class="someBlock">
                                <a target="_blank" href="/wezom/users/edit/<?php echo $item->id; ?>"><?php echo $item->last_name.' '.$item->name.' '.$item->middle_name; ?></a>
                            </div>
                            <div class="someBlock"><b>E-Mail:</b> <a href="mailto:<?php echo $item->email; ?>"><?php echo $item->email; ?></a></div>
                            <div class="someBlock"><b>Номер телефона:</b> <?php echo $item->phone; ?></div>
                        <?php else: ?>
                            <p class="relatedMessage">Если нужно привязать конкретного пользователя под заказ, найдите и выберите его в списке справа!</p>
                        <?php endif; ?>
                    </div>
                    <div class="clear"></div>
                    <div class="form-group">
                        <?php echo \Forms\Builder::input(array(
                            'name' => 'last_name',
                            'value' => $obj->last_name,
                            'class' => 'valid',
                        ), 'Фамилия'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo \Forms\Builder::input(array(
                            'name' => 'name',
                            'value' => $obj->name,
                            'class' => 'valid',
                        ), 'Имя'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo \Forms\Builder::input(array(
                            'name' => 'middle_name',
                            'value' => $obj->middle_name,
                        ), 'Отчество'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo \Forms\Builder::input(array(
                            'name' => 'phone',
                            'value' => $obj->phone,
                            'class' => 'valid',
                        ), 'Номер телефона'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo \Forms\Builder::input(array(
                            'name' => 'email',
                            'value' => $obj->email,
                            'class' => 'valid email',
                        ), 'E-Mail'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo \Forms\Builder::select($payment,
                            $obj->payment, array(
                                'name' => 'payment',
                            ), 'Способ оплаты'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo \Forms\Builder::select($delivery,
                            $obj->delivery, array(
                                'name' => 'delivery',
                            ), 'Способ доставки'); ?>
                    </div>
                    <?php echo \Forms\Builder::hidden(array(
                        'name' => 'user_id',
                        'value' => $item->id,
                        'id' => 'orderItemId',
                    )); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="widget box loadedBox" id="orderItemsBlock">
            <div class="widgetHeader myWidgetHeader">
                <div class="widgetTitle">
                    <i class="fa-file"></i>
                    Указать пользователя
                </div>
            </div>
            <div class="widgetContent">
                <div class="form-vertical row-border">
                    <div id="orderItemsBlock" class="usersSearchBlock">
                        <div class="form-group" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <?php echo \Forms\Builder::input(array(
                                    'name' => 'search',
                                    'placeholder' => 'Начните вводить название ФИО или ID нужного пользователя',
                                )); ?>
                            </div>
                        </div>
                        <div class="widgetContent" style="min-height: 150px;">
                            <div id="orderItemsList" class="form-vertical row-border" data-id="<?php echo \Core\Route::param('id'); ?>" data-limit="16">
                                <p class="relatedMessage">Начните писать ФИО или ID пользователя в поле для ввода расположенном выше. После чего на этом месте появится список отфильтрованных записей</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo \Forms\Form::close(); ?>
