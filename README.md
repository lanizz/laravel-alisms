# 基于Laravel5阿里云短信服务器提供者


---
1.0版本支持阿里云2017年6月22日升级之前的协议。
升级后的协议在后续版本完成

### Composer添加依赖

``` stylus
composer require "lanizz/laravel-alisms:1.0"
```

### 注册提供者
在config/app.config的providers数组添加这段

``` php
Lanizz\Laravel\AliSmsServiceProvider::class
```

### 添加配置文件
在config/下添加配置文件alisms.php

``` php
<?php
/**
* Created by PhpStorm.
* User: Jinming
* Date: 2017/7/19
* Time: 16:09
*/
return [
	//阿里云申请的Key
	'key' => '',
	//阿里云申请的Secret
	'secret' => '',
	//地区, 可以指定短信服务器地区，如"cn-hangzhou","cn-beijing","cn-qingdao","cn-hongkong","cn-shanghai","us-west-1","cn-shenzhen","ap-southeast-1"
	'region' => 'cn-hangzhou',
	//阿里云申请的短信签名
	'sign' => ''
];
```


### 发送短信
``` php
$sms = App::make('alisms');
$phone = ''; //手机号
$tplCode = ''; //模版编码，阿里云申请短信模版通过后会有
$params = []; //参数，若没有参数不传
$result = $sms->send($phone, $tplCode, $params);
//返回值
$result = [
	'ErrorCode' => '', //错误码，发生错误时有
	'ErrorMessage' => '', //错误信息，发生错误时有
	'Model' => '',  //成功才有
	'RequestId' => '' //成功有才有
] 
```
### 查询结果
```php
$sms = App::make('alisms');
$phone = ''; //手机号
$sendDate = ''; //发送日期，格式Y-m-d
$pageSize = 10; //每页数量，默认10
$pageNo = 1; //当前页面，默认1
$results = $sms->query($phone, $sendDate, $pageSize, $pageNo);
//返回值
$results = [
	[
	'SmsStatus' => 1, //状态码
        'SmsContent' => '',//短信内容
        'ReceiverNum' => '',//手机号
        'ResultCode' => '', //结果码
        'SmsCode' => '' //模版code
	]
	...
]
```
