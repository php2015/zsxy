<?php
namespace app\dailishang\controller;

use app\common\model\Product as ProductModel;
use app\common\model\Agent as AgentModel;
use app\common\model\Goods as GoodsModel;
use app\common\model\Agentgoods as AgentgoodsModel;
use app\common\model\Bjurl as BjurlModel;
use app\common\model\User as UserModel;
use app\common\controller\AdminBaseDailishang;
use think\Config;
use think\Db;
use think\Session;
header("content-type:text/html;charset=utf-8");         //设置编码
/**
 * 版本管理
 * Class AdminUser
 * @package app\admin\controller
 */
class Product extends AdminBaseDailishang
{
    protected $product_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->product_model = new ProductModel();
        $this->agent_model = new AgentModel();
        $this->agentgoods_model = new AgentgoodsModel();
        $this->user_model = new UserModel();
        $this->goods_model = new GoodsModel();
        $this->bjurl_model = new BjurlModel();
		
    }

    /**
     * 版本管理
     * @param string $keyword
     * @param int    $page
     * @return mixed
     */
    public function index($page = 1)
    {
	
		$dailishang_id = Session::get('dailishang_id');
        $map = [];
       
      	$map['isdel']=['=', "1"];
      	$map['uid']=['=',$dailishang_id];
         $product_list = $this->product_model
		->alias("a")
		->field("a.*,d.names,c.thumb thumbs")
		->join("__USER__ d","a.uid=d.id ",'LEFT')
		->join("__BJURL__ c","a.bgid=c.id ",'LEFT')
		->where($map)
		
		->order('a.createtime desc,names desc')->paginate(6, false, ['query'=>request()->param()]);
		
		$user=$this->user_model->where('id',$dailishang_id)->find();
		$agent=$this->agent_model->where('id',$user["agent_class"] )->find();
		$isok=0;
		
		
		if($agent["isoem_ewm"])
		{
			$isok=1;
			
		}
		
      	$goods_list=$this->goods_model->where("state","=","1")->where('id','<>',8)->select();
      
      	for($i=0;$i<count($goods_list);$i++)
        {
        	$p=$this->agentgoods_model->where('aid',"=",$agent["id"] )->where('gid',"=",$goods_list[$i]["id"] )->find();
          	if($p)
            {
            	$goods_list[$i]["price"]=$p["price"];
             
            }
        }
      $this->assign("goods_list",$goods_list);
		//dump($goods_list);die;
        return $this->fetch('index', ['product_list' => $product_list ,'isok'=>$isok]);
		
		
    }
	

	
	
	
	
	
    /**
     * 添加版本
     * @return mixed
     */
    public function add()
    {
		$goods_list=$this->goods_model->where("state","=","1")->where('id','<>',8)->select();
		$this->assign("goods_list",$goods_list);
		$bjurl_list=$this->bjurl_model->select();
		$this->assign("bjurl_list",$bjurl_list);
		return $this->fetch();
    }

    /**
     * 保存版本
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            	$dailishang_id = Session::get('dailishang_id');
				if(!$data["a_g_id"])
				{
					 $this->error('请选择一个版本');
				}
				else
				{
					$goods=$this->goods_model->find($data["a_g_id"]);
					if($goods)
					{
						$data["product_name"]=$goods["tname"];
						$data["rename"]=$goods["tname"];
					}
                  
                  if($data["a_g_id"] == 2){
                        if($data["price"] > 50){
                            $this->error('专业版设置金额不能大于50元');
                        }
                    }

                    if($data["a_g_id"] == 3){
                        if($data["price"] > 70){
                            $this->error('高级版设置金额不能大于70元');
                        }
                    }

                    if($data["a_g_id"] == 5){
                        if($data["price"] > 25){
                            $this->error('负债查询设置金额不能大于25元');
                        }
                    }

                    if($data["a_g_id"] == 6){
                        if($data["price"] > 25){
                            $this->error('司法信息检测设置金额不能大于25元');
                        }
                    }

                    if($data["a_g_id"] == 7){
                        if($data["price"] > 25){
                            $this->error('信用额度预估设置金额不能大于25元');
                        }
                    }
					
					if($data["price"]<$goods["price"])
					{
						 $this->error('价格必须高于成本价');
					}else{
						
						$data["createtime"]=time();
						
						$data["uid"]=$dailishang_id;
						if ($this->product_model->allowField(true)->save($data)) {
							$this->success('保存成功');
						} else {
							$this->error('保存失败');
						}
					}
            	}
        }
    }

    /**
     * 编辑版本
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $product = $this->product_model->find($id);
		
		
        return $this->fetch('edit', ['product' => $product]);
    }

    /**
     * 更新版本
     * @param $id
     */
    public function update($id)
    {
	
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Product');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
			
			 
			    $product           = $this->product_model->find($id);
                $product->id       = $id;
                $product->tname = $data['tname'];
                $product->thumb = $data['thumb'];
                $product->price    = $data['price'];
                $product->prices    = $data['prices'];
                $product->marks    = $data['marks'];
                $product->descc    = $data['descc'];
                $product->state    = $data['state'];
				
				
				
				
                if ($product->save() !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
				
            }
        }
		
    }

    /**
     * 删除版本
     * @param $id
     */
    public function delete($id)
    {
			    $product           = $this->product_model->find($id);
                $product->id       = $id;
                $product->isdel = 0;
                if ($product->save() !== false) {
                    $this->success('删除成功');
                } else {
                    $this->error('删除失败');
                }
				
    }
    
	
}