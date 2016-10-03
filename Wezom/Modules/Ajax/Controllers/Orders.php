<?php

namespace Wezom\Modules\Ajax\Controllers;

use Core\Arr;
use Core\Common;
use Core\Email;
use Core\HTML;
use Core\Message;
use Core\QB\DB;
use Core\Config;
use Core\View;
use Wezom\Modules\Orders\Models\OrdersItems;
use Wezom\Modules\User\Models\Users;

class Orders extends \Wezom\Modules\Ajax {

    /**
     * Generate associative array from serializeArray data
     * @param $data
     * @return array
     */
    public function getDataFromSerialize($data) {
        $arr = array();
        foreach ($data AS $el) {
            $arr[$el['name']] = $el['value'];
        }
        return $arr;
    }

    /**
     * Change status of the order
     * $this->post['id'] => order ID
     * $this->post['data'] => incoming serialized data
     */
    public function orderStatusAction() {
        if (!Arr::get($this->post, 'id')) {
            $this->error(array(
                'msg' => 'Выберите заказ!',
            ));
        }

        $__order = \Wezom\Modules\Orders\Models\Orders::getRow(Arr::get($this->post, 'id')); // Old older. We need status of this order

        $post = $this->getDataFromSerialize(Arr::get($this->post, 'data'));
        $statuses = Config::get('order.statuses');
        if (!isset($statuses[Arr::get($post, 'status')]) OR ! isset($post['status'])) {
            $this->error(array(
                'msg' => 'Укажите статус!',
            ));
        }

        if (Arr::get($post, 'status') != $__order->status) {
            Common::factory('orders')->update(array('status' => Arr::get($post, 'status')), Arr::get($this->post, 'id'));

            if ((int) Arr::get($post, 'sendEmail', 0)) {
                $order = \Wezom\Modules\Orders\Models\Orders::getRow(Arr::get($this->post, 'id'));
                $mail = false;
                if (Arr::get($post, 'status') == 1) {
                    $mail = DB::select()->from('mail_templates')->where('id', '=', 21)->where('status', '=', 1)->find();
                } else if (Arr::get($post, 'status') == 3) {
                    $mail = DB::select()->from('mail_templates')->where('id', '=', 20)->where('status', '=', 1)->find();
                }
                if ($mail && filter_var($order->email, FILTER_VALIDATE_EMAIL)) {
                    $from = array('{{site}}', '{{name}}', '{{last_name}}', '{{middle_name}}', '{{amount}}', '{{id}}');
                    $to = array(
                        Arr::get($_SERVER, 'HTTP_HOST'), $order->name, $order->last_name, $order->middle_name,
                        $order->amount, $order->id
                    );
                    $subject = str_replace($from, $to, $mail->subject);
                    $text = str_replace($from, $to, $mail->text);
                    Email::send($subject, $text, $order->email);
                }
            }

            if ($__order->user_id) {
                $user = Users::getForOrder($__order->user_id);
                if ($user && $user->partner) {
                    if (Arr::get($post, 'status') == 1) {
                        Common::factory('orders')->update(array('done' => time()), Arr::get($this->post, 'id'));
                    } else if (Arr::get($post, 'status') != 1 && $__order->status == 1) {
                        Common::factory('orders')->update(array('done' => NULL), Arr::get($this->post, 'id'));
                    }
                }
            }
        }

        Message::GetMessage(1, 'Данные сохранены!');
        $this->success(array('reload' => 1));
    }

    /**
     * Change delivery settings
     * $this->post['id'] => order ID
     * $this->post['data'] => incoming serialized data
     */
    public function orderDeliveryAction() {
        if (!Arr::get($this->post, 'id')) {
            $this->error(array(
                'msg' => 'Выберите заказ!',
            ));
        }
        $post = $this->getDataFromSerialize(Arr::get($this->post, 'data'));
        $delivery = Config::get('order.delivery');
        if (!isset($delivery[Arr::get($post, 'delivery')]) OR ! isset($post['delivery'])) {
            $this->error(array(
                'msg' => 'Укажите способ доставки!',
            ));
        }
        $data = array('delivery' => Arr::get($post, 'delivery'));
        Common::factory('orders')->update($data, Arr::get($this->post, 'id'));
        $this->success(array(
            'msg' => 'Данные сохранены!',
        ));
    }

    /**
     * Change payment settings
     * $this->post['id'] => order ID
     * $this->post['data'] => incoming serialized data
     */
    public function orderPaymentAction() {
        if (!Arr::get($this->post, 'id')) {
            $this->error(array(
                'msg' => 'Выберите заказ!',
            ));
        }
        $post = $this->getDataFromSerialize(Arr::get($this->post, 'data'));
        $payment = Config::get('order.payment');
        if (!isset($payment[Arr::get($post, 'payment')]) OR ! isset($post['payment'])) {
            $this->error(array(
                'msg' => 'Неверные данные!',
            ));
        }
        Common::factory('orders')->update(array('payment' => Arr::get($post, 'payment')), Arr::get($this->post, 'id'));
        $this->success(array(
            'msg' => 'Данные сохранены!',
        ));
    }

