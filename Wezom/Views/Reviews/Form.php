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
                    <?php if (is_file(HOST . Core\HTML::media('images/reviews/original/' . $obj->image))): ?>
                        <div class="contentImageView">
                            <a href="<?php echo Core\HTML::media('images/reviews/original/' . $obj->image); ?>" class="mfpImage">
                                <img src="<?php echo Core\HTML::media('images/reviews/small/' . $obj->image); ?>" />
                            </a>
                        </div>
                        <div class="contentImageControl">
                            <a class="btn btn-danger" href="/wezom/<?php echo Core\Route::controller(); ?>/delete_image/<?php echo $obj->id; ?>">
                                <i class="fa-remove"></i>
                                Удалить изображение
                            </a>
                            <br>
                            <a class="btn btn-warning" href="<?php echo \Core\General::crop('reviews', 'small', $obj->image); ?>">
                                <i class="fa-pencil"></i>
                                Редактировать
                            </a>
                        </div>
                    <?php else: ?>
                        <input type="file" name="file" />
                    <?php endif; ?>
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
                            'value' => $obj->text,
                            'class' => 'valid',
                        ), 'Отзыв'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo \Forms\Form::close(); ?>