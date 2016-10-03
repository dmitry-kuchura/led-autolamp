<?php echo \Forms\Builder::open(); ?>
    <div class="form-actions" style="display: none;">
        <?php echo \Forms\Form::submit(array('name' => 'name', 'value' => 'Отправить', 'class' => 'submit btn btn-primary pull-right')); ?>
    </div>
    <div class="col-md-12">
        <div class="widget">
            <div class="widgetContent">
                <div class="form-vertical row-border">
                    <div class="form-group">
                        <?php echo \Forms\Builder::bool($obj->status); ?>
                    </div>
                    <div class="form-group">
                        <?php echo \Forms\Builder::input(array(
                            'name' => 'FORM[link_from]',
                            'value' => str_replace('http://'.Core\Arr::get($_SERVER, 'HTTP_HOST').'/', '', $obj->link_from),
                            'class' => 'link',
                        ), 'Ссылка с'); ?>
                        <div class="thisLink"><span class="mainLink"><?php echo 'http://'.Core\Arr::get($_SERVER, 'HTTP_HOST'); ?></span><span class="samaLink"></span></div>
                    </div>
                    <div class="form-group">
                        <?php echo \Forms\Builder::input(array(
                            'name' => 'FORM[link_to]',
                            'value' => str_replace('http://'.Core\Arr::get($_SERVER, 'HTTP_HOST').'/', '', $obj->link_to),
                            'class' => 'link',
                        ), 'Ссылка на'); ?>
                        <div class="thisLink"><span class="mainLink"><?php echo 'http://'.Core\Arr::get($_SERVER, 'HTTP_HOST'); ?></span><span class="samaLink"></span></div>
                    </div>
                    <div class="form-group">
                        <?php $options = array(); ?>
                        <?php for($i = 300; $i <= 305; $i++): ?>
                            <?php $options[$i] = $i; ?>
                        <?php endfor; ?>
                        <?php $options[307] = 307; ?>
                        <?php echo \Forms\Builder::select($options, $obj->type, array(
                                'name' => 'FORM[type]',
                            ), 'Тип'); ?>
                    </div>
                    <div class="widgetContent" style="min-height: 150px;">
                        <div class="relatedMessage form-vertical row-border">
                            <p>Список перенаправлений</p>
                            <ul>
                                <li>300 — Multiple Choices («множество выборов»)</li>
                                <li>301 — Moved Permanently («перемещено навсегда»)</li>
                                <li>302 — Moved Temporarily («перемещено временно»)</li>
                                <li>303 — See Other (смотреть другое)</li>
                                <li>304 — Not Modified (не изменялось)</li>
                                <li>305 — Use Proxy («использовать прокси»)</li>
                                <li>307 — Temporary Redirect («временное перенаправление»)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo \Forms\Form::close(); ?>

<script type="text/javascript">
    function generate_link(it) {
        var link = it.val();
        if(link != '') {
            if(link[0] != '/') {
                link = '/' + link;
            }
        }
        it.parent().find('.samaLink').text(link);
    }
    $(document).ready(function(){
        $('input.link').each(function(){
            generate_link($(this));
        });
        $('body').on('keyup', '.link', function(){ generate_link($(this)); });
        $('body').on('change', '.link', function(){ generate_link($(this)); });
    });
</script>