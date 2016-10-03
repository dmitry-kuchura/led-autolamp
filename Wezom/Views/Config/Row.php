<div class="form-group">
    <?php $attributes = array(
        'name' => $obj->group.'-'.$obj->key,
        'rows' => 5,
        'value' => $obj->zna,
    ); ?>

    <?php if($obj->valid): ?>
        <?php $attributes['class'] = 'valid'; ?>
    <?php endif; ?>

    <?php if($obj->type == 'textarea'): ?>
        <?php $attributes['rows'] = 5; ?>
        <?php echo \Forms\Builder::textarea($attributes, $obj->name); ?>
    <?php elseif($obj->type == 'tiny'): ?>
        <?php echo \Forms\Builder::tiny($attributes, $obj->name); ?>
    <?php elseif($obj->type == 'date'): ?>
        <?php $attributes['class'][] = 'myPicker'; ?>
        <?php // var_dump($attributes); die;?>
        <?php echo \Forms\Builder::input($attributes, $obj->name); ?>
    <?php elseif($obj->type == 'select'): ?>
        <?php $values = json_decode($obj->values, true); ?>
        <?php echo \Forms\Builder::select(\Core\Support::selectData($values, 'value', 'key'), $obj->zna, $attributes, $obj->name); ?>
    <?php elseif($obj->type == 'radio'): ?>
        <?php echo \Forms\Form::label($obj->name); ?>
        <div class="clear"></div>
        <?php $values = json_decode($obj->values, true); ?>
        <?php foreach($values AS $v): ?>
            <?php $attr = $attributes; ?>
            <label class="checkerWrap-inline radioWrap col-md-4" style="margin-right: 0;">
                <?php $attr['value'] = $v['value']; ?>
                <?php echo \Forms\Builder::radio($obj->zna == $v['value'] ? true : false, $attr); ?>
                <?php echo $v['key']; ?>
            </label>
        <?php endforeach; ?>
    <?php elseif($obj->type == 'password'): ?>
        <?php echo \Forms\Form::label($obj->name, array('for' => 'field_'.$obj->id)); ?>
        <div class="clear"></div>
        <?php $attributes['id'] = 'field_'.$obj->id; ?>
        <?php $attributes['autocomplete'] = 'off'; ?>
        <?php echo \Forms\Builder::password($attributes); ?>
        <span class="input-group-btn" style="vertical-align: bottom;">
            <?php echo \Forms\Form::button('Показать', array(
                'type' => 'button',
                'class' => 'btn showPassword',
            )); ?>
        </span>
    <?php else: ?>
        <?php echo \Forms\Builder::input($attributes, $obj->name); ?>
    <?php endif; ?>
</div>