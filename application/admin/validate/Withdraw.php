<?php
namespace app\admin\validate;

use think\Validate;

class Withdraw extends Validate
{
    protected $rule = [
        'user_id'  => 'require',
        'money' => 'require',
        'bankcard' => 'require',
        'type' => 'require'
    ];

    protected $message = [
        'user_id.require'  => '请选择用户',
        'money.require' => '请输入金额',
        'bankcard.require' => '请输入卡号',
        'type.require'  => '请输入类型'
    ];
}