    /**
     * Change user information
     * $this->post['id'] => order ID
     * $this->post['data'] => incoming serialized data
     */
    public function orderUserAction() {
        if (!Arr::get($this->post, 'id')) {
            $this->error(array(
                'msg' => 'Выберите заказ!',
            ));
        }
        $post = $this->getDataFromSerialize(Arr::get($this->post, 'data'));
        if (!Arr::get($post, 'phone')) {
            $this->error(array(
                'msg' => 'Укажите номер телефона!',
            ));
        }
        if (!Arr::get($post, 'name')) {
            $this->error(array(
                'msg' => 'Укажите имя!',
            ));
        }if (!Arr::get($post, 'last_name')) {
            $this->error(array(
                'msg' => 'Укажите фамилию!',
            ));
        }
        if (!Arr::get($post, 'email')) {
            $this->error(array(
                'msg' => 'Укажите E-Mail!',
            ));
        }
        Common::factory('orders')->update(array(
            'name' => Arr::get($post, 'name'),
            'last_name' => Arr::get($post, 'last_name'),
            'middle_name' => Arr::get($post, 'middle_name'),
            'email' => Arr::get($post, 'email'),
            'phone' => Arr::get($post, 'phone'),
                ), Arr::get($this->post, 'id'));
        $this->success(array(
            'msg' => 'Данные сохранены!',
        ));
    }

    /**
     * TODO update this method and script in my.js to array changes and without "size_id"
     * Change items information
     * $this->post['id'] => order ID
     * $this->post['catalog_id'] => item ID
     * $this->post['count'] => new item count in order
     * $this->post['size_id'] => item size ID
     */
    public function orderItemsAction() {
        if (!Arr::get($this->post, 'id')) {
            $this->error();
        }
        if (!Arr::get($this->post, 'catalog_id')) {
            $this->error();
        }
        $res = DB::update('orders_items')->set(array(
                    'count' => Arr::get($this->post, 'count'),
                ))
                ->where('order_id', '=', Arr::get($this->post, 'id'))
                ->where('catalog_id', '=', Arr::get($this->post, 'catalog_id'))
                ->execute();
        if ($res) {
            Common::factory('orders')->update(array('changed' => 1), Arr::get($this->post, 'id'));
            $this->success(array('email_button' => true));
        }
        $this->success(array('email_button' => false));
    }

    /**
     * TODO update this method without "size_id"
     * Delete item position from the order
     * $this->post['id'] => order ID
     * $this->post['catalog_id'] => item ID
     * $this->post['size_id'] => item size ID
     */
    public function orderPositionDeleteAction() {
        $post = $this->post;
        if (!Arr::get($post, 'id')) {
            $this->error();
        }
        if (!Arr::get($post, 'catalog_id')) {
            $this->error();
        }
        $res = DB::delete('orders_items')
                ->where('order_id', '=', Arr::get($post, 'id'))
                ->where('catalog_id', '=', Arr::get($post, 'catalog_id'))
                ->where('size_id', '=', Arr::get($post, 'size_id'))
                ->execute();
        if ($res) {
            Common::factory('orders')->update(array('changed' => 1), Arr::get($post, 'id'));
        }
        $this->success(array(
            'msg' => 'Позиция удалена!',
        ));
    }

    public function sendEmailAction() {
        $id = (int) Arr::get($this->post, 'id');
        if (!$id) {
            $this->error('Такого заказа не существует!');
        }
        $order = \Wezom\Modules\Orders\Models\Orders::getRow($id);
        if ($order->changed != 1) {
            $this->error('Содержимое заказа не было изменено!');
        }
        $items = OrdersItems::getRows($id);
        if (!$items) {
            $this->error('Невозможно отправить оповещение о пустом заказе!');
        }
        $mail = DB::select()->from('mail_templates')->where('id', '=', 15)->where('status', '=', 1)->find();
        if ($mail) {
            $from = array('{{site}}', '{{name}}', '{{last_name}}', '{{middle_name}}', '{{id}}', '{{amount}}', '{{items}}');
            $to = array(
                Arr::get($_SERVER, 'HTTP_HOST'), $order->name, $order->last_name, $order->middle_name, $order->id, $order->amount,
                View::tpl(array('cart' => $items), 'Catalog/ItemsMail')
            );
            $subject = str_replace($from, $to, $mail->subject);
            $text = str_replace($from, $to, $mail->text);
            Email::send($subject, $text, $order->email);
        }
        Common::factory('orders')->update(array('changed' => 0), $order->id);
        $this->success();
    }

}
