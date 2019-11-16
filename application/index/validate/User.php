<?php
namespace app\index\validate;
use think\Validate;
class User extends Validate{
          protected $rule = [
            'names' => 'require',
            'mobile' => 'require|number|length:11',
            'idcard'=> 'require|unique:user',
        ];
        protected $message = [
            'names.require' => '标题必须填写',
            'idcard.require' => '身份证内容必须填写',
            'idcard.unique' => '身份证已经存在',
            'mobile.require' => '手机内容必须填写',
            'phone.mobile' => '手机号码格式必须正确',

            
        ];
        protected $scene = [
            'edit' => ['names','phone'],
            'add' => ['names'=>'require|unique:user','mobile'=>'require|number|unique:user','idcard'=>'require|unique:user'],
        ];
	
	

}

