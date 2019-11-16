<?php

class SynchronousResponse{
    
    var $date;//业务
    var $sign;//签名
    var $respCode;//响应代码 (000000:成功 ,999999:异常 )
    var $respMsg;//响应描述

    function __construct(){
        $respCode = '000000';
        $respMsg = '成功';
    }
    
    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * @return mixed
     */
    public function getRespCode()
    {
        return $this->respCode;
    }

    /**
     * @return mixed
     */
    public function getRespMsg()
    {
        return $this->respMsg;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @param mixed $sign
     */
    public function setSign($sign)
    {
        $this->sign = $sign;
    }

    /**
     * @param mixed $respCode
     */
    public function setRespCode($respCode)
    {
        $this->respCode = $respCode;
    }

    /**
     * @param mixed $respMsg
     */
    public function setRespMsg($respMsg)
    {
        $this->respMsg = $respMsg;
    }
    
    
    
}

?>