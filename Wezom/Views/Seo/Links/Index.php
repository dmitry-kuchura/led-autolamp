<div class="widgetHeader" style="padding-bottom: 10px;">
    <?php echo \Forms\Form::open(array('class' => 'widgetContent filterForm', 'action' => '/wezom/seo_links/index')); ?>
        <div class="col-md-2">
            <?php echo \Forms\Builder::input(array(
                'name' => 'name',
                'value' => Core\Arr::get($_GET, 'name', NULL),
            ), 'Название'); ?>
        </div>
        <div class="col-md-2">
            <?php echo \Forms\Builder::input(array(
                'name' => 'link',
                'value' => Core\Arr::get($_GET, 'link', NULL),
            ), 'URL'); ?>
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
        <div class="col-md-1">
            <label class="control-label" style="height:22px;"></label>
            <div class="">
                <div class="controls">
                    <a href="/wezom/seo_links/index">
                        <i class="fa-refresh"></i>
                        <span class="hidden-xx">Сбросить</span>
                    </a>
                </div>
            </div>
        </div>
    <?php echo \Forms\Form::close(); ?>
</div>
<div class="dd pageList">
    <ol class="dd-list">
        <?php foreach ($result as $obj): ?>
            <li class="dd-item dd3-item" data-id="<?php echo $obj->id; ?>">
                <div class="dd3-content" style="padding-left: 0;">
                    <table>
                        <tr>
                            <td width="1%" class="checkbox-column">
                                <label><input type="checkbox" /></label>
                            </td>
                            <td valign="middle" class="pagename-column">
                                <div class="clearFix">
                                    <div class="pull-left">
                                        <div class="pull-left">
                                            <div><a class="pageLinkEdit" href="<?php echo '/wezom/seo_links/edit/'.$obj->id; ?>"><?php echo $obj->name; ?></a></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="hidden-xs" valign="middle">
                                <div><a href="<?php echo $obj->link; ?>" target="_blank"><?php echo $obj->link; ?></a></div>
                            </td>
                            <td width="45" valign="top" class="icon-column status-column">
                                <?php echo Core\View::widget(array( 'status' => $obj->status, 'id' => $obj->id ), 'StatusList'); ?>
                            </td> 
                            <td class="nav-column icon-column" valign="top">
                                <ul class="table-controls">
                                    <li>
                                        <a title="Управление ссылкой" href="javascript:void(0);" class="bs-tooltip dropdownToggle"><i class="fa-cog"></i> </a>
                                        <ul class="dropdownMenu pull-right">
                                            <li>
                                                <a title="Редактировать" href="<?php echo '/wezom/seo_links/edit/'.$obj->id; ?>"><i class="fa-pencil"></i> Редактировать ссылку</a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <a title="Удалить" onclick="return confirm('Это действие необратимо. Продолжить?');" href="<?php echo '/wezom/seo_links/delete/'.$obj->id; ?>"><i class="fa-trash-o text-danger"></i> Удалить ссылку</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
            </li>
        <?php endforeach; ?>
    </ol>
    <?php echo $pager; ?>
</div>
<span id="parameters" data-table="<?php echo $tablename; ?>"></span>