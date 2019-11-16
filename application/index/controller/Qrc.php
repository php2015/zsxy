<?php

namespace app\index\controller;

use think\Controller;
use think\Image;
use think\Db;
use think\Request;//首先引入 Request 文件；
class Qrc extends Controller
{
    public function _initialize()
    {
        if (!session('name')) {
            // $this->error('请先登录系统！','index/login/login');
            $this->redirect('index/login/login');
        }
    }

    public function views()
    {
        $typeId = input('type_status');
        $yuming = $_SERVER['HTTP_HOST'];
        $pid = session('uid');

        if (isset($typeId) && !empty($typeId) && $typeId == 8) {
            $imgid = input('imgid');
            $url = 'http://' . $yuming . '/index.php/index/chaxun/analysis/cid/' . $imgid;
            $img_url = db('bjurl')->where('id', '=', '2556')->find();
            $height = 740;
            $left = 240;
            $dx = 5;
        } else {
            $imgid = input('imgid');
            $p_id = input('p_id');
            $a_g_id = input('a_g_id');
            $product = db('product')->where('id', '=', $imgid)->find();
            switch ($a_g_id) {
            	case 5:
                    $img_url = db('bjurl')->where('tname', '=', '用户画像')->find();
                     $height = 962;
                    $left = 262;
                    break;
                case 4:
                    $img_url = db('bjurl')->where('tname', '=', '消费评估')->find();
                     $height = 962;
                    $left = 262;
                    break;
                case 3:
                    $img_url = db('bjurl')->where('tname', '=', '高级版')->find();
                    $height = 1028;
                    $left = 275;
                    break;
                default:
                    $img_url = db('bjurl')->where('tname', '=', '高级版')->find();
                    $height = 1028;
                    $left = 275;
            }

            $spid = input('pid');
            // dump($img_url);die;
            //二维码内容;
            switch ($a_g_id) {
                case 7:
                    $product = db('product')->where('id', '=', $imgid)->find();
                    $url = 'http://' . $yuming . '/index/chaxun/query5/price/' . $product['price'] . '/pid/' . $product['id'];
                    break;
                case 5:
                    $product = db('product')->where('id', '=', $imgid)->find();
                    $url = 'http://' . $yuming . '/index/chaxun/query2/price/' . $product['price'] . '/pid/' . $product['id'];
                    break;
                case 4:
                    $product = db('product')->where('id', '=', $imgid)->find();
                    $url = 'http://' . $yuming . '/index/chaxun/query1/price/' . $product['price'] . '/pid/' . $product['id'];
                    break;
                case 3:
                    $product = db('product')->where('id', '=', $imgid)->find();
                    $url = 'http://' . $yuming . '/index/chaxun/query/price/' . $product['price'] . '/pid/' . $product['id'];
                    break;    
                default:
                	$product = db('product')->where('id', '=', $imgid)->find();
                    $url = 'http://' . $yuming . '/index/chaxun/query/price/' . $product['price'] . '/pid/' . $product['id'];
               
            }
        }
        Vendor('phpqrcode.phpqrcode');
        $bj_url = $img_url['thumb'];
        
        $bjimg_name = str_replace("\\", "/", $bj_url);

        // $url ='http://hx.hbkckc.com/index.php/index/index/index/pid/'.$pid;
        //容错级别
        $errorCorrectionLevel = 'H';
        //生成图片大小
        $matrixPointSize = isset($dx) && !empty($dx) ? $dx : 4.2;
        //生成一个二维码图片
        ob_clean();
        $object = new \QRcode();
        $object->png($url, ROOT_PATH . 'public/index/img/zhihua_w.png', $errorCorrectionLevel, $matrixPointSize, 2);
        // ① 第一个参数$text：就是上面代码里的URL网址参数；
        // ② 第二个参数$outfile：默认为否；不生成文件；只将二维码图片返回；否则需要给出存放生成二维码图片的路径；
        // ③ 第三个参数$level：默认为L；这个参数可传递的值分别是L(QR_ECLEVEL_L，7%)、M(QR_ECLEVEL_M，15%)、Q(QR_ECLEVEL_Q，25%)、H(QR_ECLEVEL_H，30%)；这个参数控制二维码容错率；不同的参数表示二维码可被覆盖的区域百分比。利用二维维码的容错率；我们可以将头像放置在生成的二维码图片任何区域；
        // ④ 第四个参数$size：控制生成图片的大小；默认为4；
        // ⑤ 第五个参数$margin：控制生成二维码的空白区域大小；
        // ⑥ 第六个参数$saveandprint：保存二维码图片并显示出来；$outfile必须传递图片路径；
        // ⑦ 第七个参数$back_color：背景颜色；
        // ⑧ 第八个参数$fore_color：绘制二维码的颜色；
        // //准备好的logo图片,本人放在了根目录下

        $logo = ROOT_PATH . 'public/xindex/login/login1.jpg';
        
        //已经生成的原始二维码图,也在根目录下
        $qrcode = ROOT_PATH . 'public/index/img/zhihua_w.png';
        //logo图片存在
        if ($logo !== FALSE) {
            $qrcode = imagecreatefromstring(file_get_contents($qrcode));
            $logo = imagecreatefromstring(file_get_contents($logo));
            $qrcode_width = imagesx($qrcode);   //二维码图片宽度
            $qrcode_height = imagesy($qrcode);  //二维码图片高度
            $logo_width = imagesx($logo);       //logo图片宽度
            $logo_height = imagesy($logo);      //logo图片高度
            $logo_qr_width = $qrcode_width / 5;
            $scale = $logo_width / $logo_qr_width;
            $logo_qr_height = $logo_height / $scale;
            $from_width = ($qrcode_width - $logo_qr_width) / 2;
            //重新组合图片并调整大小
            imagecopyresampled($qrcode, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
                $logo_qr_height, $logo_width, $logo_height);
        }

        //输出图片
        @unlink($qrcode); //删除二维码与logo的合成图片
        $QIMG = ROOT_PATH . 'public/index/img/zhihua_w_logo.png';
       
        imagepng($qrcode, $QIMG);
        
        $dst_path = ROOT_PATH . $bjimg_name;//背景图片路径
        
        $src_path = $QIMG;//覆盖图
        //创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        $src = imagecreatefromstring(file_get_contents($src_path));
//获取覆盖图图片的宽高
        $dst_width = imagesx($dst);   //二维码图片宽度
        $dst_height = imagesy($dst);  //二维码图片高度
        list($src_w, $src_h) = getimagesize($src_path);
        //dump($src_h);die;
        $from_w = ($dst_width - $src_w) / 2;
     
        //dump($from_w);die;
        //重新组合图片并调整大小
//将覆盖图复制到目标图片上，最后个参数100是设置透明度（100是不透明），这里实现不透明效果
        imagecopymerge($dst, $src, $left, $height, 0, 0, $src_w, $src_h, 100);
        @unlink($QIMG); //删除二维码与logo的合成图片
        @unlink($QRB);  //删除服务器上二维码图片
        //header("Content-type: image/png");
        $suijishu = rand(100000, 999999);
        $bj_logo = ROOT_PATH . DS . 'img/' . $suijishu . '.png';

        $color = imagecolorallocatealpha($dst, 0, 0, 0, 0);
        $fontfile = ROOT_PATH . '/public/fonts/simkai.ttf';


        //文字添加
        //1.画布
        //2.字体大小
        //3.旋转
        //4.x距离
        //5.y距离
        //6.颜色
        //7.字体
        //8.字
        $font = db('user')->where('id', '=', $pid)->find();
        #$feng='风控官'.$font['mid'];
        $feng = '';
        imagettftext($dst, 24, 0, 150, 755, $color, $fontfile, $feng);

        imagepng($dst, $bj_logo);//根据需要生成相应的图片
        $file = pathinfo($bj_logo);
        $logo_name = $file['basename'];

        $data['url'] = $logo_name;
        $bjimg_id = db('bj_url')->insertGetId($data);

        $bj_img = db('bj_url')->where('id', '=', $bjimg_id)->find();
        if ($bj_img) {
            $bj_unimg = db('bj_url')->where('id', 'neq', $bjimg_id)->select();
            foreach ($bj_unimg as $key => $value) {
                $bjimgname = ROOT_PATH . 'img/' . $value['url'];
                if ($bjimgname !== FALSE) {//检查图片文件是否存在
                	if(file_exists($bjimgname)){
                     		unlink($bjimgname);
                     }
                    db('bj_url')->where('id', '=', $value['id'])->delete();
                } else {
                    $this->redirect('index/index/index');
                }
            }
        }

        imagedestroy($dst);
        imagedestroy($src);
        $request = Request::instance();

        $domain = $request->domain();
        echo '<body style="margin:0px;padding:0;"><div style="height:100px;line-height:100px;text-align:center;font-size:40px;background: #ac5cff;"><a href="/index/index/home" style=" text-decoration: none;color:#fff;margin:0px;padding:0;">回到主页面</a></div>
    <img src="/img/' . $logo_name . '" style="width:100%;margin:0px;padding:0;"/>
       </body>';

    }

