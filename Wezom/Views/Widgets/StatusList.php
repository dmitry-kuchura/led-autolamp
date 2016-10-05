<?php if( \Core\User::caccess() != 'edit' ): ?>
    <?php if ($status == 1): ?>
        <i class="fa-check green"></i>
    <?php else: ?>
        <i class="fa-dot-circle-o red"></i>
    <?php endif ?>
<?php endif; ?>
<?php if( \Core\User::caccess() == 'edit' ): ?>
    <a
        data-pub="<b>Отметить не просмотренным</b><br>Просмотренно"
        data-unpub="<b>Просмотренно</b><br>Не просмотренно"
        title="<?php echo $status == 1 ? '<b>Пометить как не просмотренно</b><br>Просмотренно' : '<b>Отметить просмотренным</b><br>Не просмотренно'; ?>"
        data-status="<?php echo $status; ?>"
        data-id="<?php echo $id; ?>"
        href="#"
        class="setStatus bs-tooltip btn btn-xs <?php echo $status == 1 ? 'btn-success' : 'btn-danger' ?>"
        >
        <?php if ($status == 1): ?>
            <i class="fa-check"></i>
        <?php else: ?>
            <i class="fa-dot-circle-o"></i>
        <?php endif ?>
    </a>
<?php endif; ?>