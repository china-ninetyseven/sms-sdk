<?php

namespace Mrwanghongda\SmsSdk\Sms\Common;

class BaseSms
{
    /**
     *  短信成功状态码
     */
    const MESSAGE_OK = 200;

    /**
     *  短信失败状态码
     */
    const MESSAGE_ERROR = 50001;

    /**/
    public static $message = [
        '200' => '发送成功',
        '50001' => '发送失败',
    ];

    /**
     * 返回json
     * @param $code
     * @param string $message
     * @param array $data
     * @return false|string
     */
    public function toJsonData($code, $data = [])
    {
        $result = [
            'code' => $code,
            'message' => !isset(self::$message[$code]) ? "状态码无效" : self::$message[$code],
            'data' => !empty($data) ? $data : [],
        ];

        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

}