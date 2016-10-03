<div class="rowSection">
    <div class="col-md-12">
        <div class="widget">
            <div class="widget">
                <div class="widgetContent">
                    <table class="table table-striped table-hover checkbox-wrap ">
                        <thead>
                        <tr>
                            <th>Название страницы</th>
                            <th>Алиас</th>
                            <th class="nav-column textcenter">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ( $result as $obj ): ?>
                            <tr data-id="<?php echo $obj->id; ?>">
                                <td><a href="/wezom/<?php echo Core\Route::controller(); ?>/edit/<?php echo $obj->id; ?>"><?php echo $obj->name; ?></a></td>
                                <td><?php echo $obj->alias; ?></td>
                                <td class="nav-column">
                                    <ul class="table-controls">
                                        <li>
                                            <a class="bs-tooltip dropdownToggle" href="javascript:void(0);" title="Управление"><i class="fa-cog size14"></i></a>
                                            <ul class="dropdownMenu pull-right">
                                                <li>
                                                    <a href="/wezom/<?php echo Core\Route::controller(); ?>/edit/<?php echo $obj->id; ?>" title="Редактировать"><i class="fa-pencil"></i> Редактировать</a>
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
        </div>
    </div>
</div>
<span id="parameters" data-table="<?php echo $tablename; ?>"></span>