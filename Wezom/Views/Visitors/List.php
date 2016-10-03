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
                        <?php echo \Forms\Builder::input(array(
                            'name' => 'place',
                            'value' => Core\Arr::get($_GET, 'place', NULL),
                        ), 'Местоположение'); ?>
                    </div>
                    <div class="col-md-2">
                        <?php $options = array(
                            'last_enter-desc' => 'По дате последнего посещения Я -> А',
                            'last_enter-asc' => 'По дате последнего посещения А -> Я',
                            'first_enter-desc' => 'По дате первого посещения Я -> А',
                            'first_enter-asc' => 'По дате первого посещения А -> Я',
                            'enters-desc' => 'По количеству посещений А -> Я',
                            'enters-asc' => 'По количеству посещений Я -> А',
                        ); ?>
                        <?php echo \Forms\Builder::select($options,
                            Core\Arr::get($_GET, 'sort'), array(
                                'name' => 'sort',
                            ), 'Сортировать'); ?>
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
                                <th>Местоположение</th>
                                <th>Первое посещение</th>
                                <th>Последнее посещение</th>
                                <th>Всего посещений</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $result as $obj ): ?>
                                <?php $place = array(); ?>
                                <?php if ($obj->country): ?>
                                    <?php $place[] = $obj->country; ?>
                                <?php endif ?>
                                <?php if ($obj->region): ?>
                                    <?php $place[] = $obj->region; ?>
                                <?php endif ?>
                                <?php if ($obj->city): ?>
                                    <?php $place[] = $obj->city; ?>
                                <?php endif ?>
                                <tr data-id="<?php echo $obj->id; ?>">
                                    <td><a href="<?php echo '/wezom/referers/index?ip='.$obj->ip; ?>"><?php echo $obj->ip; ?></a></td>
                                    <td><span class="dashed" title="<?php echo implode(',', json_decode($obj->answer, TRUE)) ?>"><?php echo $place ? implode(', ', $place) : 'Не определено'; ?></span></td>
                                    <td><?php echo date('d.m.Y H:i:s', $obj->first_enter); ?></td>
                                    <td><?php echo date('d.m.Y H:i:s', $obj->last_enter); ?></td>
                                    <td><a href="<?php echo '/wezom/hits/index?ip='.$obj->ip; ?>"><?php echo $obj->enters; ?></a></td>
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