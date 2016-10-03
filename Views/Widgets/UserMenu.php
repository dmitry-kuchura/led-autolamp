<div class="lk_menu">
    <div class="menuElement <?php echo Core\Route::action() == 'index' ? 'current' : ''; ?>">
        <a href="<?php echo Core\HTML::link('account'); ?>">Личный кабинет</a>
    </div>
    <div class="menuElement <?php echo Core\Route::action() == 'orders' ? 'current' : ''; ?>">
        <a href="<?php echo Core\HTML::link('account/orders'); ?>">Мои заказы</a>
    </div>
    <div class="menuElement <?php echo Core\Route::action() == 'profile' ? 'current' : ''; ?>">
        <a href="<?php echo Core\HTML::link('account/profile'); ?>">Мои данные</a>
    </div>
    <div class="menuElement <?php echo Core\Route::action() == 'change_password' ? 'current' : ''; ?>">
        <a href="<?php echo Core\HTML::link('account/change_password'); ?>">Изменить пароль</a>
    </div>
</div>