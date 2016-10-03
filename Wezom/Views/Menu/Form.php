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
                            'name' => 'FORM[name]',
                            'value' => $obj->name,
                            'class' => 'valid',
                        ), 'Название'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo \Forms\Builder::input(array(
                            'id' => 'f_link',
                            'name' => 'FORM[url]',
                            'value' => $obj->url,
                            'class' => 'valid',
                        ), 'Ссылка'); ?>
                        <div class="thisLink"><span class="mainLink"><?php echo 'http://'.Core\Arr::get($_SERVER, 'HTTP_HOST'); ?></span><span class="samaLink"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo \Forms\Form::close(); ?>

<script type="text/javascript">
    function generate_link() {
        var link = $('#f_link').val();
        if(link != '') {
            if(link[0] != '/') {
                link = '/' + link;
            }
        }
        $('.samaLink').text(link);
    }
    $(document).ready(function(){
        generate_link();
        $('body').on('keyup', '#f_link', function(){ generate_link(); });
        $('body').on('change', '#f_link', function(){ generate_link(); });
    });
</script>