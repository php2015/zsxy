<?php
namespace app\admin\validate;

use think\Validate;

class Useragent extends Validate
{
    protected $rule = [
        'idcard'         => 'require|unique:user',
        'mobile'           => 'require|number|length:11|unique:user',
        'status'           => 'require',
    ];

    protected $message = [
        'idcard.require'         => '请输入身份证',
        'idcard.unique'          => '身份证已存在',
        'mobile.require'            => '请输入手机号',
        'mobile.unique'            => '手机号已存在',
        'mobile.length'            => '手机号长度错误',
        'status.require'           => '请选择状态'
    ];
}