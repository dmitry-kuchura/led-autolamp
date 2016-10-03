<?php if (count($images)): ?>
    <?php foreach($images as $im): ?>
        <?php if (is_file(HOST.Core\HTML::media('images/gallery_images/small/'.$im->image))): ?>
            <div class="loadedBlock <?= $im->status == 1 ? 'chk' : ''; ?>" data-image="<?=$im->id; ?>">
                <div class="loadedImage">
                    <img src="<?php echo Core\HTML::media('images/gallery_images/small/'.$im->image); ?>" />
                </div>
                <div class="loadedControl">
                    <?php if(\Core\User::god() || \Core\User::get_access_for_controller('gallery') == 'edit'): ?>
                        <div class="loadedCtrl loadedCover">
                            <label>
                                <input id="def-img-<?=$im->id; ?>" type="checkbox" <?= $im->main == 1 ? 'checked="checked"' : ''; ?> name="default_image" value="<?=$im->id; ?>" />
                                <ins></ins>
                                <span class="btn btn-success" alt="На главной"><i class="fa-bookmark-empty"></i></span>
                                <div class="checkCover"></div>
                            </label>
                        </div>
                        <div class="loadedCtrl loadedCheck">
                            <label>
                                <input type="checkbox">
                                <ins></ins>
                                <span class="btn btn-info" alt="Отметить"><i class="fa-check-empty"></i></span>
                                <div class="checkInfo"></div>
                            </label>
                        </div>
                    <?php endif; ?>
                    <div class="loadedCtrl loadedView">
                        <button class="btn btn-primary btnImage" alt="Просмотр" href="<?php echo Core\HTML::media('images/gallery_images/big/'.$im->image); ?>"><i class="fa-zoom-in"></i></button>
                    </div>
                    <?php if(\Core\User::god() || \Core\User::get_access_for_controller('gallery') == 'edit'): ?>
                        <div class="loadedCtrl">
                            <button class="btn btn-warning" alt="Редактировать" href="<?php echo \Core\General::crop('gallery_images', 'small', $im->image, $_SERVER['HTTP_REFERER']); ?>"><i class="fa-pencil"></i></button>
                        </div>
                        <div class="loadedCtrl loadedDelete">
                            <button class="btn btn-danger" data-id="<?php echo $im->id; ?>" alt="Удалить"><i class="fa-remove"></i></button>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if(\Core\User::god() || \Core\User::get_access_for_controller('gallery') == 'edit'): ?>
                    <div class="loadedDrag"></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else: ?>
    <div class="alert alert-warning">Нет загруженных фото!</div>
<?php endif; ?>