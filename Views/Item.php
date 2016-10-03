<!DOCTYPE html>
<html lang="ru-ru" dir="ltr">
<!-- (c) студия Wezom | www.wezom.com.ua -->
<head>  
    <?php echo Core\Widgets::get('Head', $_seo); ?>
    <?php foreach ( $_seo['scripts']['head'] as $script ): ?>
        <?php echo $script; ?>
    <?php endforeach ?>
    <?php echo $GLOBAL_MESSAGE; ?>
</head>
<body>
    <?php foreach ( $_seo['scripts']['body'] as $script ): ?>
        <?php echo $script; ?>
    <?php endforeach ?>
    <div class="wWrapper">
        <?php echo Core\Widgets::get('Header'); ?>
        <div class="wConteiner">
            <div class="wSize">
                <?php echo $_breadcrumbs; ?>
                <div class="item_block clearFix">
                    <?php echo $_content; ?>
                </div>
                <?php echo Core\Widgets::get('Item_ItemsSame'); ?>
            </div>
        </div>
    </div>
    <?php echo Core\Widgets::get('HiddenData'); ?>
    <?php echo Core\Widgets::get('Footer', array('counters' => Core\Arr::get($_seo, 'counters'), 'config' => $_config)); ?>
</body>
</html>