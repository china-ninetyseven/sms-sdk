<?php

namespace Mrwanghongda\SmsSdk\Sms\Services;

use Mrwanghongda\SmsSdk\Sms\Common\BaseSms;
use Mrwanghongda\SmsSdk\Sms\Interfaces\SmsInterface;

/**
 *  SmsBaoService 短信宝短信发送类
 */
class SmsBaoService extends BaseSms implements SmsInterface
{
    /**
     * 短信宝发送成功状态码
     */
    const SMSBAO_OK = 0;

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

    public function send(array $config)
    {
        // TODO: Implement send() method.
        $sendurl = self::SMS_API . "sms?u=" . $config['secretId'] . "&p=" . md5($config['secretKey']) . "&m=" . $config['tel'] . "&c=" . urlencode($config['content']);
        $result = file_get_contents($sendurl);

        if($result == self::SMSBAO_OK){
            $result = 200;
        }

        return $this->toJsonData($result);
    }
}