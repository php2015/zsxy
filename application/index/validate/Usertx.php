<?php
namespace app\index\validate;
use think\Validate;
class Usertx extends Validate{
          protected $rule = [
            'type' => 'require',
            'bankcard' => 'require|number',
            'money' => 'require|number',
        ];
        protected $message = [
            'type.require' => '请先绑定收款方式',
            'bankcard.require' => '请先绑定收款方式',
            'bankcard.number' => '请先绑定收款方式',
            'money.require' => '金额不能为0',
            'money.number' => '请填写数字',
            

            
        ];
        protected $scene = [
            'edit' => ['type','bankcard','money'],
            
        ];
	
	

}

