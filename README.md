# sms-sdk

一个集成腾讯云、短信宝短信发送的工具类

A SMS sending tool class integrating Tencent cloud and SMS treasure

配置参数，可快速实现不同平台的短信发送(目前只支持腾讯云、短信宝)

Configure parameters to quickly send SMS on different platforms

## Installation

```php
composer require mrwanghongda/sms-sdk
```

## example

```php
    use App\Factory\SmsFactory;
    
    /**
     * 短信宝
     */
    const SMS_BAO = 'bao';

    /**
     * 腾讯云
     */
    const SMS_TENCENT = 'tencent';

    /**
     * 阿里云正在开发中...
     */
    const SMS_ALIYUN = 'aliyun';


    //工厂模式
    $smsObj = (new SmsFactory(SmsFactory::SMS_TENCENT))->getSmsService();
    /* 必要步骤：
          * 实例化一个认证对象，入参需要传入腾讯云账户密钥对secretId，secretKey。
          * 这里采用的是从环境变量读取的方式，需要在环境变量中先设置这两个值。
          * 你也可以直接在代码中写死密钥对，但是小心不要将代码复制、上传或者分享给他人，
          * 以免泄露密钥对危及你的财产安全。
          * CAM密匙查询: https://console.cloud.tencent.com/cam/capi*/

        $config = [
            /* 填写平台对应的CAM密匙secretId，短信宝填写平台账号*/
            'secretId' => '',
            /* 填写平台对应的CAM密匙secretKey，短信宝填写平台密码*/
            'secretKey' => '',
            /* 短信应用ID: 短信SdkAppId在 [短信控制台] 添加应用后生成的实际SdkAppId，示例如1400006666 ,短信宝默认为空*/
            'smsSdkAppId' => '',
            /* 验证码,示例如5039 */
            'code' => $code,
            /* 填写腾讯、阿里平台对应的签名内容,短信宝则默认为空 */
            'signName' => '',
            /* 发送的手机号,示例如17899873465 */
            'tel' => $tel,
            /* 模板 ID: 必须填写已审核通过的模板 ID。模板ID可登录 [短信控制台] 查看 */
            'templateId' => "",
            /* 模板发送的短信内容，短信宝则需要填写 如："【短信宝】您的验证码是"5390",3分钟有效。", 腾讯、阿里默认为空 */
            'content' => '【短信宝】您的验证码是'.$code.',3分钟有效。',//
        ];

        $result = $smsObj->send($config);
```

