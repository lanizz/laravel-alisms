# ����Laravel5�����ƶ��ŷ������ṩ��


---

### Composer�������

    composer require "lanizz/laravel-alisms:dev-master"

### ע���ṩ��
��config/app.config��providers����������

    Lanizz\Laravel\AliSmsServiceProvider::class

### ��������ļ�
��config/����������ļ�alisms.php

    <?php
    /**
    * Created by PhpStorm.
    * User: Jinming
    * Date: 2017/7/19
    * Time: 16:09
    */
    return [
        //�����������Key
        'key' => '',
        //�����������Secret
        'secret' => '',
        //����, ����ָ�����ŷ�������������"cn-hangzhou","cn-beijing","cn-qingdao","cn-hongkong","cn-shanghai","us-west-1","cn-shenzhen","ap-southeast-1"
        'region' => 'cn-hangzhou',
        //����������Ķ���ǩ��
        'sign' => ''
    ];

### ��ʼʹ��

    $sms = App::make('alisms');
    $phone = ''; //�ֻ���
    $tplCode = ''; //ģ����룬�������������ģ��ͨ�������
    $params = []; //��������û�в�������
    $result = $sms->send($phone, $tplCode, $params);
    //����ֵ
    $result = [
        'ErrorCode' => '', //�����룬��������ʱ��
        'ErrorMessage' => '', //������Ϣ����������ʱ��
        'Model' => '',  //�ɹ�����
        'RequestId' => '' //�ɹ��в���
    ] 