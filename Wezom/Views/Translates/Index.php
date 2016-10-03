<div class="widget box">
    <div class="widgetContent">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
            <thead>
                <tr>
                    <th>Ключ</th>
                    <?php foreach( $languages AS $_key => $lang ): ?>
                        <th><?php echo $lang['name']; ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach( \Core\Arr::get($result, \I18n::$lang, array()) AS $key => $value ): ?>
                    <tr>
                        <td><?php echo $key; ?></td>
                        <?php foreach( $languages AS $_key => $lang ): ?>
                            <?php $public = \Core\Arr::get($result, $_key, array()); ?>
                            <td class="qe" data-lang="<?php echo $_key; ?>"><?php echo \Core\Arr::get($public, $key); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(function(){
        $('.table').dataTable();
    });
</script>