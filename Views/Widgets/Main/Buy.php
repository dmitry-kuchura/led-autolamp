<div class="buy js-buy">
    <div class="wSize">
        <div class="buy_title"><span>3</span> причины купить<br>LED-лампы у нас</div>
        <div class="buy_list">
            <div class="buy_item">
                <div class="buy_svg icon_money">
                    <svg>
                        <use xlink:href="#icon_money"/>
                    </svg>
                </div>
                <div class="buy_name">Доступная цена</div>
                <div class="buy_text">За счет прямых поставок от производителя</div>
            </div>
            <div class="buy_item">
                <div class="buy_svg icon_dollar">
                    <svg>
                        <use xlink:href="#icon_dollar"/>
                    </svg>
                </div>
                <div class="buy_name">Возможность возврата</div>
                <div class="buy_text">В течение 14 дней</div>
            </div>
            <div class="buy_item">
                <div class="buy_svg icon_prosent">
                    <svg>
                        <use xlink:href="#icon_prosent"/>
                    </svg>
                </div>
                <div class="buy_name">Гарантия</div>
                <div class="buy_text">12 месяцев</div>
            </div>
        </div>
    </div>
    <div class="buy2">
        <div class="wSize">
            <div class="buy_list2">
                <div class="buy_item">
                    <div class="buy_svg icon_post">
                        <svg>
                            <use xlink:href="#icon_new_post"/>
                        </svg>
                    </div>
                    <div class="buy_name">Доставка<br>новой почтой</div>
                </div>
                <div class="buy_item">
                    <div class="buy_svg icon_box">
                        <svg>
                            <use xlink:href="#icon_box"/>
                        </svg>
                    </div>
                    <div class="buy_name">Оплата наложенным<br>платежом</div>
                </div>
            </div>
        </div>
    </div>
    <div class="buy_bot">
        <div class="wSize">
            <div class="buy_form w_flr">
                <div class="buy_form_title">Подобрать цоколь<br>для автомобиля</div>
                <div data-form="true" class="wForm wFormDef" data-ajax="selection">
                    <div class="wFormRow">
                        <label for="name">Введите Ваше имя</label>
                        <input type="text" required
                               name="name"
                               data-name="name"
                               data-rule-word="true"
                               data-rule-mminlength="2"
                               id="name" class="wInput">
                    </div>
                    <div class="wFormRow">
                        <label for="mark">Укажите марку*</label>
                        <input type="text" required
                               name="mark"
                               data-name="mark"
                               id="mark" class="wInput">
                    </div>
                    <div class="wFormRow">
                        <label for="model">Укажите модель**</label>
                        <input type="text" required
                               name="model"
                               data-name="model"
                               id="model" class="wInput">
                    </div>
                    <div class="wFormRow">
                        <label for="email">Введите Ваш E-mail</label>
                        <input type="email"
                               required
                               name="email"
                               data-name="email"
                               data-rule-email="true" id="email"
                               class="wInput">
                    </div>
                    <div class="wFormRow">
                        <label for="engine">Укажите тип двигателя***</label>
                        <input type="text" required
                               name="engine"
                               data-name="engine"
                               id="engine" class="wInput">
                    </div>
                    <div class="wFormRow">
                        <label for="year">Укажите год выпуска****</label>
                        <input type="tel" required
                               name="year"
                               data-name="year"
                               data-rule-minlength="4"
                               data-rule-digits="true"
                               id="year" class="wInput">
                    </div>
                    <div class="wFormRow wTxt">
                        <span>* - Например: NISSAN</span>
                        <span>** - Например: ATLEON</span>
                        <span>*** - Например: BD-30</span>
                        <span>**** - Например: 2006</span>
                    </div>
                    <?php if(array_key_exists('token', $_SESSION)): ?>
                        <input type="hidden" data-name="token" value="<?php echo $_SESSION['token']; ?>"/>
                    <?php endif; ?>
                    <div class="wFormRow">
                        <button class="wSubmit wBtn"><span>Спросить менеджера</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>