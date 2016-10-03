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
	<div class="wWrapper basket_page">
		<?php echo Core\Widgets::get('HeaderCart'); ?>
		<div class="wConteiner">
			<div class="wSize" id="cartContentPart">
				<?php echo $_content; ?>
			</div>
		</div>
	</div>
	<?php echo Core\Widgets::get('HiddenData'); ?>
    <?php echo Core\Widgets::get('Footer', array('counters' => Core\Arr::get($_seo, 'counters'), 'config' => $_config)); ?>
</body>
</html>