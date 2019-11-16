<?php
namespace app\index\validate;
use think\Validate;
class Userinsert extends Validate{
          protected $rule = [
            'names' => 'require',
            'mobile' => 'require|number|length:11',
            'idcard' => 'require|min:6',
        ];
        protected $message = [
            'names.require' => '姓名必须填写',
            'names.unique' => '姓名已经存在',
            'mobile.require' => '手机号必须填写',
            'mobile.number' => '手机号请填写正确格式',
            'idcard.require' => '身份证必须填写',
            'idcard.number' => '身份证请填写正确格式',
            'idcard.unique' => '身份证已经存在',
            

            
        ];
        protected $scene = [
            'insert' => ['names'=>'require','mobile'=>'require|number|length:11|unique:sun_user','idcard'=>'require|length:18|unique:sun_user'],
            
        ];
	
	

}

