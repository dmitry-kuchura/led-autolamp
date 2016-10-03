<?php
namespace Modules\Ajax\Controllers;

use Core\GeoIP;
use Core\QB\DB;
use Core\Arr;
use Core\User;
use Core\System;
use Core\Log;
use Core\Email;

class Form extends \Modules\Ajax
{

    protected $post;
    protected $files;

    function before()
    {
        parent::before();
        // Check for bans in blacklist
        $ip = GeoIP::ip();
        $ips = array();
        $ips[] = $ip;
        $ips[] = $this->ip($ip, array(0));
        $ips[] = $this->ip($ip, array(1));
        $ips[] = $this->ip($ip, array(1, 0));
        $ips[] = $this->ip($ip, array(2));
        $ips[] = $this->ip($ip, array(2, 1));
        $ips[] = $this->ip($ip, array(2, 1, 0));
        $ips[] = $this->ip($ip, array(3));
        $ips[] = $this->ip($ip, array(3, 2));
        $ips[] = $this->ip($ip, array(3, 2, 1));
        $ips[] = $this->ip($ip, array(3, 2, 1, 0));
        if (count($ips)) {
            $bans = DB::select('date')
                ->from('blacklist')
                ->where('status', '=', 1)
                ->where('ip', 'IN', $ips)
                ->and_where_open()
                ->or_where('date', '>', time())
                ->or_where('date', '=', NULL)
                ->and_where_close()
                ->find_all();
            if (sizeof($bans)) {
                $this->error('К сожалению это действие недоступно, т.к. администратор ограничил доступ к сайту с Вашего IP адреса!');
            }
        }
    }

    private function ip($ip, $arr)
    {
        $_ip = explode('.', $ip);
        foreach ($arr AS $pos) {
            $_ip[$pos] = 'x';
        }
        $ip = implode('.', $_ip);
        return $ip;
    }

    public function orderAction()
    {
        $name = Arr::get($this->post, 'name');
        $phone = Arr::get($this->post, 'phone');
        $cap = Arr::get($this->post, 'cap');
        $count = Arr::get($this->post, 'count');
        if (!$name) {
            $this->error('Имя введено неверно!');
        }
        if (!$phone) {
            $this->error('Номер телефона введен неверно!');
        }
        if (!$cap) {
            $this->error('Цоколь не выбран!');
        }
        if (!$count) {
            $this->error('Неверно указано кол-во!');
        }

        $ip = System::getRealIP();
        $check = DB::select(array(DB::expr('orders.id'), 'count'))
            ->from('orders')
            ->where('ip', '=', $ip)
            ->where('created_at', '>', time() - 60)
            ->as_object()->execute()->current();
        if (is_object($check) AND $check->count) {
            $this->error('Пожалуйста, повторите попытку через минуту!');
        }

        // Save data
        $keys = ['name', 'phone', 'cap', 'count', 'ip', 'created_at'];
        $values = [$name, $phone, $cap, $count, $ip, time()];
        $lastID = DB::insert('orders', $keys)->values($values)->execute();
        $lastID = Arr::get($lastID, 0);

        // Save log
        $qName = 'Новый заказ';
        $url = '/wezom/orders/edit/' . $lastID;
        Log::add($qName, $url, 7);

        /*
        // Send message to admin if need
        $mail = DB::select()->from('mail_templates')->where('id', '=', 8)->where('status', '=', 1)->as_object()->execute()->current();
        if ($mail) {
            $from = array('{{site}}', '{{ip}}', '{{date}}', '{{phone}}', '{{link}}', '{{admin_link}}', '{{item_name}}');
            $to = array(
                Arr::get($_SERVER, 'HTTP_HOST'), $ip, date('d.m.Y H:i'),
                $phone, $link, $link_admin, $item->name,
            );
            $subject = str_replace($from, $to, $mail->subject);
            $text = str_replace($from, $to, $mail->text);
            Email::send($subject, $text);
        }
        */
        $this->success('Вы успешно оформили заказ! Менеджер свяжется с Вами в ближайшее время!');
    }

}