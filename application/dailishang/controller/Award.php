<?php
namespace app\dailishang\controller;

use app\common\model\Profit as ProfitModel;
use app\common\model\User as UserModel;
use app\common\model\Chaxun as ChaxunModel;
use app\common\controller\AdminBaseDailishang;
use think\Db;
use think\Session;
use PHPExcel_IOFactory;
use PHPExcel;
/**
 * 奖励明细
 * Class Order
 * @package app\dailishang\controller
 */
class Award extends AdminBaseDailishang
{
    protected $profit_model;
    protected function _initialize()
    {
        parent::_initialize();
        $this->profit_model  = new ProfitModel();
        $this->user_model  = new UserModel();
        $this->chaxun_model  = new ChaxunModel();
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
	$dailishang_id = Session::get('dailishang_id');
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
		
      
      $map=$map." and a.profit_id='".$dailishang_id."'";
        $award_list  = $this->profit_model
		->alias("a")
		->field("a.*,c.names")
        ->join("__USER__ c","a.uid = c.id","LEFT")
		->where($map)->order(['a.id' => 'DESC'])->paginate(15, false, ['query'=>request()->param()]);
      
       
       return $this->fetch('index', ['award_list' => $award_list]);
      
      
    }
	//SELECT a.names ,b.profit_id,c.names FROM sun_user a,sun_profit b,sun_user c,sun_order d WHERE b.profit_id=a.id AND b.order_id=d.id  AND d.user_id=c.id
	//导出EXCEL
	public function excel(){
		
		$dailishang_id = Session::get('dailishang_id');
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
		
      $map=$map." and a.profit_id='".$dailishang_id."'";
       $award_list  = $this->profit_model
		->alias("a")
		->field("a.*")
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