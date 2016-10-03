<?php echo \Forms\Builder::open(); ?>
<div class="form-actions" style="display: none;">
    <?php echo \Forms\Form::submit(array('name' => 'name', 'value' => 'Отправить', 'class' => 'submit btn btn-primary pull-right')); ?>
</div>
<?php if (count(\Core\Arr::get($groups, 'left', array()))): ?>
    <div class="col-md-<?php echo count(\Core\Arr::get($groups, 'right', array())) ? 7 : 12; ?>">
        <div class="widget">
            <div class="widgetContent">
                <div class="form-vertical row-border">
                    <ul class="liTabs t_wrap">
                        <?php foreach ($groups['left'] AS $group): ?>
                            <?php if (\Core\Arr::get($result, $group->alias)): ?>
                                <li class="t_item">
                                    <a class="t_link" href="#"><?php echo $group->name; ?></a>
                                    <div class="t_content <?php echo $group->alias ?>Content">
                                        <?php foreach ($result[$group->alias] as $obj): ?>
                                            <?php echo \Core\View::tpl(array('obj' => $obj), 'Config/Row'); ?>
                                        <?php endforeach; ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if (count(\Core\Arr::get($groups, 'right', array()))): ?>
    <div class="col-md-<?php echo count(\Core\Arr::get($groups, 'left', array())) ? 5 : 12; ?>">
        <div class="widget">
            <div class="widgetContent">
                <div class="form-vertical row-border">
                    <ul class="liTabs t_wrap">
                        <?php foreach ($groups['right'] AS $group): ?>
                            <?php if (\Core\Arr::get($result, $group->alias)): ?>
                                <li class="t_item">
                                    <a class="t_link" href="#"><?php echo $group->name; ?></a>
                                    <div class="t_content <?php echo $group->alias ?>Content">
                                        <?php foreach ($result[$group->alias] as $obj): ?>
                                            <?php echo \Core\View::tpl(array('obj' => $obj), 'Config/Row'); ?>
                                        <?php endforeach; ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <li class="t_item">
                            <a class="t_link" href="#">Тестовое письмо</a>
                            <div class="t_content">
                                <div class="sendTestEmail" style="padding-top: 0;" data-ajax="config/testEmail">
                                    <div class="red hide mailNotice">Пожалуйста, сохраните настройки почты перед
                                        отправкой тестового письма
                                    </div>
                                    <div class="form-group">
                                        <?php echo \Forms\Builder::input(array(
                                            'name' => 'title'
                                        ), 'Заголовок письма'); ?>
                                    </div>
                                    <div class="form-group">
                                        <?php echo \Forms\Builder::input(array(
                                            'name' => 'body'
                                        ), 'Тело письма'); ?>
                                    </div>
                                    <div class="form-group">
                                        <?php echo \Forms\Builder::input(array(
                                            'name' => 'email'
                                        ), 'E-mail получателя'); ?>
                                    </div>
                                    <div class="textright">
                                        <?php echo \Forms\Form::button('Отправить', array('type' => 'button', 'class' => 'btn btn-primary')); ?>
                                    </div>
                                </div>

                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php echo \Forms\Form::close(); ?>

<script>
    $(function () {
        var input;
        $('input[type="password"]').closest('div').addClass('input-group');
        $('.showPassword').on('click', function () {
            input = $(this).closest('div.input-group').find('input');
            if (input.attr('type') == 'password') {
                input.attr('type', 'text');
                $(this).text('Скрыть');
            } else {
                input.attr('type', 'password');
                $(this).text('Показать');
            }
        });

        $(function () {
            var pickerInit = function (selector) {
                $(selector).each(function (index, el) {
                    var date = $(el).val();
                    $(el).datepicker({
                        showOtherMonths: true,
                        selectOtherMonths: false
                    });
                    $(el).datepicker('option', $.datepicker.regional['ru']);
                    var dateFormat = $(el).datepicker("option", "dateFormat");
                    $(el).datepicker("option", "dateFormat", 'dd.mm.yy');
                    $(el).val(date);
                })
            };
            pickerInit('.myPicker');
        });

        $('.sendTestEmail button').on('click', function () {
            preloader();
            var it = $(this);
            var form = it.closest('.sendTestEmail');
            var action = form.data('ajax');
            if (action) {
                $.ajax({
                    url: '/wezom/ajax/' + action,
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        title: form.find('input[name=title]').val(),
                        body: form.find('input[name=body]').val(),
                        email: form.find('input[name=email]').val(),
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.success) {
                            if (data.response) {
                                generate(data.response, 'success');
                            }
                            if (data.reload) {
                                window.location.reload();
                            } else {
                                preloader();
                            }
                        } else {
                            if (data.response) {
                                generate(data.response, 'warning');
                            }
                            preloader();
                        }
                    }
                });
            }
        });

        $('.mailContent').on('change', 'input', function () {
            $('.mailNotice').show();
        });
    });
</script>