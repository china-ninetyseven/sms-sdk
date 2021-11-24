<?php

namespace Mrwanghongda\SmsSdk\Sms\Services;

use Mrwanghongda\SmsSdk\Sms\Interfaces\SmsInterface;

class SmsBaoService implements SmsInterface
{
    public $statusStr = array(
        "0" => "短信发送成功",
        "-1" => "参数不全",
        "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
        "30" => "密码错误",
        "40" => "账号不存在",
        "41" => "余额不足",
        "42" => "帐户已过期",
        "43" => "IP地址限制",
        "50" => "内容含有敏感词"
    );

    const SMS_API = "http://api.smsbao.com/";

    public function send($tel)
    {
        // TODO: Implement send() method.
        $user = "wanghongda"; //短信平台帐号
        $pass = md5("wanghongda..1203"); //短信平台密码

        $code = mt_rand(1000, 9999);
        $content = "【短信宝】您的验证码是" . $code . ",3分钟有效。";//要发送的短信内容

        $sendurl = self::SMS_API . "sms?u=" . $user . "&p=" . $pass . "&m=" . $tel . "&c=" . urlencode($content);
        $result = file_get_contents($sendurl);
        return $this->statusStr[$result];
    }
}