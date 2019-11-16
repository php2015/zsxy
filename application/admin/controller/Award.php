<?php
namespace app\admin\controller;

use app\common\model\Profit as ProfitModel;
use app\common\model\User as UserModel;
use app\common\model\Chaxun as ChaxunModel;
use app\common\controller\AdminBase;
use think\Db;
use think\Session;
use PHPExcel_IOFactory;
use PHPExcel;
/**
 * 奖励明细
 * Class Order
 * @package app\admin\controller
 */
class Award extends AdminBase
{
    protected $profit_model;
    protected function _initialize()
    {
        parent::_initialize();
        $this->profit_model  = new ProfitModel();
        $this->user_model  = new UserModel();
        $this->chaxun_model  = new ChaxunModel();
    }
	
  public function t()
  {
  	 $award_list  = $this->profit_model
		->alias("a")
		->field("a.*,b.names")
		->join("__USER__ b","a.profit_id=b.id","LEFT")->limit(20)
		->order(['a.id' => 'DESC'])->paginate(10, false, ['query'=>request()->param()]);
    dump($award_list);
  }
	public function test($a,$b)
	{
		$map="id>='".$a."' and id <= '".$b."'";
		 $user_list  = $this->user_model
		->alias("a")
		->field("a.id")
		->where($map)->order(['a.id' => 'DESC'])->select();
		$count=$b-$a;
		for($i=0;$i<$count;$i++)
		{
			$this->tongbu($user_list[$i]["id"]);
		}
	}

public function test1($a,$b)
	{
		$map="id>='".$a."' and id <= '".$b."'";
		 $user_list  = $this->user_model
		->alias("a")
		->field("a.id")
		->where($map)->order(['a.id' => 'DESC'])->select();
		$count=$b-$a;
		for($i=0;$i<$count;$i++)
		{
			$this->tongbu1($user_list[$i]["id"]);
		}
	}



	public function tongbu($uid)
	{
		$map="profit_id ='".$uid."' and type != '提现' and type !='退款'";
		//$map="profit_id ='".$uid."'";
		$sum=$this->profit_model->alias("a")->where($map)->sum('a.money');
		$user = $this->user_model->find($uid);
		if(!$sum)
		{
			$sum=0;
		}
		$user["total_achievement"]=$sum;
		dump($uid." ___".$sum);
		$user->save();
		
	}
	
	public function tongbu1($uid)
	{
		$map="uid ='".$uid."'";
		//$map="profit_id ='".$uid."'";
		$count=$this->chaxun_model->alias("a")->where($map)->count('a.id');
		$user = $this->user_model->find($uid);
		if(!$count)
		{
			$count=0;
		}
		$user["pingfeng"]=$count;
		dump($uid." ___".$count);
		$user->save();
		
	}
	
	



