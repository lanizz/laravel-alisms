<?php
/**
 * Created by PhpStorm.
 * User: Jinming
 * Date: 2017/7/19
 * Time: 15:50
 */

namespace Lanizz\Laravel;


class AliSms
{
    private $key;
    private $secret;
    private $region;
    private $sign;
    private $client;

    public function init()
    {
        $iClientProfile = DefaultProfile::getProfile($this->region, $this->key, $this->secret);
        return $this->client = new DefaultAcsClient($iClientProfile);
    }

    public function setKey($key)
    {
        return $this->key = $key;
    }

    public function setSecret($secret)
    {
        return $this->secret = $secret;
    }

    public function setRegion($region = 'cn-hangzhou')
    {
        return $this->region = $region;
    }

    public function setSign($sign)
    {
        return $this->sign = $sign;
    }

    public function send($phone, $tplCode, $params = ['def' => ''])
    {


        $request = new SingleSendSmsRequest();
        $request->setSignName($this->sign);
        $request->setTemplateCode($tplCode);
        $request->setRecNum($phone);

        foreach ($params as $key => $value) {
            if (is_numeric($value))
                $params[$key] = strval($value);
        }
        $request->setParamString(json_encode($params));

        try {
            $ret = $this->client->getAcsResponse($request);
            return [
                'ErrorCode' => 0,
                'ErrorMessage' => '',
                'Model' => $ret->Model,
                'RequestId' => $ret->RequestId
            ];
        } catch (ClientException  $e) {
            return [
                'ErrorCode' => $e->getErrorCode(),
                'ErrorMessage' => $e->getErrorMessage()
            ];

        } catch (ServerException  $e) {
            return [
                'ErrorCode' => $e->getErrorCode(),
                'ErrorMessage' => $e->getErrorMessage()
            ];

        }
    }

    public function query($phone, $sendDate, $pageSize = 1, $pageNo = 1)
    {
        // 初始化QuerySendDetailsRequest实例用于设置短信查询的参数
        $request = new QuerySmsDetailByPageRequest();
        // 必填，短信接收号码
        $request->setRecNum($phone);
        // 必填，短信发送日期，支持近30天记录查询，格式Ymd
        $request->setQueryTime($sendDate);
        // 必填，分页大小
        $request->setPageSize($pageSize);
        // 必填，当前页码
        $request->setPageNo($pageNo);
        // 发起访问请求
        $acsResponse = $this->client->getAcsResponse($request);
        if (!$acsResponse->data || !$acsResponse->data->stat)
            return null;
        $result = [];
        foreach ($acsResponse->data->stat as $s) {
            $result[] = [
                'SmsStatus'=>$s->SmsStatus,
                'SmsContent'=>$s->SmsContent,
                'ReceiverNum'=>$s->ReceiverNum,
                'ResultCode'=>$s->ResultCode,
                'SmsCode'=>$s->SmsCode
            ];
        }
        return $result;
    }

    public function setEndPoint()
    {
        $regionIds = array("cn-hangzhou", "cn-beijing", "cn-qingdao", "cn-hongkong", "cn-shanghai", "us-west-1", "cn-shenzhen", "ap-southeast-1");
        $productDomains = array(
            new ProductDomain("Mts", "mts.cn-hangzhou.aliyuncs.com"),
            new ProductDomain("ROS", "ros.aliyuncs.com"),
            new ProductDomain("Dm", "dm.aliyuncs.com"),
            new ProductDomain("Sms", "sms.aliyuncs.com"),
            new ProductDomain("Bss", "bss.aliyuncs.com"),
            new ProductDomain("Ecs", "ecs.aliyuncs.com"),
            new ProductDomain("Oms", "oms.aliyuncs.com"),
            new ProductDomain("Rds", "rds.aliyuncs.com"),
            new ProductDomain("BatchCompute", "batchCompute.aliyuncs.com"),
            new ProductDomain("Slb", "slb.aliyuncs.com"),
            new ProductDomain("Oss", "oss-cn-hangzhou.aliyuncs.com"),
            new ProductDomain("OssAdmin", "oss-admin.aliyuncs.com"),
            new ProductDomain("Sts", "sts.aliyuncs.com"),
            new ProductDomain("Push", "cloudpush.aliyuncs.com"),
            new ProductDomain("Yundun", "yundun-cn-hangzhou.aliyuncs.com"),
            new ProductDomain("Risk", "risk-cn-hangzhou.aliyuncs.com"),
            new ProductDomain("Drds", "drds.aliyuncs.com"),
            new ProductDomain("M-kvstore", "m-kvstore.aliyuncs.com"),
            new ProductDomain("Ram", "ram.aliyuncs.com"),
            new ProductDomain("Cms", "metrics.aliyuncs.com"),
            new ProductDomain("Crm", "crm-cn-hangzhou.aliyuncs.com"),
            new ProductDomain("Ocs", "pop-ocs.aliyuncs.com"),
            new ProductDomain("Ots", "ots-pop.aliyuncs.com"),
            new ProductDomain("Dqs", "dqs.aliyuncs.com"),
            new ProductDomain("Location", "location.aliyuncs.com"),
            new ProductDomain("Ubsms", "ubsms.aliyuncs.com"),
            new ProductDomain("Drc", "drc.aliyuncs.com"),
            new ProductDomain("Ons", "ons.aliyuncs.com"),
            new ProductDomain("Aas", "aas.aliyuncs.com"),
            new ProductDomain("Ace", "ace.cn-hangzhou.aliyuncs.com"),
            new ProductDomain("Dts", "dts.aliyuncs.com"),
            new ProductDomain("R-kvstore", "r-kvstore-cn-hangzhou.aliyuncs.com"),
            new ProductDomain("PTS", "pts.aliyuncs.com"),
            new ProductDomain("Alert", "alert.aliyuncs.com"),
            new ProductDomain("Push", "cloudpush.aliyuncs.com"),
            new ProductDomain("Emr", "emr.aliyuncs.com"),
            new ProductDomain("Cdn", "cdn.aliyuncs.com"),
            new ProductDomain("COS", "cos.aliyuncs.com"),
            new ProductDomain("CF", "cf.aliyuncs.com"),
            new ProductDomain("Ess", "ess.aliyuncs.com"),
            new ProductDomain("Ubsms-inner", "ubsms-inner.aliyuncs.com"),
            new ProductDomain("Green", "green.aliyuncs.com"),
            new ProductDomain("Dysmsapi", "dysmsapi.aliyuncs.com")

        );
        $endpoint = new Endpoint("cn-hangzhou", $regionIds, $productDomains);
        $endpoints = array($endpoint);
        EndpointProvider::setEndpoints($endpoints);
    }
}