<div class="rowSection clearFix row-bg">
    <div class="col-sm-6 col-md-3">
        <div class="statbox widget box box-shadow">
            <div class="widgetContent">
                <div class="visual cyan">
                    <i class="fa-shopping-cart"></i>
                </div>
                <div class="title">
                    Заказы
                </div>
                <div class="value">
                    <?php echo $counts['orders']; ?>
                </div>
                <a href="/wezom/orders/index" class="more">Подробнее <i class="pull-right fa-angle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="statbox widget box box-shadow">
            <div class="widgetContent">
                <div class="visual green">
                    <i class="fa-comments-o"></i>
                </div>
                <div class="title">
                    Отзывы
                </div>
                <div class="value">
                    <?php echo $counts['reviews']; ?>
                </div>
                <a href="/wezom/reviews/index" class="more">Подробнее <i class="pull-right fa-angle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="statbox widget box box-shadow">
            <div class="widgetContent">
                <div class="visual yellow">
                    <i class="pull-right fa-fixed-width">&#xf11b;</i>
                </div>
                <div class="title">
                    Цоколи
                </div>
                <div class="value">
                    <?php echo $counts['cap']; ?>
                </div>
                <a href="/wezom/cap/index" class="more">Подробнее <i class="pull-right fa-angle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="statbox widget box box-shadow">
            <div class="widgetContent">
                <div class="visual black">
                    <i class="fa-shopping-cart"></i>
                </div>
                <div class="title">
                    Заказы скидок
                </div>
                <div class="value">
                    <?php echo $counts['discount']; ?>
                </div>
                <a href="/wezom/simple/index" class="more">Подробнее <i class="pull-right fa-angle-right"></i></a>
            </div>
        </div>
    </div>
</div>

<?php echo \Core\Widgets::get('Index_Visitors'); ?>

<?php echo \Core\Widgets::get('Index_Orders'); ?>

<div class="rowSection clearFix">
    <div class="col-md-6">
        <div class="widget">
            <?php echo \Core\Widgets::get('Index_Log'); ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="widget">
            <?php echo \Core\Widgets::get('Index_News'); ?>
        </div>
    </div>
</div>