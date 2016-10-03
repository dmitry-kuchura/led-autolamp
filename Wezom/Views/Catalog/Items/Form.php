<?php echo \Forms\Builder::open(); ?>
    <div class="form-actions" style="display: none;">
        <?php echo \Forms\Form::submit(array('name' => 'name', 'value' => 'Отправить', 'class' => 'submit btn btn-primary pull-right')); ?>
    </div>
    <div class="col-md-6">
        <div class="widget box">
            <div class="widgetContent">
                <div class="form-vertical row-border">
                    <ul class="liTabs t_wrap">
                        <li class="t_item">
                            <a class="t_link" href="#">Основные данные</a>
                            <div class="t_content">
                                <div class="form-group">
                                    <div class="rowSection">
                                        <div class="col-md-4">
                                            <?php echo \Forms\Builder::bool($obj->status); ?>
                                        </div>
                                        <div class="col-md-4">
                                            <?php echo \Forms\Builder::bool($obj->new, 'new', 'Новинка'); ?>
                                        </div>
                                        <div class="col-md-4">
                                            <?php echo \Forms\Builder::bool($obj->top, 'top', 'Популярный товар'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="rowSection">
                                        <div class="col-md-6 form-group">
                                            <?php echo \Forms\Builder::select('<option value="0">Не выбрано</option>'.$tree,
                                                NULL, array(
                                                    'id' => 'parent_id',
                                                    'name' => 'FORM[parent_id]',
                                                    'class' => 'valid',
                                                ), array(
                                                    'text' => 'Группа',
                                                    'tooltip' => '<b>При изменении группы товара меняется набор характеристик!</b>',
                                                )); ?>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <?php echo \Forms\Builder::input(array(
                                                'name' => 'FORM[sort]',
                                                'value' => $obj->sort,
                                            ), array(
                                                'name' => 'Позиция',
                                                'tooltip' => '<b>Поле определяет позицию товара среди других в списках</b>',
                                            )); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <?php echo \Forms\Builder::input(array(
                                        'name' => 'FORM[artikul]',
                                        'value' => $obj->artikul,
                                    ), 'Артикул'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo \Forms\Builder::input(array(
                                        'name' => 'FORM[name]',
                                        'value' => $obj->name,
                                        'class' => array('valid', 'translitSource'),
                                    ), 'Название'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo \Forms\Builder::alias(array(
                                        'name' => 'FORM[alias]',
                                        'value' => $obj->alias,
                                        'class' => 'valid',
                                    ), array(
                                        'text' => 'Алиас',
                                        'tooltip' => '<b>Алиас (англ. alias - псевдоним)</b><br>Алиасы используются для короткого именования страниц. <br>Предположим, имеется страница с псевдонимом «<b>about</b>». Тогда для вывода этой страницы можно использовать или полную форму: <br><b>http://domain/?go=frontend&page=about</b><br>или сокращенную: <br><b>http://domain/about.html</b>',
                                    )); ?>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <?php echo \Forms\Builder::bool($obj->sale, 'sale', 'Акция'); ?>
                                    </div>
                                    <div class="col-md-9">
                                        <label class="control-label">Наличие</label>
                                        <div class="">
                                            <label class="checkerWrap-inline">
                                                <?php echo \Forms\Builder::radio(($obj && $obj->available == 0) ? true : false, array(
                                                    'name' => 'available',
                                                    'value' => 0,
                                                )); ?>
                                                Нет в наличии
                                            </label>
                                            <label class="checkerWrap-inline">
                                                <?php echo \Forms\Builder::radio((!$obj || $obj->available == 1) ? true : false, array(
                                                    'name' => 'available',
                                                    'value' => 1,
                                                )); ?>
                                                Есть в наличии
                                            </label>
                                            <label class="checkerWrap-inline">
                                                <?php echo \Forms\Builder::radio(($obj && $obj->available == 2) ? true : false, array(
                                                    'name' => 'available',
                                                    'value' => 2,
                                                )); ?>
                                                Под заказ
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group costField">
                                    <?php echo \Forms\Builder::input(array(
                                        'type' => 'tel',
                                        'name' => 'FORM[cost]',
                                        'value' => $obj->cost,
                                        'class' => 'valid',
                                    ), 'Цена'); ?>
                                </div>
                                <div class="form-group hiddenCostField" <?php echo !$obj->sale ? 'style="display:none;"' : ''; ?>>
                                    <?php echo \Forms\Builder::input(array(
                                        'type' => 'tel',
                                        'name' => 'FORM[cost_old]',
                                        'value' => $obj->cost_old,
                                    ), 'Старая цена'); ?>
                                </div>
                            </div>
                        </li>
                        <li class="t_item">
                            <a class="t_link" href="#">Мета-данные</a>
                            <div class="t_content">
                                <div style="font-weight: bold; margin-bottom: 10px;"><span class="red">Внимание!</span> Незаполненные данные будут подставлены по <a href="<?php echo \Core\HTML::link('wezom/seo_templates/edit/2'); ?>" target="_blank">шаблону</a></div>
                                <div class="form-group">
                                    <?php echo \Forms\Builder::input(array(
                                        'name' => 'FORM[h1]',
                                        'value' => $obj->h1,
                                    ), array(
                                        'text' => 'H1',
                                        'tooltip' => 'Рекомендуется, чтобы тег h1 содержал ключевую фразу, которая частично или полностью совпадает с title',
                                    )); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo \Forms\Builder::input(array(
                                        'name' => 'FORM[title]',
                                        'value' => $obj->title,
                                    ), array(
                                        'text' => 'Title',
                                        'tooltip' => '<p>Значимая для продвижения часть заголовка должна быть не более 12 слов</p><p>Самые популярные ключевые слова должны идти в самом начале заголовка и уместиться в первых 50 символов, чтобы сохранить привлекательный вид в поисковой выдаче.</p><p>Старайтесь не использовать в заголовке следующие знаки препинания – . ! ? – </p>',
                                    )); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo \Forms\Builder::textarea(array(
                                        'name' => 'FORM[keywords]',
                                        'rows' => 5,
                                        'value' => $obj->keywords,
                                    ), array(
                                        'text' => 'Keywords',
                                    )); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo \Forms\Builder::textarea(array(
                                        'name' => 'FORM[description]',
                                        'value' => $obj->description,
                                        'rows' => 5,
                                    ), array(
                                        'text' => 'Description',
                                    )); ?>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="widget box">
            <div class="widgetHeader">
                <div class="widgetTitle">
                    <i class="fa-list-alt"></i>
                    Характеристики
                </div>
            </div>
            <div class="widgetContent">
                <div class="form-group">
                    <?php echo \Forms\Builder::select(\Core\Support::selectData($brands, 'alias', 'name', array(0, 'Нет')),
                        $obj->brand_alias, array(
                            'id' => 'brand_alias',
                            'name' => 'FORM[brand_alias]',
                        ), 'Бренд'); ?>
                </div>
                <div class="form-group">
                    <?php echo \Forms\Builder::select(\Core\Support::selectData($models, 'alias', 'name', array(0, 'Нет')),
                        $obj->model_alias, array(
                            'id' => 'model_alias',
                            'name' => 'FORM[model_alias]',
                        ), 'Модель'); ?>
                </div>
                <div class="form-vertical row-border" id="specGroup">
                    <?php foreach ($specifications as $spec): ?>
                        <?php if (count($specValues[$spec->id])): ?>
                            <div class="form-group <?php echo $spec->type_id == 3 ? 'multiSelectBlock' : NULL; ?>">
                                <?php if ($spec->type_id == 3): ?>
                                    <?php echo \Forms\Builder::select(\Core\Support::selectData($specValues[$spec->id], 'alias', 'name'),
                                        \Core\Arr::get($specArray, $spec->alias, array()), array(
                                            'name' => 'SPEC['.$spec->alias.'][]',
                                            'multiple' => 'multiple',
                                        ), $spec->name); ?>
                                <?php endif ?>
                                <?php if ($spec->type_id == 2 OR $spec->type_id == 1): ?>
                                    <?php echo \Forms\Builder::select(\Core\Support::selectData($specValues[$spec->id], 'alias', 'name', array(0, 'Нет')),
                                        \Core\Arr::get($specArray, $spec->alias), array(
                                            'name' => 'SPEC['.$spec->alias.']',
                                        ), $spec->name); ?>
                                <?php endif ?>
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
<?php echo \Forms\Form::close(); ?>

<?php echo $uploader; ?>
<?php echo $related; ?>

<script>
    $(function(){
        $('input[name="sale"]').on('change', function(){
            var val = parseInt( $(this).val() );
            if( val ) {
                var cost = $('input[name="FORM[cost]"]').val();
                var cost_old = $('input[name="FORM[cost_old]"]').val();
                $('input[name="FORM[cost]"]').val(cost_old);
                $('input[name="FORM[cost_old]"]').val(cost);
                $('.hiddenCostField').show();
            } else {
                var cost = $('input[name="FORM[cost]"]').val();
                var cost_old = $('input[name="FORM[cost_old]"]').val();
                $('input[name="FORM[cost]"]').val(cost_old);
                $('input[name="FORM[cost_old]"]').val(cost);
                $('.hiddenCostField').hide();
            }
        });

        $('#parent_id').on('change', function(){
            var catalog_tree_id = $(this).val();
            $.ajax({
                url: '/wezom/ajax/catalog/getSpecificationsByCatalogTreeID',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    catalog_tree_id: catalog_tree_id
                },
                success: function(data){
                    var i = 0;
                    var j = 0;
                    var val;
                    var html = '<option value="0">Нет</option>';
                    $('#model_alias').html(html);
                    for(i = 0; i < data.brands.length; i++) {
                        html += '<option value="' + data.brands[i].alias + '">' + data.brands[i].name + '</option>';
                    }
                    $('#brand_alias').html(html);
                    html = '';
                    for(i = 0; i < data.specifications.length; i++) {
                        var spec = data.specifications[i];
                        if( data.specValues[spec.id] ) {
                            var values = data.specValues[spec.id];
                            html += '<div class="form-group"><label class="control-label">'+spec.name+'</label>';
                            if( parseInt( spec.type_id ) == 3 ) {
                                html += '<div class="multiSelectBlock"><div class="controls">';
                                html += '<select class="form-control" name="SPEC['+spec.alias+'][]" multiple="10" style="height:150px;">';
                                for( j = 0; j < values.length; j++ ) {
                                    val = values[j];
                                    html += '<option value="'+val.alias+'">'+val.name+'</option>';
                                }
                                html += '</select>';
                                html += '</div></div>';
                            }
                            if( parseInt( spec.type_id ) == 2 || parseInt( spec.type_id ) == 1 ) {
                                html += '<div class=""><div class="controls">';
                                html += '<select class="form-control" name="SPEC['+spec.alias+']">';
                                html +='<option value="0">Нет</option>';
                                for( j = 0; j < values.length; j++ ) {
                                    val = values[j];
                                    html += '<option value="'+val.alias+'">'+val.name+'</option>';
                                }
                                html += '</select>';
                                html += '</div></div>';
                            }
                            html += '</div>';
                        }
                    }
                    $('#specGroup').html(html);
                    multi_select();
                }
            });
        });

        $('#brand_alias').on('change', function(){
            var brand_alias = $(this).val();
            $.ajax({
                url: '/wezom/ajax/catalog/getModelsByBrandID',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    brand_alias: brand_alias
                },
                success: function(data){
                    var html = '<option value="0">Нет</option>';
                    for(var i = 0; i < data.options.length; i++) {
                        html += '<option value="' + data.options[i].alias + '">' + data.options[i].name + '</option>';
                    }
                    $('#model_alias').html(html);
                }
            });
        });
    });
</script>