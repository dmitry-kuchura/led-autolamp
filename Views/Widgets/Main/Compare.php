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
            <div data-form="true" class="order_form wForm wFormDef">
                <div class="wFormRow">
                    <label for="name3">Введите имя</label>
                    <input type="text" required name="name3" data-rule-mminlength="2" data-rule-word="true"
                           id="name3" class="wInput">
                </div>
                <div class="wFormRow">
                    <label for="phove3">Введите номер телефона</label>
                    <input type="tel" required name="phove3" data-rule-phoneua="true" id="phove3"
                           class="wInput js-inputmask">
                </div>
                <div class="wFormRow">
                    <label for="select3">Выберете цоколь</label>
                    <select type="text" required name="select3" id="select3" class="wSelect js-select2">
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
                    <label for="count3">Количество</label>
                    <div class="counter_block">
                        <div class="spiner js-minus minus"></div>
                        <div class="counter js-couter">
                            <input type="tel" data-count="1" value="1 шт" name="count3" id="count3" required
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
</div>