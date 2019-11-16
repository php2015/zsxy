<?php
namespace app\admin\validate;

use think\Validate;

class Order extends Validate
{
    protected $rule = [
        'price'   => 'require',
        'reality_price' => 'require'
    ];

    protected $message = [
        'price.require' => '请输入金额',
        'reality_price.require'  => '请输入实付金额'
    ];
}