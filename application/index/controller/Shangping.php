<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Session;
class Shangping extends Controller
{   
    
    //操作说明
    public function index()
    {
      
        return $this->fetch();
    }
	
	# 商品详细
	public function detail()
	{
	  
	    return $this->fetch();
	}
   
	# 购物车
	public function car()
	{
	  
	    return $this->fetch();
	}
	
	# 订单
	public function order()
	{
	  
	    return $this->fetch();
	}
	
	# 提交订单
	public function confirmOrder()
	{
	  
	    return $this->fetch();
	}
	
	# 我的
	public function me()
	{
	  
	    return $this->fetch();
	}
}