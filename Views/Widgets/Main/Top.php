<div class="top_block js-top">
    <div class="wSize">
        <div class="site_name"><span>Лампы головного света <span>NAPO model С</span></span> надежный мощный свет<br>вашего
            автомобиля
        </div>

        <div class="detals">
            <img src="<?php echo Core\HTML::media('pic/detals.png'); ?>" alt="">
        </div>
        <div data-form="true" class="top_form wForm wFormDef">
            <div class="form_title">1500 грн на все</div>
            <div class="wFormRow">
                <label for="name1">Введите имя</label>
                <input type="text" required name="name1"
                       data-rule-mminlength="2"
                       data-rule-word="true"
                       id="name1" class="wInput">
            </div>
            <div class="wFormRow">
                <label for="phove1">Введите номер телефона</label>
                <input type="tel" required name="phove1"
                       data-rule-phoneua="true"
                       id="phove1"
                       class="wInput js-inputmask">
            </div>
            <div class="wFormRow">
                <label for="select1">Выберете цоколь</label>
                <select type="text" required name="select1" id="select1" class="wSelect js-select2">
                    <option value=""></option>
                    <option value="1">Н1</option>
                    <option value="2">Н3</option>
                    <option value="3">Н4</option>
                    <option value="4">Н7</option>
                    <option value="5">Н8/Н11</option>
                    <option value="6">9005 (HB3)</option>
                    <option value="7">9006 (HB4)</option>
                </select>
            </div>
            <div class="wFormRow">
                <label for="count1">Количество</label>
                <div class="counter_block">
                    <div class="spiner js-minus minus"></div>
                    <div class="counter js-couter">
                        <input type="tel" data-count="1" value="1 шт" name="count1" id="count1" required
                               class="wInput">
                    </div>
                    <div class="spiner js-plus plus"></div>
                </div>
            </div>
            <div class="wFormRow">
                <button class="wSubmit wBtn"><span>оформить заказ</span></button>
            </div>
        </div>
    </div>
</div>