<?php

namespace accapys;

use think\Exception;
/**
 * 微信支付API异常类
 */
class WxPayException extends Exception {
	public function errorMessage()
	{
		return $this->getMessage();
	}
}
