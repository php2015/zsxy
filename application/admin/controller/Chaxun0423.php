<?php
namespace app\admin\controller;

use app\common\model\Chaxun as ChaxunModel;
use app\common\controller\AdminBase;
use think\Db;
use think\Session;
use PHPExcel_IOFactory;
use PHPExcel;
/**
 * 订单管理
 * Class Chaxun
 * @package app\admin\controller
 */
 
class Chaxun extends AdminBase
{
    protected $chaxun_model;
    protected function _initialize()
    {
        parent::_initialize();
        $this->chaxun_model  = new ChaxunModel();
    }

    /**
     * 订单管理
     * @param int    $cid     分类ID
     * @param string $keyword 关键词
     * @param int    $page
     * @return mixed
     */
    public function index($keyword = '', $page = 1,$date1='',$date2='')
    {
         $map = [];
        if ($keyword) {
            $map['a.names'] = ['like', "%{$keyword}%"];
        }
		if ($date2=='') {
			$d2=time();
        }else
		{
			$d2=strtotime($date2);
		}
        if ($date1!='') {
			$d1=strtotime($date1);
            $map['a.dates'] = array(array('>=',$d1),array('<=',$d2));
        }
        $chaxun_list  = $this->chaxun_model
		->alias("a")
		->field("a.`id`,a.`ordernumber`,a.`uid`,b.`names`,d.`agent_name`,a.`dates`,a.`pid`,c.`product_name`,a.`price`,a.`names` as namess,a.`idcard`,a.`tel`,e.names pnames,f.names manames,a.sheng,a.shi")
		->join("__USER__ b","a.uid=b.id","LEFT")
		->join("__PRODUCT__ c","a.pid=c.id","LEFT")
		->join("__AGENT__ d","b.agent_class=d.id","LEFT")
		->join("__USER__ e","b.pid=e.id","LEFT")
		->join("__USER__ f","c.uid=f.id","LEFT")
		->where($map)->order(['a.id' => 'DESC'])->paginate(15, false, ['query'=>request()->param()]);
		$count=$this->chaxun_model->alias("a")->where($map)->count('a.id');
		$sum=$this->chaxun_model->alias("a")->where($map)->sum('a.price');
      	
       	$zao=strtotime(date('Y-m-d',time()));
      	$wan=time();
      	$mapjin['a.dates'] = array(array('>=',$zao),array('<=',$wan));
      
      	$countjin=$this->chaxun_model->alias("a")->where($map)->where($mapjin)->count('a.id');
      
		$sumjin=$this->chaxun_model->alias("a")->where($map)->where($mapjin)->sum('a.price');
      
        return $this->fetch('index', ['chaxun_list' => $chaxun_list, 'keyword' => $keyword, 'date1' => $date1,'date2' => $date2,'count'=>$count,'sum'=>$sum,'countjin'=>$countjin,'sumjin'=>$sumjin]);
      
      
    }