    public function view()
    {
        $pid = session('uid');
        $imgid = input('imgid');
        Vendor('phpqrcode.phpqrcode');
        $img_url = db('bjurl')->where('tname', '=', '代理')->find();
        $bj_url = $img_url['thumb'];
        $bjimg_name = str_replace("\\", "/", $bj_url);
        $spid = input('pid');
        //dump($bjimg_name);die;
        //二维码内容
        $yuming = $_SERVER['HTTP_HOST'];

        $url = 'http://' . $yuming . '/index.php/index/login/daili/pid/' . $pid;
        //容错级别
        $errorCorrectionLevel = 'H';
        //生成图片大小
        $matrixPointSize = 6;
        //生成一个二维码图片
        ob_clean();
        $object = new \QRcode();
        $object->png($url, ROOT_PATH . 'public/index/img/zhihua_w.png', $errorCorrectionLevel, $matrixPointSize, 2);
//         ① 第一个参数$text：就是上面代码里的URL网址参数；
//         ② 第二个参数$outfile：默认为否；不生成文件；只将二维码图片返回；否则需要给出存放生成二维码图片的路径；
//         ③ 第三个参数$level：默认为L；这个参数可传递的值分别是L(QR_ECLEVEL_L，7%)、M(QR_ECLEVEL_M，15%)、Q(QR_ECLEVEL_Q，25%)、H(QR_ECLEVEL_H，30%)；这个参数控制二维码容错率；不同的参数表示二维码可被覆盖的区域百分比。利用二维维码的容错率；我们可以将头像放置在生成的二维码图片任何区域；
// ④ 第四个参数$size：控制生成图片的大小；默认为4；
// ⑤ 第五个参数$margin：控制生成二维码的空白区域大小；
// ⑥ 第六个参数$saveandprint：保存二维码图片并显示出来；$outfile必须传递图片路径；
// ⑦ 第七个参数$back_color：背景颜色；
// ⑧ 第八个参数$fore_color：绘制二维码的颜色；
        //exit;


        // //准备好的logo图片,本人放在了根目录下

        $logo = ROOT_PATH . 'public/xindex/login/login1.jpg';
        //已经生成的原始二维码图,也在根目录下
        $qrcode = ROOT_PATH . 'public/index/img/zhihua_w.png';
        //logo图片存在
        if ($logo !== FALSE) {
            $qrcode = imagecreatefromstring(file_get_contents($qrcode));
            $logo = imagecreatefromstring(file_get_contents($logo));
            $qrcode_width = imagesx($qrcode);   //二维码图片宽度
            $qrcode_height = imagesy($qrcode);  //二维码图片高度
            $logo_width = imagesx($logo);       //logo图片宽度
            $logo_height = imagesy($logo);      //logo图片高度
            $logo_qr_width = $qrcode_width / 5;
            $scale = $logo_width / $logo_qr_width;
            $logo_qr_height = $logo_height / $scale;
            $from_width = ($qrcode_width - $logo_qr_width) / 2;
            //重新组合图片并调整大小
            imagecopyresampled($qrcode, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
                $logo_qr_height, $logo_width, $logo_height);
        }
        //输出图片
        @unlink($qrcode); //删除二维码与logo的合成图片
        @unlink($QRB);  //删除服务器上二维码图片
        $QIMG = ROOT_PATH . 'public/index/img/zhihua_w_logo.png';
        imagepng($qrcode, $QIMG);

        $dst_path = ROOT_PATH . $bjimg_name;//背景图片路径
        $src_path = $QIMG;//覆盖图
        //创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        $src = imagecreatefromstring(file_get_contents($src_path));
//获取覆盖图图片的宽高
        $dst_width = imagesx($dst);   //二维码图片宽度
        $dst_height = imagesy($dst);  //二维码图片高度
        list($src_w, $src_h) = getimagesize($src_path);
        $from_w = ($dst_width - $src_w) / 2;
        //dump($from_w);die;
        //重新组合图片并调整大小
//将覆盖图复制到目标图片上，最后个参数100是设置透明度（100是不透明），这里实现不透明效果
        imagecopymerge($dst, $src, 245, 565, 0, 0, $src_w, $src_h, 100);
        @unlink($QIMG); //删除二维码与logo的合成图片
        @unlink($QRB);  //删除服务器上二维码图片
        //header("Content-type: image/png")
        $suijishu = rand(100000, 999999);
        $bj_logo = ROOT_PATH . DS . 'img/' . $suijishu . '.png';

        $color = imagecolorallocatealpha($dst, 243, 251, 254, 120);
        $fontfile = ROOT_PATH . '/public/fonts/simkai.ttf';
        //文字添加
        //1.画布
        //2.字体大小
        //3.旋转
        //4.x距离
        //5.y距离
        //6.颜色
        //7.字体
        //8.字
        $font = db('user')->where('id', '=', $pid)->find();

        imagepng($dst, $bj_logo);//根据需要生成相应的图片
        $file = pathinfo($bj_logo);
        $logo_name = $file['basename'];


        $data['url'] = $logo_name;

        $bjimg_id = db('bj_url')->insertGetId($data);
        $bj_img = db('bj_url')->where('id', '=', $bjimg_id)->find();
        if ($bj_img) {
            $bj_unimg = db('bj_url')->where('id', 'neq', $bjimg_id)->select();
            foreach ($bj_unimg as $key => $value) {
                $bjimgname = ROOT_PATH . 'img/' . $value['url'];
                if ($bjimgname !== FALSE) {//检查图片文件是否存在
                     if(file_exists($bjimgname)){
                     		unlink($bjimgname);
                     }
                    db('bj_url')->where('id', '=', $value['id'])->delete();
                } else {
                    $this->redirect('index/index/index');
                }
            }
        }

        imagedestroy($dst);
        imagedestroy($src);
        $request = Request::instance();

        $domain = $request->domain();
        echo '<body style="margin:0px;padding:0;"><div style="height:100px;line-height:100px;text-align:center;font-size:40px;background: #ac5cff;"><a href="/index/index/home" style=" text-decoration: none;color:#fff;margin:0px;padding:0;">回到主页面</a></div>
    <img src="/img/' . $logo_name . '" style="width:100%;margin:0px;padding:0;"/>
       </body>';

    }
}