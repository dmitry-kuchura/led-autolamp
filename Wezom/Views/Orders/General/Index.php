<div class="rowSection">
    <div class="col-md-12">
        <div class="widget">
            <div class="widgetHeader" style="padding-bottom: 10px;">
                <?php echo \Forms\Form::open(array('class' => 'widgetContent filterForm', 'action' => '/wezom/'.Core\Route::controller().'/index')); ?>
                    <?php \Forms\Builder::hidden(array(
                        'name' => 'uid',
                        'value' => \Core\Arr::get($_GET, 'uid'),
                    )); ?>
                    <div class="col-md-2">
                        <?php echo \Forms\Builder::input(array(
                            'name' => 'date_s',
                            'value' => Core\Arr::get($_GET, 'date_s', NULL),
                            'class' => 'fPicker',
                        ), 'Дата от'); ?>
                    </div>
                    <div class="col-md-2">
                        <?php echo \Forms\Builder::input(array(
                            'name' => 'date_po',
                            'value' => Core\Arr::get($_GET, 'date_po', NULL),
                            'class' => 'fPicker',
                        ), 'Дата до'); ?>
                    </div>
                    <div class="col-md-2">
                        <?php echo \Forms\Builder::select($statuses, Core\Arr::get($_GET, 'status', 2), array(
                            'name' => 'status',
                        ), 'Статус'); ?>
                    </div>
                    <div class="col-md-2">
                        <?php $options = array(); ?>
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <?php $number = $i * Core\Config::get('basic.limit_backend'); ?>
                            <?php $options[$number] = $number; ?>
                        <?php endfor; ?>
                        <?php echo \Forms\Builder::select($options, Core\Arr::get($_GET, 'limit', Core\Config::get('basic.limit_backend')), array(
                            'name' => 'limit',
                        ), 'Выводить по'); ?>
                    </div>
                    <div class="col-md-1">
                        <label class="control-label" style="height:16px;">&nbsp</label>
                        <?php echo \Forms\Form::submit(array(
                            'class' => 'btn btn-primary',
                            'value' => 'Подобрать',
                        )); ?>
                    </div>
                    <div class="col-md-1 stable105">
                        <label class="control-label" style="height:22px;"></label>
                        <div class="">
                            <div class="controls">
                                <a href="<?php echo \Core\Arr::get($_GET, 'uid') ? \Core\HTML::link('wezom/'.Core\Route::controller().'/index?uid='.\Core\Arr::get($_GET, 'uid')) : \Core\HTML::link('wezom/'.Core\Route::controller().'/index'); ?>">
                                    <i class="fa-refresh"></i>
                                    <span class="hidden-xx">Сбросить</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php echo \Forms\Form::close(); ?>
            </div>

            <div class="widgetHeader staticInfo">
                <p>Количество заказов: <i><?php echo $count; ?></i></p>
                <p>На сумму: <i><?php echo (int) $amount; ?></i> грн</p>
            </div>

            <div class="widgetContent">
                <div class="checkbox-wrap">
                    <table class="table table-striped table-bordered orderList" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="hidden-ss">Номер заказа</th>
                                <th>Имя</th>
                                <th>Телефон</th>
                                <th>Заказчик</th>
                                <th>Количество</th>
                                <th>Сумма</th>
                                <th>Дата</th>
                                <th>Статус</th>
                                <th></th>
                            </tr>
                        </thead>
                     
                        <tbody>
                            <?php foreach ( $result as $obj ): ?>
                                <tr data-id="<?php echo $obj->id; ?>">
                                    <td class="hidden-ss"><a href="/wezom/<?php echo Core\Route::controller(); ?>/edit/<?php echo $obj->id; ?>">#<?php echo $obj->id; ?></a></td>
                                    <td><?php echo $obj->name; ?></td>
                                    <td><a href="tel:<?php echo $obj->phone; ?>"><?php echo $obj->phone; ?></a></td>
                                    <td>
                                        <?php if($obj->user_id): ?>
                                            <?php $user = \Core\Common::factory('users')->getRow($obj->user_id); ?>
                                            <?php if($user): ?>
                                                <a href="<?php echo \Core\HTML::link('wezom/users/edit/'.$user->id); ?>" target="_blank"><?php echo $user->last_name.' '.$user->name; ?></a>
                                            <?php else: ?>
                                                <span style="font-style: italic; color: #ccc;">( Удален )</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span style="font-style: italic; color: #ccc;">( Администратор )</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo (int) $obj->count; ?> товаров</td>
                                    <td class="sum-column"><?php echo (int) $obj->amount; ?> грн</td>
                                    <td><?php echo date( 'd.m.Y H:i', $obj->created_at ); ?></td>
                                    <td>
                                        <?php if( $obj->status == 3 ): ?>
                                            <?php $class = 'danger'; ?>
                                        <?php endif; ?>
                                        <?php if( $obj->status == 2 ): ?>
                                            <?php $class = 'info'; ?>
                                        <?php endif; ?>
                                        <?php if( $obj->status == 1 ): ?>
                                            <?php $class = 'success'; ?>
                                        <?php endif; ?>
                                        <?php if( $obj->status == 0 ): ?>
                                            <?php $class = 'default'; ?>
                                        <?php endif; ?>
                                        <span title="<?php echo $statuses[$obj->status]; ?>" class="label label-<?php echo $class; ?> orderLabelStatus bs-tooltip">
                                            <span class="hidden-ss"><?php echo $statuses[$obj->status]; ?></span>
                                        </span>
                                    </td>
                                    <td>
                                        <ul class="table-controls">
                                            <li>
                                                <a class="bs-tooltip dropdownToggle" href="javascript:void(0);" title="Управление"><i class="fa-cog size14"></i></a>
                                                <ul class="dropdownMenu pull-right">
                                                    <li>
                                                        <a href="/wezom/<?php echo Core\Route::controller(); ?>/edit/<?php echo $obj->id; ?>" title="Редактировать"><i class="fa-pencil"></i> Редактировать</a>
                                                    </li>
                                                    <li>
                                                        <a href="/wezom/<?php echo Core\Route::controller(); ?>/print/<?php echo $obj->id; ?>" target="_blank" title="Распечатать"><i class="fa-print"></i> Распечатать</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a onclick="return confirm('Это действие необратимо. Продолжить?');" href="/wezom/<?php echo Core\Route::controller(); ?>/delete/<?php echo $obj->id; ?>" title="Удалить"><i class="fa-trash-o text-danger"></i> Удалить</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php echo $pager; ?>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('.orderLabelStatus').on('click', function(e){
            var it = $(this);
            var id = it.closest('tr').attr('data-id');
            var status = it.attr('data-status');
            var sess = it.attr('data-session');
            $.ajax({
                url: '/wezom/ajax/changeStatusOrder.php',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    id: id,
                    sess: sess,
                    status: status
                },
                success: function(data) {
                    if( data.success ) {
                        it.attr( 'data-status', data.st.id );
                        it.attr( 'title', data.st.name );
                        var cl = it.attr( 'data-class' );
                        it.attr( 'data-class', data.st.class );
                        it.removeClass( cl );
                        it.addClass( data.st.class );
                        it.find('span').html( data.st.name );
                    }
                }
            });
        });

        $('.ranges > ul > li.active').removeClass('active');
    });
</script>