	public function tuikuan($id)
	{
		
		$profit = $this->profit_model->find($id);
		if($profit["pid"]==0)
		{
			$profit["pid"]=1;
			$profit->save();
			$data["order_id"]=str_replace('D','T',$profit["order_id"]);
			$data["profit_id"]=$profit["profit_id"];
			$data["ratio"]=$profit["ratio"];
			$data["create_time"]=time();
			$data["money"]=$profit["money"];
			$data["pid"]=1;
			$data["type"]="退款";
			$data["balance"]=$profit["balance"]-$profit["money"];
			$this->profit_model->allowField(true)->save($data);
			$user = $this->user_model->find($data["profit_id"]);
			$user["money"]=$user["money"]-$profit["money"];
			$user["total_achievement"]=$user["total_achievement"]-$profit["money"];
			$user->save();
		}
		$this->success('操作成功');
	}
	
	
    /**
     * 奖励明细
     * @param int    $cid     分类ID
     * @param string $keyword 关键词
     * @param int    $page
     * @return mixed
     */
    public function index()
    {
		$data = $this->request->get();
		$page=@$data["page"];
		$page or $page=1;
        $zao=strtotime(date('Y-m-d',time()));
      	$wan=time();
		$map1=$this->make_where($data);
		if ($map1){
			$map=$map1;
		}else{
			$map=array();
		}
		
     
      $award_list  = $this->profit_model
		->alias("a")
		->field("a.*,b.names,c.names as cname")
		->join("__USER__ b","a.profit_id=b.id","LEFT")
        ->join("__USER__ c","a.uid = c.id","LEFT")
		->where($map)->order(['a.id' => 'DESC'])->paginate(15, false, ['query'=>request()->param()]);
      
       	$zao=strtotime(date('Y-m-d',time()));
      	$wan=time();
		$mapjin=[];
		//dump($zao."___".$wan);
      	$mapjin['a.create_time'] = array(array('>=',$zao),array('<=',$wan));
      	$mapjin['a.type']=array('neq','提现');
      	$mapjin['a.pid']=array('neq','1');
		$sumjin=$this->profit_model->alias("a")->where($mapjin)->sum('a.money');
      
       return $this->fetch('index', ['award_list' => $award_list,'sumjin' => $sumjin]);
      
      
    }
	//SELECT a.names ,b.profit_id,c.names FROM sun_user a,sun_profit b,sun_user c,sun_order d WHERE b.profit_id=a.id AND b.order_id=d.id  AND d.user_id=c.id
	//导出EXCEL
	public function excel(){
		
		$data = $this->request->get();
		$map1=$this->make_where($data);
		$map   = [];
		if ($map1){
			$map=$map1;
		}else{
			$map=[];
		}
       $award_list  = $this->profit_model
		->alias("a")
		->field("a.*,b.names,b.mid,d.names namess")
		->join("__USER__ b","a.profit_id=b.id","LEFT")
		->join("__CHAXUN__ c","a.order_id=c.ordernumber","LEFT")
		->join("__USER__ d","c.uid=d.id","LEFT")
		->where($map)->order(['a.id' => 'DESC'])->select();

		vendor("PHPExcel.PHPExcel");
		vendor("PHPExcel.PHPExcel.Writer.Excel5");
		vendor("PHPExcel.PHPExcel.Writer.Excel2007");
		vendor("PHPExcel.PHPExcel.IOFactory");
		$objPHPExcel=new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', '订单编号')
            ->setCellValue('C1', '提成者')
            ->setCellValue('D1', '提成者编号')
            ->setCellValue('E1', '时间')
            ->setCellValue('F1', '提成金额')
            ->setCellValue('G1', '类型')
            ->setCellValue('H1', '分成后余额')
            ->setCellValue('I1', '下单人');
		
		
		
		if ($award_list){
			$i=2;  //定义一个i变量，目的是在循环输出数据是控制行数
			$count = count($award_list);  //计算有多少条数据
			for ($i = 2; $i <= $count+1; $i++) {
				$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $award_list[$i-2]["id"]);
				$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $award_list[$i-2]["order_id"]);
				$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $award_list[$i-2]["names"]);
				$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $award_list[$i-2]["mid"]);
				$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, date('Y-m-d H:i:s',$award_list[$i-2]["create_time"]));
				$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $award_list[$i-2]["money"]);
				$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $award_list[$i-2]["type"]);
				$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $award_list[$i-2]["balance"]);
				$objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $award_list[$i-2]["namess"]);
			}
		}	
		$objPHPExcel->getActiveSheet()->setTitle('profit');      //设置sheet的名称
        $objPHPExcel->setActiveSheetIndex(0);                   //设置sheet的起始位置
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');   //Excel2003通过PHPExcel_IOFactory的写函数将上面数据写出来
        $PHPWriter = \PHPExcel_IOFactory::createWriter( $objPHPExcel,"Excel2007"); //Excel2007
        header('Content-Disposition: attachment;filename="奖励明细.xlsx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
	}
	public function form(){
		return $this->fetch();
	}
	private function make_where($data){
		$fields=@$data["fields"];
		$types=@$data["types"];
		$keywords=@$data["keyword"];
		$count=count($keywords);
		$where="1=1";
		for($i=0;$i<$count;$i++){
			if ($fields[$i]=="a.create_time"){
                $where.=" and ".$fields[$i]."='".strtotime($keywords[$i])."'";
            }else{
            	if(is_numeric($keywords[$i])){
            		 $where.=" and b.mobile ='".$keywords[$i]."'";
            	}else{
            		 $where.=" and ".$fields[$i]."='".$keywords[$i]."'";
            	}
               
            }
		}
		return $where;
	}
	
}