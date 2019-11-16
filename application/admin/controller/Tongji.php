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
class Tongji extends AdminBase
{
    protected $ips_model;
    protected $fangwen_model;
    protected function _initialize()
    {
        parent::_initialize();
        $this->ips_model  = new IpsModel();
        $this->fangwen  = new FangwenModel();
    }
	//统计
	public function index($date1='',$date2='')
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
		//SELECT pnames,kname,LEFT(marks, LOCATE(',',marks)-1) PV,RIGHT(marks, LOCATE(',',marks)-1)  UV FROM (SELECT d.pnames,d.kname,GROUP_CONCAT(ucount) marks FROM (SELECT b.`id`,c.kname ,b.`pnames`,a.`state`,COUNT(a.id) ucount FROM sun_ips a,sun_user b,sun_kouzi c WHERE a.kid=c.id  AND a.`uid`=b.`id` AND a.`uid`!=0 AND a.state NOT IN ('浏览量','注册量') GROUP BY b.`pnames`,a.state,c.`kname` ORDER BY state DESC) dGROUP BY pnames,kname)e
		
$sql1="SELECT pnames,kname,LEFT(marks, LOCATE(',',marks)-1) PV,RIGHT(marks,LENGTH(marks)-LOCATE(',',marks)) UV FROM (SELECT d.pnames,d.kname,GROUP_CONCAT(ucount) marks FROM (SELECT b.`id`,c.kname ,b.`pnames`,a.`state`,COUNT(a.id) ucount FROM sun_ips a,sun_user b,sun_kouzi c WHERE a.kid=c.id  AND a.`uid`=b.`id` AND a.`uid`!=0 AND a.state NOT IN ('浏览量','注册量')";
$sql2=" GROUP BY b.`pnames`,a.state,c.`kname` ORDER BY state DESC) d GROUP BY pnames,kname )e";
		
		$tongjilist=Db::query($sql1.$where.$sql2);
		
		$list=Array();
		for($i=0;$i<count($tongjilist);$i++)
		{
			$l=Array();
			$l['id']=$i+1;
			$l['pnames']=$tongjilist[$i]['pnames'];
			$l['kname']=$tongjilist[$i]['kname'];
			$l['PV']=$tongjilist[$i]['PV']?$tongjilist[$i]['PV'].'次': '1次';
			
			$l['UV']=$tongjilist[$i]['UV']?$tongjilist[$i]['UV'].'次': '1次';
			$list[$i]=$l;
		}
		if(count($list)<1)
		{
			$list[0]['kname']='';
			$list[0]['pnames']='';
			$list[0]['id']='';
			$list[0]['PV']='';
			$list[0]['UV']='';
		}
		
		
		return $this->fetch('index', ['list' => $list,'date1' => $date1,'date2' => $date2]);
		
	}
   
   //按口子统计
   
   public function kouzi($date1='',$date2='')
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
		//SELECT pnames,kname,LEFT(marks, LOCATE(',',marks)-1) PV,RIGHT(marks, LOCATE(',',marks)-1)  UV FROM (SELECT d.pnames,d.kname,GROUP_CONCAT(ucount) marks FROM (SELECT b.`id`,c.kname ,b.`pnames`,a.`state`,COUNT(a.id) ucount FROM sun_ips a,sun_user b,sun_kouzi c WHERE a.kid=c.id  AND a.`uid`=b.`id` AND a.`uid`!=0 AND a.state NOT IN ('浏览量','注册量') GROUP BY b.`pnames`,a.state,c.`kname` ORDER BY state DESC) dGROUP BY pnames,kname)e
		
