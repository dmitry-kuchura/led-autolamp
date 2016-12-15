<?php
namespace Modules\Ajax\Controllers;

use Core\GeoIP;
use Core\QB\DB;
use Core\Arr;
use Core\User;
use Core\System;
use Core\Log;
use Core\Email;
use Core\Config;

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
        $count = (int)Arr::get($this->post, 'count');
        if (!$name OR mb_strlen($name, 'UTF-8') < 2) {
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

        $keys = ['name', 'phone', 'cap', 'count', 'ip', 'created_at'];
        $values = [$name, $phone, $cap, $count, $ip, time()];
        $lastID = DB::insert('orders', $keys)->values($values)->execute();
        $lastID = Arr::get($lastID, 0);

        $qName = 'Новый заказ';
        $url = '/wezom/orders/edit/' . $lastID;
        Log::add($qName, $url, 7);

        $item = DB::select()->from('cap')->where('id', '=', $cap)->find();

        $mail = DB::select()->from('mail_templates')->where('id', '=', 1)->where('status', '=', 1)->as_object()->execute()->current();
        if ($mail) {
            $from = ['{{name}}', '{{phone}}', '{{cap}}', '{{count}}'];
            $to = [$name, $phone, $item->name, $count];
            $subject = str_replace($from, $to, $mail->subject);
            $text = str_replace($from, $to, $mail->text);
            Email::send($subject, $text);
        }

        $this->success('Вы успешно оформили заказ! Менеджер свяжется с Вами в ближайшее время!');


    }

    public function discountAction()
    {
        $name = Arr::get($this->post, 'name');
        $phone = Arr::get($this->post, 'phone');
        $percent = Config::get('discount.percent');
        $deliver = Config::get('discount.price');
        if (!$name OR mb_strlen($name, 'UTF-8') < 2) {
            $this->error('Имя введено неверно!');
        }
        if (!$phone) {
            $this->error('Номер телефона введен неверно!');
        }

        $ip = System::getRealIP();
        $check = DB::select(array(DB::expr('orders_simple.id'), 'count'))
            ->from('orders_simple')
            ->where('ip', '=', $ip)
            ->where('created_at', '>', time() - 60)
            ->as_object()->execute()->current();
        if (is_object($check) AND $check->count) {
            $this->error('Пожалуйста, повторите попытку через минуту!');
        }

        $keys = ['name', 'phone', 'deliver', 'percent', 'ip', 'created_at'];
        $values = [$name, $phone, $deliver, $percent, $ip, time()];
        $lastID = DB::insert('orders_simple', $keys)->values($values)->execute();
        $lastID = Arr::get($lastID, 0);

        $qName = 'Новый заказ скидки';
        $url = '/wezom/simple/edit/' . $lastID;
        Log::add($qName, $url, 2);

        $mail = DB::select()->from('mail_templates')->where('id', '=', 2)->where('status', '=', 1)->as_object()->execute()->current();
        if ($mail) {
            $from = ['{{name}}', '{{phone}}', '{{percent}}', '{{deliver}}'];
            $to = [$name, $phone, $percent, $deliver];
            $subject = str_replace($from, $to, $mail->subject);
            $text = str_replace($from, $to, $mail->text);
            Email::send($subject, $text);
        }

        $this->success('Вы успешно оформили заказ скидки! Менеджер свяжется с Вами в ближайшее время!');
    }

    public function selectionAction()
    {
        $name = Arr::get($this->post, 'name');
        $mark = Arr::get($this->post, 'mark');
        $model = Arr::get($this->post, 'model');
        $email = Arr::get($this->post, 'email');
        $engine = Arr::get($this->post, 'engine');
        $year = Arr::get($this->post, 'year');
        if (!$name OR mb_strlen($name, 'UTF-8') < 2) {
            $this->error('Имя введено неверно!');
        }
        if (!$mark OR mb_strlen($mark, 'UTF-8') < 2) {
            $this->error('Не указана марка!');
        }
        if (!$model OR mb_strlen($model, 'UTF-8') < 2) {
            $this->error('Не указана модель!');
        }
        if (!$email) {
            $this->error('Не указан email!');
        }
        if (!$engine OR mb_strlen($engine, 'UTF-8') < 2) {
            $this->error('Не указан тип двигателя!');
        }
        if (!$year OR mb_strlen($year, 'UTF-8') < 2) {
            $this->error('Не указан год выпуска!');
        }

        $ip = System::getRealIP();
        $check = DB::select(array(DB::expr('selection.id'), 'count'))
            ->from('selection')
            ->where('ip', '=', $ip)
            ->where('created_at', '>', time() - 60)
            ->as_object()->execute()->current();
        if (is_object($check) AND $check->count) {
            $this->error('Пожалуйста, повторите попытку через минуту!');
        }

        $keys = ['name', 'mark', 'model', 'email', 'engine', 'year', 'ip', 'created_at'];
        $values = [$name, $mark, $model, $email, $engine, $year, $ip, time()];
        $lastID = DB::insert('selection', $keys)->values($values)->execute();
        $lastID = Arr::get($lastID, 0);

        $qName = 'Новый подбор цоколя';
        $url = '/wezom/selection/edit/' . $lastID;
        Log::add($qName, $url, 1);

        $mail = DB::select()->from('mail_templates')->where('id', '=', 3)->where('status', '=', 1)->as_object()->execute()->current();
        if ($mail) {
            $from = ['{{name}}', '{{mark}}', '{{model}}', '{{email}}', '{{engine}}', '{{year}}'];
            $to = [$name, $mark, $model, $email, $engine, $year];
            $subject = str_replace($from, $to, $mail->subject);
            $text = str_replace($from, $to, $mail->text);
            Email::send($subject, $text);
        }

        // User
        $mail = DB::select()->from('mail_templates')->where('id', '=', 4)->where('status', '=', 1)->as_object()->execute()->current();
        if ($mail) {
            $from = ['{{name}}', '{{mark}}', '{{model}}', '{{email}}', '{{engine}}', '{{year}}'];
            $to = [$name, $mark, $model, $email, $engine, $year];
            $subject = str_replace($from, $to, $mail->subject);
            $text = str_replace($from, $to, $mail->text);
            Email::send($subject, $text, $email);
        }

        $this->success('Ваш подбор цоколя принят, наш менеджер свяжется с Вами в ближайшее время!');
    }

}