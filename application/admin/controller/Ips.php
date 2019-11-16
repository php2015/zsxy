<?php
namespace app\admin\controller;

use app\common\model\Ips as IpsModel;
use app\common\model\Fangwen as FangwenModel;
use app\common\controller\AdminBase;
use think\Db;
use think\Session;
use PHPExcel_IOFactory;
use PHPExcel;

/**
 * 奖励明细
 * 	
 * @package app\admin\controller
 */
class Ips extends AdminBase
{
    protected $ips_model;
    protected $fangwen_model;
    protected function _initialize()
    {
        parent::_initialize();
        $this->ips_model  = new IpsModel();
        $this->fangwen  = new FangwenModel();
    }
	
   
    public function index($date1='',$date2='',$page = 1)
    {
		$where="";
		if ($date2=='') {
			$d2=time();
			$where="and a.dates <='".$d2."' ";
        }else
		{
			$d2=strtotime($date2);
			$where="and a.dates <='".$d2."' ";
		}
        if ($date1!='') {
			$d1=strtotime($date1);
            $map['a.dates'] = array(array('>=',$d1),array('<=',$d2));
			$where="and a.dates >='".$d1."' and a.dates <='".$d2."' ";
        }
		
		
		$sql1="SELECT  id,pnames names,GROUP_CONCAT(state,'_',ucount,'人') marks FROM (SELECT b.`id`,b.`pnames`,COUNT(a.uid) ucount,a.`state` FROM sun_ips a,sun_user b WHERE a.`uid`=b.`id` AND a.`uid`!=0 ";
		
		$sql2=" GROUP BY b.`pnames`,a.`state` ORDER BY uid,state) c GROUP BY c.id";
		$fangwenlist=Db::query($sql1.$where.$sql2);
		
		return $this->fetch('index', ['ips_list' => $fangwenlist,'date1' => $date1,'date2' => $date2]);
    }
	
	
	
	//导出EXCEL
	public function excel(){
		
		$data = $this->request->get();
		$map=array();
		$date1=@$data["date1"];
		$date2=@$data["date2"];
		$map = [];
		
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
       $ips_list  = $this->ips_model
		->alias("a")
		->field("b.id,b.names,COUNT(a.uid) ucount,a.state")
		->join("__USER__ b","a.uid=b.id","LEFT")
		->group('a.uid,a.state')
		->where($map)->order(['a.id' => 'DESC'])->select();

		vendor("PHPExcel.PHPExcel");
		vendor("PHPExcel.PHPExcel.Writer.Excel5");
		vendor("PHPExcel.PHPExcel.Writer.Excel2007");
		vendor("PHPExcel.PHPExcel.IOFactory");
		$objPHPExcel=new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '用户ID')
            ->setCellValue('B1', '姓名')
            ->setCellValue('C1', '人数')
            ->setCellValue('D1', '是否注册');
           
		
		
		
		if ($ips_list){
			$i=2;  //定义一个i变量，目的是在循环输出数据是控制行数
			$count = count($ips_list);  //计算有多少条数据
			for ($i = 2; $i <= $count+1; $i++) {
				
				if($ips_list[$i-2]["state"]=="0")
				{
					$ips_list[$i-2]["state"]="浏览量";
				}
				if($ips_list[$i-2]["state"]=="1")
				{
					$ips_list[$i-2]["state"]="注册量";
				}
				$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $ips_list[$i-2]["id"]);
				$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $ips_list[$i-2]["names"]);
				$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $ips_list[$i-2]["ucount"]);
				$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $ips_list[$i-2]["state"]);
			}
		}	
		$objPHPExcel->getActiveSheet()->setTitle('ips');      //设置sheet的名称
        $objPHPExcel->setActiveSheetIndex(0);                   //设置sheet的起始位置
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');   //Excel2003通过PHPExcel_IOFactory的写函数将上面数据写出来
        $PHPWriter = \PHPExcel_IOFactory::createWriter( $objPHPExcel,"Excel2007"); //Excel2007
        header('Content-Disposition: attachment;filename="统计报表.xlsx"');
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
				switch(intval($types[$i])){
					case 1:
						if ($fields[$i]=="a.dates"){
							$where.=" and ".$fields[$i]."='".strtotime($keywords[$i])."'";
						}else{
							$where.=" and ".$fields[$i]."='".$keywords[$i]."'";
						}
						break;
					case 2:
						if ($fields[$i]=="a.dates"){
							$where.=" and ".$fields[$i]." > '".strtotime($keywords[$i])."'";
						}else{
							$where.=" and ".$fields[$i]." > '".$keywords[$i]."'";
						}
						break;
					case 3:
						if ($fields[$i]=="a.dates"){
							$where.=" and ".$fields[$i]." < '".strtotime($keywords[$i])."'";
						}else{
							$where.=" and ".$fields[$i]." < '".$keywords[$i]."'";
						}
						break;
					case 4:
						if ($fields[$i]!="a.dates"){
							$where.=" and ".$fields[$i]." LIKE '%".$keywords[$i]."%'";
						}
						break;
                  
				}
		}
		return $where;
	}
	
}