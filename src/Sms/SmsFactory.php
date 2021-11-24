<?php

namespace Mrwanghongda\SmsSdk\Sms;


use Mrwanghongda\SmsSdk\Sms\Services\SmsBaoService;
use Mrwanghongda\SmsSdk\Sms\Services\TencentService;

/**
 * SmsFactory 实现短信的简单工厂封装（腾讯、短信宝）
 */
class SmsFactory
{
    /**
     * 短信宝
     */
    const SMS_BAO = 'bao';

    /**
     * 腾讯云
     */
    const SMS_TENCENT = 'tencent';

    /**
     * 阿里云
     */
    const SMS_ALIYUN = 'aliyun';

    //私有属性
    private $smsType;

    public function __construct($type)
    {
        $this->smsType = $type;
    }

    public function getSmsService()
    {
        switch ($this->smsType) {
            case self::SMS_BAO:
                //短信宝
                return new SmsBaoService();
                break;
            case self::SMS_TENCENT:
                //腾讯云
                return new TencentService();
                break;
            case self::SMS_ALIYUN:
                //阿里云
                break;
            default:
                return null;
        }
    }
}