<?php
/**
 * Created by PhpStorm.
 * User: rongself
 * Date: 2017/5/27
 * Time: 下午6:17
 */

namespace Channels;

use Exceptions\SmsNotificationException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;
use Libraries\Sms;

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

        $config = Config::get('sms');

        $sms = new Sms( $config );
        $res = $sms->send( $phone, $message);
        if( $res ){
            if( isset( $res['error'] ) &&  $res['error'] == 0 ){

            }else{
                throw new SmsNotificationException('failed,code:'.$res['error'].',msg:'.$res['msg']);
            }
        }else{
            throw new SmsNotificationException($sms->last_error());
        }

        //if($result['errcode'] !== 0) throw new WechatNotificationException('消息发送失败');
    }
}