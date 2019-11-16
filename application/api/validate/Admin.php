<?php
namespace app\api\validate;
use think\Validate;
class Admin extends Validate{
          protected $rule = [
            'names' => 'require',
            'password' => 'require',
        ];
        protected $message = [
            'names.require' => '用户名必须填写',
            'names.unique' => '用户名已存在',
            'password.require' => '密码内容必须填写',
            'password.length' => '密码不能少于6位',

            
        ];
        protected $scene = [
            'edit' => ['username','password'],
            'add' => ['username','password'],
        ];
	
	

}

