<!DOCTYPE html>
<html lang="ru-RU" dir="ltr" class="no-js">
<head>
    <?php echo Core\Widgets::get('Head', $_seo); ?>
    <?php foreach ($_seo['scripts']['head'] as $script): ?>
        <?php echo $script; ?>
    <?php endforeach ?>
    <?php echo $GLOBAL_MESSAGE; ?>
</head>
<body class="indexPage">
    <?php foreach ($_seo['scripts']['body'] as $script): ?>
        <?php echo $script; ?>
    <?php endforeach ?>
<div class="wWrapper">
    <?php echo Core\Widgets::get('Header'); ?>
    <div class="wHeaderFix">
        <div class="menu w_ovh">
            <span data-anchor="advantages" class="js-anchor">Преимущества</span>
            <span data-anchor="compare" class="js-anchor">Сравнение</span>
            <span data-anchor="reviews" class="js-anchor">Отзывы</span>
            <span data-anchor="buy" class="js-anchor">Покупайте у нас</span>
        </div>
    </div>
    <!-- .wHeader -->
    <div class="wContainer">
        <?php echo Core\Widgets::get('Main_Top'); ?>
        <?php echo Core\Widgets::get('Main_Advantages'); ?>
        <?php echo Core\Widgets::get('Main_Compare'); ?>
        <?php echo Core\Widgets::get('Main_Reviews'); ?>
        <?php echo Core\Widgets::get('Main_Buy'); ?>
        <!-- .wContainer -->
    </div>
</div>
<?php echo Core\Widgets::get('Footer'); ?>
<!-- .wFooter -->
<?php echo Core\Widgets::get('HiddenData'); ?>
</body>
</html>