$sql1="SELECT kname,LEFT(marks, LOCATE(',',marks)-1) PV,RIGHT(marks,LENGTH(marks)-LOCATE(',',marks)) UV FROM (SELECT d.kname,GROUP_CONCAT(ucount) marks FROM (SELECT b.`id`,c.kname ,a.`state`,COUNT(a.id) ucount FROM sun_ips a,sun_user b,sun_kouzi c WHERE a.kid=c.id  AND a.`uid`=b.`id` AND a.`uid`!=0 AND a.state NOT IN ('浏览量','注册量')";
$sql2=" GROUP BY a.state,c.`kname` ORDER BY state DESC) d GROUP BY kname )e";
		
		$tongjilist=Db::query($sql1.$where.$sql2);
		
		$list=Array();
		for($i=0;$i<count($tongjilist);$i++)
		{
			$l=Array();
			$l['id']=$i+1;
			$l['kname']=$tongjilist[$i]['kname'];
			$l['PV']=$tongjilist[$i]['PV']?$tongjilist[$i]['PV'].'次': '1次';
			
			$l['UV']=$tongjilist[$i]['UV']?$tongjilist[$i]['UV'].'次': '1次';
			$list[$i]=$l;
		}
		if(count($list)<1)
		{
			$list[0]['kname']='';
			$list[0]['pnames']='';
			$list[0]['id']='';
			$list[0]['PV']='';
			$list[0]['UV']='';
		}
		
			$list[0]['pnames']='';
		
		return $this->fetch('index', ['list' => $list,'date1' => $date1,'date2' => $date2]);
		
	}
   // 按推荐人
	public function tuijianren($date1='',$date2='')
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
		//SELECT pnames,kname,LEFT(marks, LOCATE(',',marks)-1) PV,RIGHT(marks, LOCATE(',',marks)-1)  UV FROM (SELECT d.pnames,d.kname,GROUP_CONCAT(ucount) marks FROM (SELECT b.`id`,c.kname ,b.`pnames`,a.`state`,COUNT(a.id) ucount FROM sun_ips a,sun_user b,sun_kouzi c WHERE a.kid=c.id  AND a.`uid`=b.`id` AND a.`uid`!=0 AND a.state NOT IN ('浏览量','注册量') GROUP BY b.`pnames`,a.state,c.`kname` ORDER BY state DESC) dGROUP BY pnames,kname)e
		
$sql1="SELECT pnames,LEFT(marks, LOCATE(',',marks)-1) PV,RIGHT(marks,LENGTH(marks)-LOCATE(',',marks)) UV FROM (SELECT d.pnames,GROUP_CONCAT(ucount) marks FROM (SELECT b.`id` ,b.`pnames`,a.`state`,COUNT(a.id) ucount FROM sun_ips a,sun_user b,sun_kouzi c WHERE a.kid=c.id  AND a.`uid`=b.`id` AND a.`uid`!=0 AND a.state NOT IN ('浏览量','注册量')";
$sql2=" GROUP BY b.`pnames`,a.state ORDER BY state DESC) d GROUP BY pnames )e";
		
		$tongjilist=Db::query($sql1.$where.$sql2);
		
		$list=Array();
		for($i=0;$i<count($tongjilist);$i++)
		{
			$l=Array();
			$l['id']=$i+1;
			$l['pnames']=$tongjilist[$i]['pnames'];
			$l['PV']=$tongjilist[$i]['PV']?$tongjilist[$i]['PV'].'次': '1次';
			$l['UV']=$tongjilist[$i]['UV']?$tongjilist[$i]['UV'].'次': '1次';
			$list[$i]=$l;
		}
		if(count($list)<1)
		{
			$list[0]['kname']='';
			$list[0]['pnames']='';
			$list[0]['id']='';
			$list[0]['PV']='';
			$list[0]['UV']='';
		}
		$list[0]['kname']='';
		
		return $this->fetch('index', ['list' => $list,'date1' => $date1,'date2' => $date2]);
		
	}
   
	//SELECT a.names ,b.ips_id,c.names FROM sun_user a,sun_ips b,sun_user c,sun_order d WHERE b.ips_id=a.id AND b.order_id=d.id  AND d.user_id=c.id
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