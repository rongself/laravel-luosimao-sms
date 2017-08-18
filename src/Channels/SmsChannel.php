<?php
/**
 * Created by PhpStorm.
 * User: rongself
 * Date: 2017/5/27
 * Time: 下午6:17
 */

namespace Rongself\Luosimao\Channels;

use Rongself\Luosimao\Exceptions\SmsNotificationException;
use Rongself\Luosimao\Libraries\Sms;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    /**
     * 发送给定通知
     *
     * @param  mixed $notifiable
     * @param Notification $notification
     * @return void
     * @throws SmsNotificationException
     */
    public function send($notifiable, Notification $notification)
    {
        $phone = $notifiable->getPhone();

        if (!isset($phone)) throw new SmsNotificationException('用户手机号码为空,无法发送模板消息');

        $message = $notification->toSmsMessage($notifiable);

        $config = config('luosimao-sms');
        $sms = new Sms($config);
        $res = $sms->send($phone, $message);
        if ($res) {
            if (isset($res['error']) && $res['error'] == 0) {

            } else {
                throw new SmsNotificationException('failed,code:' . $res['error'] . ',msg:' . $res['msg']);
            }
        } else {
            throw new SmsNotificationException(var_export($sms->last_error()));
        }

    }
}