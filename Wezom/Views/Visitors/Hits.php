<div class="rowSection">
    <div class="col-md-12">
        <div class="widget">
            <div class="widgetHeader" style="padding-bottom: 10px;">
                <?php echo \Forms\Form::open(array('class' => 'widgetContent filterForm', 'action' => '/wezom/'.Core\Route::controller().'/index')); ?>
                    <div class="col-md-2">
                        <?php echo \Forms\Builder::input(array(
                            'name' => 'ip',
                            'value' => Core\Arr::get($_GET, 'ip', NULL),
                        ), 'IP'); ?>
                    </div>
                    <div class="col-md-2">
                        <?php echo \Forms\Builder::select(\Core\Support::selectData($answers, 'status', 'status', array('', 'Все')),
                            Core\Arr::get($_GET, 'status'), array(
                                'name' => 'status',
                            ), 'Ответ сервера'); ?>
                    </div>
                    <div class="col-md-2">
                        <?php echo \Forms\Builder::select(\Core\Support::selectData($devices, 'device', 'device', array('', 'Все')),
                            Core\Arr::get($_GET, 'device'), array(
                                'name' => 'device',
                            ), 'Устройство'); ?>
                    </div>
                    <div class="col-md-2">
                        <?php $options = array(
                            'updated_at-desc' => 'По дате последнего обновления Я -> А',
                            'updated_at-asc' => 'По дате последнего обновления А -> Я',
                            'created_at-desc' => 'По дате первого посещения Я -> А',
                            'created_at-asc' => 'По дате первого посещения А -> Я',
                        ); ?>
                        <?php echo \Forms\Builder::select($options,
                            Core\Arr::get($_GET, 'sort'), array(
                                'name' => 'sort',
                            ), 'Сортировать'); ?>
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
                    <div class="col-md-1">
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
                    <table class="table table-striped table-hover checkbox-wrap">
                        <thead>
                            <tr>
                                <th>IP</th>
                                <th>URL</th>
                                <th>Ответ сервера</th>
                                <th>Устройство</th>
                                <th>Дата посещения</th>
                                <th>Дата последнего обновления страницы</th>
                                <th>Всего обновлений страницы</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $result as $obj ): ?>
                                <tr data-id="<?php echo $obj->id; ?>">
                                    <td><a href="<?php echo '/wezom/visitors/index?ip='.$obj->ip; ?>"><?php echo $obj->ip; ?></a></td>
                                    <td><a href="<?php echo $obj->url; ?>" target="_blank"><?php echo $obj->url; ?></a></td>
                                    <td><?php echo $obj->status; ?></td>
                                    <td><span class="dashed" title="<?php echo $obj->useragent; ?>"><?php echo $obj->device; ?></span></td>
                                    <td><?php echo date('d.m.Y H:i:s', $obj->created_at); ?></td>
                                    <td><?php echo date('d.m.Y H:i:s', $obj->updated_at); ?></td>
                                    <td><?php echo $obj->counter; ?></td>
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