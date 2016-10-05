<div class="compare js-compare">
    <div class="wSize">
        <div class="pageTitle">Лучше чем галогенки<br>и ксенон</div>
        <div class="compare_list">
            <div class="compare_item">
                <div class="compare_img">

                    <img src="<?php echo Core\HTML::media('pic/list1.jpg'); ?>" alt="">
                </div>
                <div class="compare_info">
                    <div class="compare_name">галогенка</div>
                    <div class="compare_text"><span>Светят желтым светом, который искажает восприятие цвета. Быстро нагреваются, а в дождь или снег не обеспечивают должной видимости.</span>
                    </div>
                    <div class="compare_opus">Срок службы <span>500 - 1000 часов</span></div>
                    <div class="compare_opus">Энергопотребление <span>55 Вт</span></div>
                </div>
            </div>
            <div class="compare_item">
                <div class="compare_img">
                    <img src="<?php echo Core\HTML::media('pic/list2.jpg'); ?>" alt="">
                </div>
                <div class="compare_info">
                    <div class="compare_name">ксенон</div>
                    <div class="compare_text"><span>Долго разгораются. От холодного яркого света болят глаза. В туман и дождь плохая видимость. Концентрируют 80% света в одной точке. Устанавливается только на СТО и при наличии разрешения.</span>
                    </div>
                    <div class="compare_opus">Срок службы <span>2500 - 4000 часов</span></div>
                    <div class="compare_opus">Энергопотребление <span>От 35 Вт</span></div>
                </div>
            </div>
            <div class="compare_item cur">
                <div class="compare_img">
                    <img src="<?php echo Core\HTML::media('pic/list3.jpg'); ?>" alt="">
                </div>
                <div class="compare_info">
                    <div class="compare_name">led-лампы napo model c</div>
                    <div class="compare_text"><span>Равномерно освещают дорогу. Обеспечивают отличную видимость в туман или в дождь. Свет не мерцает и не концентрируется в одной точке. Не слепит встречные автомобили</span>
                    </div>
                    <div class="compare_opus">Срок службы <span>30000 часов</span></div>
                    <div class="compare_opus">Энергопотребление <span>25 Вт</span></div>
                </div>
            </div>
        </div>
        <div class="order_block">
            <div class="order_title">Закажите прямо сейчас</div>
            <div data-form="true" class="order_form wForm wFormDef" data-ajax="order">
                <div class="wFormRow">
                    <label for="name">Введите имя</label>
                    <input type="text" required
                           name="name"
                           data-name="name"
                           data-rule-minlength="2"
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
                    <label for="cap">Выберете цоколь</label>
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
                            <input type="tel" data-count="1" value="1 шт" data-name="count" name="count" id="count"
                                   required
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
</div>