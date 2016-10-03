<?php echo \Forms\Builder::open(); ?>
    <div class="form-actions" style="display: none;">
        <?php echo \Forms\Form::submit(array('name' => 'name', 'value' => 'Отправить', 'class' => 'submit btn btn-primary pull-right')); ?>
    </div>
    <div class="col-md-12">
        <div class="widget box">
            <div class="widgetHeader">
                <div class="widgetTitle">
                    <i class="fa-reorder"></i>
                    Основные данные
                </div>
            </div>
            <div class="widgetContent">
                <div class="form-vertical row-border">
                    <div class="form-group">
                        <?php echo \Forms\Builder::bool($obj->status); ?>
                    </div>
                    <div class="form-group">
                        <?php echo \Forms\Builder::input(array(
                            'name' => 'FORM[name]',
                            'value' => $obj->name,
                        ), 'Название'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo \Forms\Builder::input(array(
                            'name' => 'FORM[url]',
                            'value' => $obj->url,
                        ), 'Ссылка'); ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label"></label>
                        <div>
                            <?php if (is_file( HOST . Core\HTML::media('images/slider/big/'.$obj->image) )): ?>
                                <div class="contentImageView">
                                    <a href="<?php echo Core\HTML::media('images/slider/big/'.$obj->image); ?>" class="mfpImage">
                                        <img src="<?php echo Core\HTML::media('images/slider/small/'.$obj->image); ?>" />
                                    </a>
                                </div>
                                <div class="contentImageControl">
                                    <a class="btn btn-danger otherBtn" href="/wezom/<?php echo Core\Route::controller(); ?>/delete_image/<?php echo $obj->id; ?>">
                                        <i class="fa-remove"></i>
                                        Удалить изображение
                                    </a> 
                                    <br>                                   
                                    <a class="btn btn-warning otherBtn" href="<?php echo \Core\General::crop('slider', 'small', $obj->image); ?>">
                                        <i class="fa-pencil"></i>
                                        Редактировать
                                    </a>
                                </div>
                            <?php else: ?>
                                <?php echo \Forms\Builder::file(array('name' => 'file')); ?>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo \Forms\Form::close(); ?>