	public function excel($keyword = '',$date1='',$date2=''){
		
		 $map = [];
        if ($keyword) {
            $map['a.names'] = ['like', "%{$keyword}%"];
        }
		if ($date2=='') {
			$d2=time();
        }else
		{
			$d2=strtotime($date2);
		}
        if ($date1!='') {
			$d1=strtotime($date1);
            $map['a.dates'] = array(array('>=',$d1),array('<=',$d2));
        }
       $chaxun_list  = $this->chaxun_model
		->alias("a")
		->field("a.`id`,a.`ordernumber`,a.`uid`,b.`names`,d.`agent_name`,a.`dates`,a.`pid`,c.`product_name`,a.`price`,a.`names` as namess,a.`idcard`,a.`tel`,e.names pnames,f.names manames,a.sheng,a.shi")
		->join("__USER__ b","a.uid=b.id","LEFT")
		->join("__PRODUCT__ c","a.pid=c.id","LEFT")
		->join("__AGENT__ d","b.agent_class=d.id","LEFT")
		->join("__USER__ e","b.pid=e.id","LEFT")
		->join("__USER__ f","c.uid=f.id","LEFT")
		->where($map)->order(['a.id' => 'DESC'])->select();

		vendor("PHPExcel.PHPExcel");
		vendor("PHPExcel.PHPExcel.Writer.Excel5");
		vendor("PHPExcel.PHPExcel.Writer.Excel2007");
		vendor("PHPExcel.PHPExcel.IOFactory");
		$objPHPExcel=new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', '订单编号')
            ->setCellValue('C1', '用户名')
            ->setCellValue('D1', '等级')
            ->setCellValue('E1', '时间')
            ->setCellValue('F1', '类型')
            ->setCellValue('G1', '价格')
            ->setCellValue('H1', '被查询人')
            ->setCellValue('I1', '查询身份证')
            ->setCellValue('J1', '查询电话')
            ->setCellValue('K1', '上级')
            ->setCellValue('L1', '扫谁的码')
            ->setCellValue('M1', '省')
            ->setCellValue('N1', '市');
		
		
		
		if ($chaxun_list){
			$i=2;  //定义一个i变量，目的是在循环输出数据是控制行数
			$count = count($chaxun_list);  //计算有多少条数据
			for ($i = 2; $i <= $count+1; $i++) {
				$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $chaxun_list[$i-2]["id"]);
				$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $chaxun_list[$i-2]["ordernumber"]);
				$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $chaxun_list[$i-2]["names"]);
				$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $chaxun_list[$i-2]["agent_name"]);
				$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, date('Y-m-d H:i:s',$chaxun_list[$i-2]["dates"]));
				$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $chaxun_list[$i-2]["product_name"]);
				$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $chaxun_list[$i-2]["price"]);
				$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $chaxun_list[$i-2]["namess"]);
				$objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $chaxun_list[$i-2]["idcard"]);
				$objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $chaxun_list[$i-2]["tel"]);
				$objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $chaxun_list[$i-2]["pnames"]);
				$objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $chaxun_list[$i-2]["manames"]);
				$objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $chaxun_list[$i-2]["sheng"]);
				$objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $chaxun_list[$i-2]["shi"]);
			}
		}	
		$objPHPExcel->getActiveSheet()->setTitle('查询明细');      //设置sheet的名称
        $objPHPExcel->setActiveSheetIndex(0);                   //设置sheet的起始位置
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');   //Excel2003通过PHPExcel_IOFactory的写函数将上面数据写出来
        $PHPWriter = \PHPExcel_IOFactory::createWriter( $objPHPExcel,"Excel2007"); //Excel2007
        header('Content-Disposition: attachment;filename="查询明细.xlsx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
	}
    /**
     * 添加订单
     * @return mixed
     */
    public function add()
    {
        //管理员
		$admin_list=Db::name("admin_user")->select();
		$this->assign("admin_list",$admin_list);
		//商品
		$product_list=Db::name("product")->select();
		$this->assign("product_list",$product_list);
		//用户
		$user_list=Db::name("user")->field("id,names")->select();
		$this->assign("user_list",$user_list);
		return $this->fetch();
    }

    /**
     * 保存订单
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $validate_result = $this->validate($data, 'Chaxun');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                
				$data["create_time"]=strtotime($data["create_time"]);
				$data["operator"]=Session::get('admin_id');
				$result=$this->chaxun_model->allowField(true)->save($data);
				if ($result) {
                    //分成
					$chaxun_id=$this->chaxun_model->getLastInsID();
					$this->buy($data,$chaxun_id);
					$this->success('保存成功');
                } else {
                    $this->error('保存失败');
                }
            }
        }
    }

    /**
     * 编辑订单
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $chaxun = $this->chaxun_model->find($id);
		//管理员
		$admin_list=Db::name("admin_user")->select();
		$this->assign("admin_list",$admin_list);
		//商品
		$product_list=Db::name("product")->select();
		$this->assign("product_list",$product_list);
		//用户
		$user_list=Db::name("user")->field("id,names")->select();
		$this->assign("user_list",$user_list);

        return $this->fetch('edit', ['chaxun' => $chaxun]);
    }

	/**
     * 查看详情
     * @return userlist
     */
	//查询结果
    public function xiangqing()
    {
      $dingdanids=input('id');
      //$dingdanids=base64_decode(base64_decode($dingdanid));
      //$dingdanids=8697;
      $session_uid=session('uid');
      $this->assign("session_uid", $session_uid);
      $chaxun=db('chaxun')->where('id','=',$dingdanids)->find();
      $this->assign("dingdanids", $dingdanids);
       $this->assign("chaxun", $chaxun);
      //个人信息
      $op=substr_replace($chaxun['tel'],'****',3,4);
      $opnames=substr_replace($chaxun['names'],'*',3,3);
      $opcard=substr_replace($chaxun['idcard'],'********',6,8);
      $user=db('user')->where("id","=",$chaxun['ma_id'])->find();
      $dizhi=db('user')->where("mobile","=",$chaxun['tel'])->find();
      $agent=db('agent')->where("id","=",$user['agent_class'])->find();
      $this->assign("agent", $agent);
      $this->assign("dizhi", $dizhi);
      $this->assign("op", $op);
      $this->assign("opnames", $opnames);
      $this->assign("opcard", $opcard);
      $product=db('product')->where("id","=",$chaxun['pid'])->find();
      $priceid=$product['a_g_id'];
      $priceid=3;
      $this->assign("priceid", $priceid);
      //百融
      $bairo=db('bairo')->where('chaxunid','=',$chaxun['id'])->find();
      $temp_res_arr=$bairo['json'];
      //$matches=preg_match_all('/'.$find.'/', $temp_res_arr);
      $temp_res = json_decode($temp_res_arr,true);
      $temp_res['scorecashon']=$this->pingfen($temp_res);
      $this->assign("temp_res", $temp_res);
      //在网时长
      $tianyan_phone=$bairo['tianyan_phone'];
      $phone = json_decode($tianyan_phone,true);
      if(isset($phone['result'])){
      $all_user_phone=$phone['result'];
      }else{
        $all_user_phone=array();
      }
      //$all_user_phone = $phone['result'];
      $this->assign("all_user_phone", $all_user_phone);
      //实名制
      $tianyan_mobile=$bairo['tianyan_mobile'];
      $mobile = json_decode($tianyan_mobile,true);
      //$all_user_mobile = $mobile['result'];
       if(isset($mobile['result'])){
      $all_user_mobile=$mobile['result'];
      }else{
        $all_user_mobile=array();
      }
      $this->assign("all_user_mobile", $all_user_mobile);
      //个人不良信息
      $tianyan_geren=$bairo['tianyan_geren'];
      $all_user_geren = json_decode($tianyan_geren,true);
      $this->assign("all_user_geren", $all_user_geren);
      //dump($all_user_geren);die;
      if(isset($all_user_geren['result']['lawSuitInfo']['allList'])){
      $all_user_geren_alllist=$all_user_geren['result']['lawSuitInfo']['allList'];
      }else{
        $all_user_geren_alllist=array();
      }
      //dump($all_user_geren_alllist);die;
      $this->assign("all_user_geren_alllist", $all_user_geren_alllist);
      //金融黑名单
      $tianyan_jinro=$bairo['tianyan_jinro'];
      $jinro = json_decode($tianyan_jinro,true);
      if(isset($jinro['result'])){
      $all_user_jinro=$jinro['result'];
      }else{
        $all_user_jinro=array();
      }
     // $all_user_jinro = $jinro['result'];
      $this->assign("all_user_jinro", $all_user_jinro);
      //多头注册
      $tianyan_duotou=$bairo['tianyan_duotou'];
      $duotou = json_decode($tianyan_duotou,true);
      //省市
      if(isset($duotou['result']['province'])){
            if(isset($duotou['result']['city'])){
                  $sheng_city['sheng']=$duotou['result']['province'];
                  $sheng_city['shi']=$duotou['result']['city'];
            }else{
                  $sheng_city['shi']=$duotou['result']['city'];
            }
            $up_chaxun=db('chaxun')->where('id','=',$dingdanids)->update($sheng_city);
      }else{
            //查询查询人的信息
            $up_chaxun=db('user')->where("mobile","=",$chaxun['tel'])->find();
            $user_up['sheng']=$up_chaxun['province'];
            $user_up['shi']=$up_chaxun['city'];
            $up_chaxun=db('chaxun')->where('id','=',$dingdanids)->update($user_up);
      }
      $this->assign("duotou", $duotou);
       if(isset($duotou['result']['detail'])){
      $doutuo_s=$duotou['result']['detail'];
      }else{
        $doutuo_s=array();
      }
      $num=count($doutuo_s);
      if($num == 0){
        $all_user_duotou_zhuce=array();
         $this->assign("all_user_duotou_zhuce", $all_user_duotou_zhuce);
        $all_user_duotou_shengqin=array();
        $this->assign("all_user_duotou_shengqin", $all_user_duotou_shengqin);
        $all_user_duotou_fangkuan=array();
        $this->assign("all_user_duotou_fangkuan", $all_user_duotou_fangkuan);
        $all_user_duotou_bohui=array();
        $this->assign("all_user_duotou_bohui", $all_user_duotou_bohui);
        $all_user_duotou_yuqi=array();
        $this->assign("all_user_duotou_yuqi", $all_user_duotou_yuqi);
        $all_user_duotou_qiankaun=array();
        $this->assign("all_user_duotou_qiankaun", $all_user_duotou_qiankaun);
      }
        $all_user_duotou_zhuce=array();
      $all_user_duotou_shengqin=array();
      $all_user_duotou_fangkuan=array();
       $all_user_duotou_bohui=array();
       $all_user_duotou_yuqi=array();
         $all_user_duotou_qiankaun=array();
      for($i=0;$i<$num;$i++){
        if($doutuo_s[$i]['type']=='TYD002'){
            $all_user_duotou_zhuce=$doutuo_s[$i]['data'];
          }
        if($doutuo_s[$i]['type']=='TYD004'){
            $all_user_duotou_shengqin=$doutuo_s[$i]['data'];
        }
        if($doutuo_s[$i]['type']=='TYD007'){
            $all_user_duotou_fangkuan=$doutuo_s[$i]['data'];
        }
        if($doutuo_s[$i]['type']=='TYD009'){
            $all_user_duotou_bohui=$doutuo_s[$i]['data'];
        }
        if($doutuo_s[$i]['type']=='TYD012'){
            $all_user_duotou_yuqi=$doutuo_s[$i]['data'];
        }
        if($doutuo_s[$i]['type']=='TYD013'){
            $all_user_duotou_qiankaun=$doutuo_s[$i]['data'];
        } 
      }
      $this->assign("all_user_duotou_zhuce", $all_user_duotou_zhuce);
      $this->assign("all_user_duotou_shengqin", $all_user_duotou_shengqin);
      $this->assign("all_user_duotou_fangkuan", $all_user_duotou_fangkuan);
      $this->assign("all_user_duotou_bohui", $all_user_duotou_bohui);
      $this->assign("all_user_duotou_yuqi", $all_user_duotou_yuqi);
      $this->assign("all_user_duotou_qiankaun", $all_user_duotou_qiankaun);
        //通话记录
        $tianyan_tonghua=$bairo['tianyan_tonghua'];
         $ress=str_replace("\\","",$tianyan_tonghua); 
         //$resss_1=substr($ress, 1, -1);
         $tianyan_tonghuas=json_decode($ress);
         if(isset($tianyan_tonghuas->success)){
            $su=$tianyan_tonghuas->success;
         }else{
          $su=false;
         }
         //dump($tianyan_tonghuas);die;
         if($su == true){
            $tonghuas=$tianyan_tonghuas->data;
            $tonghua_pd=1;
          }else{
              $tonghuas=array();
              $tonghua_pd=0;
         }
         //dump($tonghuas->active_degree_detail->no_call_day_1m);die;
         //$this->assign("tianyan_tonghuas", $tianyan_tonghuas);
         $this->assign("tonghuas", $tonghuas);
         $this->assign("tonghua_pd", $tonghua_pd);
            if(isset($tianyan_tonghuas->data->friend_circle->call_num_top3_3m)){
                $call_num_top3_3m=$tianyan_tonghuas->data->friend_circle->call_num_top3_3m;
              }else{
                $call_num_top3_3m=array();
              }
                //dump($call_num_top3_3m[0]->peer_number);die;
                $this->assign("call_num_top3_3m", $call_num_top3_3m);
            //dump($tonghuas->friend_circle->active_degree_detail->no_call_day_1m);die;
             if(isset($tianyan_tonghuas->data->friend_circle->call_num_top3_6m)){
                $call_num_top3_6m=$tianyan_tonghuas->data->friend_circle->call_num_top3_6m;
                }else{
                  $call_num_top3_6m=array();
                }
                $this->assign("call_num_top3_6m", $call_num_top3_6m);
                //dump($call_num_top3_6m);die;
             if(isset($tianyan_tonghuas->data->friend_circle->call_contact_detail)){
                $call_contact_detail=$tianyan_tonghuas->data->friend_circle->call_contact_detail;
              }else{
                $call_contact_detail=array();
                $call_contact_detail_s=array();
              }
                $nums=count($call_contact_detail);
               $shuliang= $agent['nums'];
                for($a=0;$a<$nums;$a++){
                    if($a<$shuliang){
                        $call_contact_detail_s[$a]=$call_contact_detail[$a];
                    }
                }
                $this->assign("call_contact_detail_s", $call_contact_detail_s);
                //dump($call_contact_detail_s);die;
            //dump($tonghuas);die;
        ///dump($tianyan_tonghuas->success);dump($tianyan_tonghuas);die;
        // $ress=str_replace("\\","",$res); 
        //  $resss_1=substr($ress, 1, -1);
        //  $gr1=json_decode($resss_1);
      //dump($doutuo_s);die;
      return $this->fetch('xiangqing');
    }
     public function pingfen($temp_res)
    {
        if(isset($temp_res['als_m12_id_bank_allnum']))
        {
              if(isset($temp_res['als_m12_id_nbank_allnum']))
              {
                  $max=$temp_res['als_m12_id_bank_allnum'] + $temp_res['als_m12_id_nbank_allnum'];
              }else
              {
                  $max=$temp_res['als_m12_id_bank_allnum'];
              }
        }else
        {
              if(isset($temp_res['als_m12_id_nbank_allnum']))
              {
                  $max=$temp_res['als_m12_id_nbank_allnum'];
              }else
              {
                $max=0;
              }
        }
            
                if(!empty($max))
              {
                $fen=100 -$max -5;
                if($fen<28)
                {
                  $fen=28;
                }
              }else
              {
                $fen=95;
              }
         return $fen;
    }
    /**
     * 更新订单
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $validate_result = $this->validate($data, 'Chaxun');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
				$chaxun_info=$this->chaxun_model->where(array("id"=>$id))->find();
				$data["create_time"]=strtotime($data["create_time"]);
				if ($this->chaxun_model->allowField(true)->save($data, $id) !== false) {
                    //先退分成
					$this->back($chaxun_info,$id);
					//再更新本次分成
					$this->buy($data,$id);
					$this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
            }
        }
    }

    /**
     * 删除订单
     * @param int   $id
     * @param array $ids
     */
    public function delete($id = 0)
    {
        if ($id) {
            $chaxun_info=$this->chaxun_model->where(array("id"=>$id))->find();
			if ($this->chaxun_model->destroy($id)) {
                //退掉本次分成
				$this->back($chaxun_info,$id);
				$this->success('删除成功，该单上级 及 二级上级分成同步扣减');
            } else {
                $this->error('删除失败');
            }
        } else {
            $this->error('请选择需要删除的订单');
        }
    }
	//处理分成流程
	private function buy($data,$chaxun_id){
		$user_info=Db::name("user")->where(array("id"=>$data["user_id"]))->find();
		if ($user_info["pid"]){
			$up_user_info=Db::name("user")->where(array("id"=>$user_info["pid"]))->find();
			$up_user_agent=Db::name("agent")->where(array("id"=>$up_user_info["agent_class"]))->find();
			if ($up_user_agent){
				//更新上级提成
				$up_user_money=$data["reality_price"]*$up_user_agent["ratio1"];
				$save=array();
				$save["chaxun_id"]=$chaxun_id;
				$save["profit_id"]=$up_user_info["id"];
				$save["ratio"]=$up_user_agent["ratio1"];
				$save["create_time"]=$data["create_time"];
				$save["money"]=$up_user_money;
				$save["balance"]=$up_user_info["money"]+$up_user_money;
				$save["type"]="一级奖励";
				$save["cid"]="1";
				if($up_user_money>0)
				{
				Db::name("profit")->insert($save);
				}
				$save=array();
				$save["money"]=$up_user_info["money"]+$up_user_money;
				Db::name("user")->where(array("id"=>$up_user_info["id"]))->update($save);
				unset($save);
			}
			if ($up_user_info["pid"]){
				$second_user_info=Db::name("user")->where(array("id"=>$up_user_info["pid"]))->find();
				$second_user_agent=Db::name("agent")->where(array("id"=>$second_user_info["agent_class"]))->find();
				if ($second_user_agent){
					//更新二级上级提成
					$second_user_money=$data["reality_price"]*$second_user_agent["ratio2"];
					$save=array();
					$save["chaxun_id"]=$chaxun_id;
					$save["profit_id"]=$second_user_info["id"];
					$save["ratio"]=$second_user_agent["ratio2"];
					$save["create_time"]=$data["create_time"];
					$save["money"]=$second_user_money;
					$save["balance"]=$second_user_info["money"]+$second_user_money;
					$save["type"]="二级奖励";
					$save["cid"]="1";
					if($up_user_money>0)
					{
					Db::name("profit")->insert($save);
					}
					$save=array();
					$save["money"]=$second_user_info["money"]+$second_user_money;
					Db::name("user")->where(array("id"=>$second_user_info["id"]))->update($save);
					unset($save);
				}
			}
			//团队奖励开始
			$this->team($data["create_time"],$chaxun_id,$data["price"],$data["reality_price"],$up_user_info["id"],0,0,0,0);
			$this->success('成功');
		}
	}
	/*
	//退回分成流程
	private function back($data,$chaxun_id){
		$user_info=Db::name("user")->where(array("id"=>$data["user_id"]))->find();
		if ($user_info["pid"]){
			$up_user_info=Db::name("user")->where(array("id"=>$user_info["pid"]))->find();
			$up_user_agent=Db::name("agent")->where(array("id"=>$up_user_info["agent_class"]))->find();
			if ($up_user_agent){
				//更新上级提成
				$up_user_money=$data["reality_price"]*$up_user_agent["ratio1"];
				$save=array();
				$save["chaxun_id"]=$chaxun_id;
				$save["profit_id"]=$up_user_info["id"];
				$save["ratio"]=$up_user_agent["ratio1"];
				$save["create_time"]=time();
				$save["money"]=-$up_user_money;
				$save["balance"]=$up_user_info["money"];
				$save["type"]="退回一级奖励";
				$save["cid"]="0";
				Db::name("profit")->insert($save);
				$save=array();
				$save["money"]=$up_user_info["money"]-$up_user_money;
				Db::name("user")->where(array("id"=>$up_user_info["id"]))->update($save);
				unset($save);
			}
			if ($up_user_info["pid"]){
				$second_user_info=Db::name("user")->where(array("id"=>$up_user_info["pid"]))->find();
				$second_user_agent=Db::name("agent")->where(array("id"=>$second_user_info["agent_class"]))->find();
				if ($second_user_agent){
					//更新二级上级提成
					$second_user_money=$data["reality_price"]*$second_user_agent["ratio2"];
					$save=array();
					$save["chaxun_id"]=$chaxun_id;
					$save["profit_id"]=$second_user_info["id"];
					$save["ratio"]=$second_user_info["ratio2"];
					$save["create_time"]=time();
					$save["money"]=-$second_user_money;
					$save["balance"]=$second_user_info["money"];
					$save["type"]="退回二级奖励";
					$save["cid"]="0";
					Db::name("profit")->insert($save);
					$save=array();
					$save["money"]=$second_user_info["money"]-$second_user_money;
					Db::name("user")->where(array("id"=>$second_user_info["id"]))->update($save);
					unset($save);
				}
			}
		}
	}
	*/
	//新退回流程
	private function back($data,$chaxun_id){
		$award_list=Db::name("profit")->where(array("chaxun_id"=>$chaxun_id))->select();
		
		foreach($award_list as $item){
			//更新退回
			unset($item["id"]);
			$user_info=Db::name("user")->where(array("id"=>$item["profit_id"]))->find();
			$save=array();
			$save["money"]=$user_info["money"]-$item["money"];
			$save["total_achievement"]=$user_info["total_achievement"];
			Db::name("user")->where(array("id"=>$user_info["id"]))->update($save);
			unset($save);
			
			
			//管锐修改，上面的余额已经改过来了，我只需要删除该订单对应的就可以了
			$item["money"]=-$item["money"];
			$item["type"]="退回".$item["type"];
			$item["cid"]=0;
			$item["balance"]=$user_info["money"]+$item["money"];
			Db::name("profit")->insert($item);
			
			
		}
		//Db::name("profit")->where(array("chaxun_id"=>$chaxun_id))->delete();
	}
	
	
	/*
	private function back($data,$chaxun_id){
		$award_list=Db::name("profit")->where(array("chaxun_id"=>$chaxun_id))->select();
		
		foreach($award_list as $item){
			//更新退回
			unset($item["id"]);
			$user_info=Db::name("user")->where(array("id"=>$item["profit_id"]))->find();
			$save=array();
			$save["money"]=$user_info["money"]-$item["money"];
			$save["total_achievement"]=$user_info["total_achievement"]-$data["price"];
			Db::name("user")->where(array("id"=>$user_info["id"]))->update($save);
			unset($save);
			$profit=$this->profit_model->where(array("id"=>$item["id"]))->find();
			if ($this->chaxun_model->destroy($id)) {
		
			
		}
		      
	}
	*/
	//团队奖励
	/*
	*chaxun_id 						订单ID
	*price 							业绩金额
	*real_price 					实收金额
	*parent_id 						上级ID
	*is_level 						平级奖励是否占用
	*is_up 							封顶奖励是否占用
	*front_ratio					前一级比率
	*front_total_achievement		前一级总业绩
	*/
	private function team($times,$chaxun_id,$price,$real_price,$parent_id,$is_level,$is_up,$front_ratio,$front_total_achievement){
		//提取用户信息
		$user_info=Db::name("user")->where(array("id"=>$parent_id))->find();
		//取小于DESC 10的用户参与分成
		$user_agent=Db::name("agent")->where(array("id"=>$user_info["agent_class"],"rank"=>array("lt",10)))->find();
		if ($user_agent){
			//判断当前用户层级
			if ($user_info["total_achievement"]>50000000){
				$team_ratio="team_ratio6";
			}elseif($user_info["total_achievement"]>24000000){
				$team_ratio="team_ratio5";
			}elseif($user_info["total_achievement"]>12000000){
				$team_ratio="team_ratio4";
			}elseif($user_info["total_achievement"]>6000000){
				$team_ratio="team_ratio3";
			}elseif($user_info["total_achievement"]>2000000){
				$team_ratio="team_ratio2";
			}else{
				$team_ratio="team_ratio1";
			}
			//获取当前分成比率
			$user_ratio=$user_agent[$team_ratio];
			if ($user_ratio>$front_ratio){
				//进行分成
				$current_ratio=$user_ratio-$front_ratio;
				$addition_money=$real_price*$current_ratio;
				$data=array();
				$data["chaxun_id"]=$chaxun_id;
				$data["profit_id"]=$parent_id;
				$data["ratio"]=$current_ratio;
				$data["create_time"]=$times;
				$data["money"]=$addition_money;
				$data["type"]="团队奖励";
				$data["cid"]=1;
				$data["balance"]=$user_info["money"]+$addition_money;
				if($addition_money>0)
				{
					Db::name("profit")->insert($data);
				}
				$save=array();
				$save["money"]=$user_info["money"]+$addition_money;
				Db::name("user")->where(array("id"=>$user_info["id"]))->update($save);
				//更新参数
				$front_ratio=$user_ratio;
			}else{
				//是否平级奖
				if (!$is_level){
					//得3%平级奖
					$current_ratio=0.03;
					$addition_money=$real_price*$current_ratio;
					$data=array();
					$data["chaxun_id"]=$chaxun_id;
					$data["profit_id"]=$parent_id;
					$data["ratio"]=$current_ratio;
					$data["create_time"]=$times;
					$data["money"]=$addition_money;
					$data["type"]="团队奖励-首次平级";
					$data["cid"]=1;
					$data["balance"]=$user_info["money"]+$addition_money;
					if($addition_money>0)
					{
						Db::name("profit")->insert($data);
					}
					$save=array();
					$save["money"]=$user_info["money"]+$addition_money;
					Db::name("user")->where(array("id"=>$user_info["id"]))->update($save);
					//更新参数
					$is_level=1;
				}else{
					//平级奖与顶级奖不可兼得
					//是否顶级奖
					if ($team_ratio=="team_ratio6"){
						if (!$is_up){
							if (($user["total_achievement"]-$front_total_achievement)>20000000){
								//得4%顶级奖
								$current_ratio=0.04;
								$addition_money=$real_price*$current_ratio;
								$data=array();
								$data["chaxun_id"]=$chaxun_id;
								$data["profit_id"]=$parent_id;
								$data["ratio"]=$current_ratio;
								$data["create_time"]=$times;
								$data["money"]=$addition_money;
								$data["type"]="团队奖励-首次顶级";
								$data["cid"]=1;
								$data["balance"]=$user_info["money"]+$addition_money;
								if($addition_money>0)
								{
								Db::name("profit")->insert($data);
								}
								$save=array();
								$save["money"]=$user_info["money"]+$addition_money;
								Db::name("user")->where(array("id"=>$user_info["id"]))->update($save);
								//更新参数
								$is_up=1;
							}
						}
					}
				}
			}
		}
		//进行业绩统计
		$front_total_achievement=$user_info["total_achievement"];
		$save=array();
		$save["total_achievement"]=$user_info["total_achievement"]+$price;
		Db::name("user")->where(array("id"=>$user_info["id"]))->update($save);
		if ($user_info["pid"]){
			//下一次循环
			$this->team($times,$chaxun_id,$price,$real_price,$user_info["pid"],$is_level,$is_up,$front_ratio,$front_total_achievement);
		}
		
	}
}