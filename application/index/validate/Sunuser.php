<?php
namespace app\index\validate;
use think\Validate;
class Sunuser extends Validate{
          protected $rule = [
            'banktype' => 'require',
            'banknumber' => 'require|number',
        ];
        protected $message = [
            'banktype.require' => '收款方式必须填写',
            'banknumber.require' => '账号必须填写',
            'banknumber.number' => '请填写正确格式账号',
            

            
        ];
        protected $scene = [
            'edit' => ['banktype','banknumber'],
            
        ];
	
	

}

