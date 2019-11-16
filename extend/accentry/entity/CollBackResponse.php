<?php


class CollBackResponse {
    var $version;// 版本号
    var $ts;// 时间戳
    var $merCode;// 商户号
    var $nonceStr;// 随机字符串
    var $format;// 数据格式
    var $encryptType;// 加密类型
    var $data;// 业务域
    var $signType;// 签名类型
    var $notifyType;// 通知类型
    var $sign;// 签名域
    
    function __construct( $version, $ts,$merCode ,$nonceStr ,$format ,$encryptType ,$data ,$signType ,$notifyType   ) {
        $this->version = $version;
        $this->ts = $ts;
        $this->merCode = $merCode;
        $this->nonceStr = $nonceStr;
        $this->format = $format;
        $this->encryptType = $encryptType;
        $this->data = $data;
        $this->signType = $signType;
        $this->notifyType = $notifyType;
    }
    
    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return mixed
     */
    public function getTs()
    {
        return $this->ts;
    }

    /**
     * @return mixed
     */
    public function getMerCode()
    {
        return $this->merCode;
    }

    /**
     * @return mixed
     */
    public function getNonceStr()
    {
        return $this->nonceStr;
    }

    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @return mixed
     */
    public function getEncryptType()
    {
        return $this->encryptType;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getSignType()
    {
        return $this->signType;
    }

    /**
     * @return mixed
     */
    public function getNotifyType()
    {
        return $this->notifyType;
    }

    /**
     * @return mixed
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * @param mixed $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @param mixed $ts
     */
    public function setTs($ts)
    {
        $this->ts = $ts;
    }

    /**
     * @param mixed $merCode
     */
    public function setMerCode($merCode)
    {
        $this->merCode = $merCode;
    }

    /**
     * @param mixed $nonceStr
     */
    public function setNonceStr($nonceStr)
    {
        $this->nonceStr = $nonceStr;
    }

    /**
     * @param mixed $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @param mixed $encryptType
     */
    public function setEncryptType($encryptType)
    {
        $this->encryptType = $encryptType;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @param mixed $signType
     */
    public function setSignType($signType)
    {
        $this->signType = $signType;
    }

    /**
     * @param mixed $notifyType
     */
    public function setNotifyType($notifyType)
    {
        $this->notifyType = $notifyType;
    }

    /**
     * @param mixed $sign
     */
    public function setSign($sign)
    {
        $this->sign = $sign;
    }
    
    
    
}



?>