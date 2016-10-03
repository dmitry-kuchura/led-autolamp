<?php use Core\Config; ?>
<div class="top_block js-top">
    <div class="wSize">
        <div class="site_name">
            <span>Лампы головного света <span>NAPO model С</span></span> надежный мощный свет<br>вашего автомобиля
        </div>
        <div class="detals">
            <img src="<?php echo Core\HTML::media('pic/detals.png'); ?>" alt="">
        </div>
        <div data-form="true" class="top_form wForm wFormDef" data-ajax="order">
            <div class="form_title">Всего <?php echo Config::get('static.price'); ?> грн</div>
            <div class="wFormRow">
                <label for="name">Введите имя</label>
                <input type="text" required
                       name="name"
                       data-name="name"
                       data-rule-mminlength="2"
                       data-rule-word="true"
                       id="name" class="wInput">
            </div>
            <div class="wFormRow">
                <label for="phone">Введите номер телефона</label>
                <input type="tel" required
                       name="phone"
                       data-name="phone"
                       data-rule-phoneua="true"
                       id="phone1"
                       class="wInput js-inputmask">
            </div>
            <div class="wFormRow">
                <label for="select1">Выберете цоколь</label>
                <select type="text" required name="cap" data-name="cap" id="cap" class="wSelect js-select2">
                    <option value=""></option>
                    <?php foreach ($result as $item): ?>
                        <option value="<?php echo $item->id; ?>"><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="wFormRow">
                <label for="count1">Количество</label>
                <div class="counter_block">
                    <div class="spiner js-minus minus"></div>
                    <div class="counter js-couter">
                        <input type="tel" data-count="1" value="1 шт" data-name="count" name="count" id="count" required
                               class="wInput">
                    </div>
                    <div class="spiner js-plus plus"></div>
                </div>
            </div>
            <?php if (array_key_exists('token', $_SESSION)): ?>
                <input type="hidden" data-name="token" value="<?php echo $_SESSION['token']; ?>"/>
            <?php endif; ?>
            <div class="wFormRow">
                <button class="wSubmit wBtn"><span>оформить заказ</span></button>
            </div>
        </div>
    </div>
</div>