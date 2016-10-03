<div class="reviews js-reviews">
    <div class="wSize">
        <div class="reviews_title">Что говорят<br>автовладельцы?</div>
        <div class="reviews_slider_block">
            <div class="reviews_slider">
                <ul>
                    <?php foreach ($result as $obj): ?>
                        <li>
                            <div class="review_photo">
                                <?php if (is_file(HOST . Core\HTML::media('images/reviews/original/' . $obj->image))) {
                                    $image = Core\HTML::media('images/reviews/original/' . $obj->image);
                                } else {
                                    $image = Core\HTML::media('pic/no-avatar.png');
                                } ?>
                                <img src="<?php echo $image; ?>" alt="">
                            </div>
                            <div class="review_name"><?php echo $obj->name; ?></div>
                            <div class="review_text"><?php echo $obj->text; ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="pagg"></div>
            </div>
        </div>
    </div>
</div>