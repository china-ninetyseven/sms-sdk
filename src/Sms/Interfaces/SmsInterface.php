<?php

namespace Mrwanghongda\SmsSdk\Sms\Interfaces;

interface SmsInterface
{
    /**
     * 短信发送
     * @param $tel
     * @return mixed
     */
    public function send($tel);
}