<?php

namespace Mrwanghongda\SmsSdk\Sms\Services;

// 导入对应产品模块的client
use Mrwanghongda\SmsSdk\Sms\Common\BaseSms;
use Mrwanghongda\SmsSdk\Sms\Interfaces\SmsInterface;
use TencentCloud\Sms\V20210111\SmsClient;

// 导入要请求接口对应的Request类
use TencentCloud\Sms\V20210111\Models\SendSmsRequest;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Common\Credential;

// 导入可选配置类
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;

/**
 *  TencentService 腾讯短信发送类
 */
class TencentService extends BaseSms implements SmsInterface
{
    /**
     *  腾讯云发送成功状态码
     */
    const TENCENT_OK = 'ok';

    /**
     *  腾讯云发送成功状态码
     */
    public static $TencentCode = 0;

    public function send(array $config)
    {
        try {
            $cred = new Credential($config['secretId'], $config['secretKey']);
            // 实例化一个http选项，可选的，没有特殊需求可以跳过
            $httpProfile = new HttpProfile();
            // 配置代理
            // $httpProfile->setProxy("https://ip:port");
            $httpProfile->setReqMethod("GET");  // post请求(默认为post请求)
            $httpProfile->setReqTimeout(30);    // 请求超时时间，单位为秒(默认60秒)
            $httpProfile->setEndpoint("sms.tencentcloudapi.com");  // 指定接入地域域名(默认就近接入)

            // 实例化一个client选项，可选的，没有特殊需求可以跳过
            $clientProfile = new ClientProfile();
            $clientProfile->setSignMethod("TC3-HMAC-SHA256");  // 指定签名算法(默认为HmacSHA256)
            $clientProfile->setHttpProfile($httpProfile);

            // 实例化要请求产品(以sms为例)的client对象,clientProfile是可选的
            // 第二个参数是地域信息，可以直接填写字符串 ap-guangzhou，或者引用预设的常量
            $client = new SmsClient($cred, "ap-guangzhou", $clientProfile);
            // 实例化一个 sms 发送短信请求对象,每个接口都会对应一个request对象。
            $req = new SendSmsRequest();
            /* 短信应用ID: 短信SdkAppId在 [短信控制台] 添加应用后生成的实际SdkAppId，示例如1400006666 */
            $req->SmsSdkAppId = $config['smsSdkAppId'];
            /* 短信签名内容: 使用 UTF-8 编码，必须填写已审核通过的签名，签名信息可登录 [短信控制台] 查看 */
            $req->SignName = $config['signName'];
            /* 下发手机号码，采用 E.164 标准，+[国家或地区码][手机号]
             * 示例如：+8613711112222， 其中前面有一个+号 ，86为国家码，13711112222为手机号，最多不要超过200个手机号*/
            $req->PhoneNumberSet = array("+86" . $config['tel']);
            /* 模板 ID: 必须填写已审核通过的模板 ID。模板ID可登录 [短信控制台] 查看 */
            $req->TemplateId = $config['templateId'];
            $req->TemplateParamSet = array($config['code']);
            // 通过client对象调用SendSms方法发起请求。注意请求方法名与请求对象是对应的
            // 返回的resp是一个SendSmsResponse类的实例，与请求对象对应
            $resp = $client->SendSms($req);

            // 输出json格式的字符串回包
            $respJson = $resp->toJsonString();
            $respData = json_decode($respJson, true);

            if ($respData['SendStatusSet'][0]['Code'] == self::TENCENT_OK) {
                self::$TencentCode = 200;
            }

            return $this->toJsonData(self::$TencentCode);
        } catch (TencentCloudSDKException $e) {
            return $e;
        }
    }
}