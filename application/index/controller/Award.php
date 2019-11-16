<?php
namespace app\index\controller;

use app\common\model\Profit as ProfitModel;
use think\Controller;
use think\Db;
use think\Session;
use PHPExcel_IOFactory;
use PHPExcel;

/**
 * 奖励明细
 * Class Order
 * @package app\admin\controller
 */
class Award extends Controller
{
    protected $profit_model;
    protected function _initialize()
    {
        parent::_initialize();
        $this->profit_model  = new ProfitModel();
    }

    /**
     * 奖励明细
     * @param int    $cid     分类ID
     * @param string $keyword 关键词
     * @param int    $page
     * @return mixed
     */
  //   public function index()
  //   {
		// $data = $this->request->get();
		// $page=@$data["page"];
		// $page or $page=1;
		// $map1=$this->make_where($data);
		// if ($map1){
		// 	$map=$map1;
		// }else{
		// 	$map=array();
		// }
  //       $award_list  = $this->profit_model
		// ->alias("a")
		// ->field("a.*,b.names,b.mid,d.names namess")
		// ->join("__USER__ b","a.profit_id=b.id","LEFT")
		// ->join("__CHAXUN__ c","a.order_id=c.ordernumber","LEFT")
		// ->join("__USER__ d","c.uid=d.id","LEFT")
		// ->where($map)->order(['a.id' => 'DESC'])->paginate(15, false, ['query'=>request()->param()]);
  //       return $this->fetch('index', ['award_list' => $award_list]);
  //   }
	//SELECT a.names ,b.profit_id,c.names FROM sun_user a,sun_profit b,sun_user c,sun_order d WHERE b.profit_id=a.id AND b.order_id=d.id  AND d.user_id=c.id
	//导出EXCEL
	public function excel(){
		//dump('11');die;
		//$data = $this->request->get();
		//$kstime=input('kstime');
       //$jstime=input('jstime');
       $uid=input('uid');
		$kstimes=input('kstime');
		$kstimes_s=strtotime($kstimes);
		$jstimes=input('jstime');
		$jstimes_s=strtotime($jstimes);
		// $map1=$this->make_where($data);
		//dump($jstimes_s);die;
		
      $award_list=db('profit')
		->alias("a")
		->field("a.*,b.names,b.mid,CONCAT(LEFT(c.names,1),'**') namess ,c.tel mobile")
		->join("sun_user b","a.profit_id=b.id","LEFT")
		->join("sun_chaxun c","a.order_id=c.ordernumber","LEFT")
		->join("sun_user d","c.uid=d.id","LEFT")
		->where('a.create_time','between',[$kstimes_s, $jstimes_s])->where('a.profit_id','=',$uid)
		->order(['a.id' => 'DESC'])->select();
		$num=count($award_list);
    for($i=0;$i<$num;$i++){
      $award_list[$i]['mobile']=substr_replace($award_list[$i]['mobile'],'***',7,3);
     /* $strlen=mb_strlen($user[$i]['namess']);
      if($strlen > 3 and $strlen < 6){
        $user[$i]['namess']=substr_replace($user[$i]['namess'],'*',3,3);
      }else if($strlen > 6){
        $user[$i]['namess']=substr_replace($user[$i]['namess'],'**',3,10);
      }*/
      
    }
			//dump($award_list);die;
		vendor("PHPExcel.PHPExcel");
		vendor("PHPExcel.PHPExcel.Writer.Excel5");
		vendor("PHPExcel.PHPExcel.Writer.Excel2007");
		vendor("PHPExcel.PHPExcel.IOFactory");
		$objPHPExcel=new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '时间')
            ->setCellValue('B1', '类型')
            ->setCellValue('C1', '用户')
            ->setCellValue('D1', '手机号')
            ->setCellValue('E1', '金额');
		
		
		
		if ($award_list){
			$i=2;  //定义一个i变量，目的是在循环输出数据是控制行数
			$count = count($award_list);  //计算有多少条数据
			for ($i = 2; $i <= $count+1; $i++) {
				$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, date('Y-m-d H:i:s',$award_list[$i-2]["create_time"]));
				$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $award_list[$i-2]["type"]);
				$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $award_list[$i-2]["namess"]);
				$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $award_list[$i-2]["mobile"]);
				$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $award_list[$i-2]["money"]);
			}
		}	
		$objPHPExcel->getActiveSheet()->setTitle('profit');      //设置sheet的名称
        $objPHPExcel->setActiveSheetIndex(0);                   //设置sheet的起始位置
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');   //Excel2003通过PHPExcel_IOFactory的写函数将上面数据写出来
        $PHPWriter = \PHPExcel_IOFactory::createWriter( $objPHPExcel,"Excel2007"); //Excel2007
        header('Content-Disposition: attachment;filename="奖励明细.xlsx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        if($PHPWriter->save("php://output")){; //表示在$path路径下面生成demo.xlsx文件
        	return $this->success('成功','index/allindex/mingxi');
        }
        
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
				switch(intval($types[$i])){
					case 1:
						if ($fields[$i]=="a.create_time"){
							$where.=" and ".$fields[$i]."='".strtotime($keywords[$i])."'";
						}else{
							$where.=" and ".$fields[$i]."='".$keywords[$i]."'";
						}
						break;
					case 2:
						if ($fields[$i]=="a.create_time"){
							$where.=" and ".$fields[$i]." > '".strtotime($keywords[$i])."'";
						}else{
							$where.=" and ".$fields[$i]." > '".$keywords[$i]."'";
						}
						break;
					case 3:
						if ($fields[$i]=="a.create_time"){
							$where.=" and ".$fields[$i]." < '".strtotime($keywords[$i])."'";
						}else{
							$where.=" and ".$fields[$i]." < '".$keywords[$i]."'";
						}
						break;
					case 4:
						if ($fields[$i]!="a.create_time"){
							$where.=" and ".$fields[$i]." LIKE '%".$keywords[$i]."%'";
						}
						break;
                  
				}
		}
		return $where;
	}
	
}