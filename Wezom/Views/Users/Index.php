<div class="rowSection">
    <div class="col-md-12">
        <div class="widget">
            <div class="widgetHeader" style="padding-bottom: 10px;">
                <?php echo \Forms\Form::open(array('class' => 'widgetContent filterForm', 'action' => '/wezom/'.Core\Route::controller().'/index')); ?>
                    <div class="col-md-2">
                        <?php echo \Forms\Builder::input(array(
                            'name' => 'name',
                            'value' => Core\Arr::get($_GET, 'name', NULL),
                        ), 'Имя'); ?>
                    </div>
                    <div class="col-md-2">
                        <?php echo \Forms\Builder::input(array(
                            'name' => 'email',
                            'value' => Core\Arr::get($_GET, 'email', NULL),
                        ), 'E-Mail'); ?>
                    </div>
                    <div class="col-md-2">
                        <?php echo \Forms\Builder::input(array(
                            'name' => 'phone',
                            'value' => Core\Arr::get($_GET, 'phone', NULL),
                        ), 'Номер телефона'); ?>
                    </div>
                    <div class="col-md-2">
                        <?php $options = array('' => 'Все', 0 => 'Неопубликованы', 1 => 'Опубликованы'); ?>
                        <?php echo \Forms\Builder::select($options, Core\Arr::get($_GET, 'status', 2), array(
                            'name' => 'status',
                        ), 'Статус'); ?>
                    </div>
                    <div class="col-md-2">
                        <?php $options = array(); ?>
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <?php $number = $i * Core\Config::get('static.limit_backend'); ?>
                            <?php $options[$number] = $number; ?>
                        <?php endfor; ?>
                        <?php echo \Forms\Builder::select($options, Core\Arr::get($_GET, 'limit', Core\Config::get('static.limit_backend')), array(
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
                                <a href="/wezom/<?php echo Core\Route::controller(); ?>/index">
                                    <i class="fa-refresh"></i>
                                    <span class="hidden-xx">Сбросить</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php echo \Forms\Form::close(); ?>
            </div>

            <div class="widget">
                <div class="widgetContent">
                    <table class="table table-striped table-hover checkbox-wrap ">
                        <thead>
                            <tr>
                                <th class="checkbox-head">
                                    <label><input type="checkbox"></label>
                                </th>
                                <th>Имя</th>
                                <th>E-Mail</th>
                                <th>Номер телефона</th>
                                <th>Дата регистрации</th>
                                <th>Статус</th>
                                <th class="nav-column textcenter">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $result as $obj ): ?>
                                <tr data-id="<?php echo $obj->id; ?>">
                                    <td class="checkbox-column">
                                        <label><input type="checkbox"></label>
                                    </td>
                                    <td>
                                        <a href="/wezom/<?php echo Core\Route::controller(); ?>/edit/<?php echo $obj->id; ?>">
                                            <?php echo $obj->name ? $obj->name : '---'; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if( $obj->email ): ?>
                                            <a href="mailto:<?php echo $obj->email; ?>" target="_blank"><?php echo $obj->email; ?></a>
                                        <?php else: ?>
                                            ----
                                        <?php endif ?>
                                    </td>
                                    <td><?php echo $obj->phone ? $obj->phone : '----'; ?></td>
                                    <td><?php echo $obj->created_at ? date( 'd.m.Y', $obj->created_at ) : '----'; ?></td>
                                    <td width="45" valign="top" class="icon-column status-column">
                                        <?php echo Core\View::widget(array( 'status' => $obj->status, 'id' => $obj->id ), 'StatusList'); ?>
                                    </td>
                                    <td class="nav-column">
                                        <ul class="table-controls">
                                            <li>
                                                <a class="bs-tooltip dropdownToggle" href="javascript:void(0);" title="Управление"><i class="fa-cog size14"></i></a>
                                                <ul class="dropdownMenu pull-right">
                                                    <li>
                                                        <a href="<?php echo \Core\HTML::link('wezom/orders/index?uid='.$obj->id); ?>" title="Посмотреть список заказов этого пользователя">Заказы</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo \Core\HTML::link('auth-like-regular-user/'.\Core\Encrypt::instance()->encode($obj->id)); ?>" title="Авторизоваться на сайте как этот пользователь" target="_blank">Авторизоваться</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="/wezom/<?php echo Core\Route::controller(); ?>/edit/<?php echo $obj->id; ?>" title="Редактировать"><i class="fa-pencil"></i> Редактировать</a>
                                                    </li>
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
                    <?php echo $pager; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<span id="parameters" data-table="<?php echo $tablename; ?>"></span>