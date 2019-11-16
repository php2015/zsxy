<?php
namespace app\index\controller;
use think\Controller;
use think\Request;

class Upload extends Controller
{
    protected static $config;
    public $files;

    const DIR_CHMOD = 0755;
    const FILE_CHMOD = 0644;

    const FILE_TYPE_IMAGE = 'image';
    const FILE_TYPE_FLASH = 'flash';
    const FILE_TYPE_MEDIA = 'media';
    const FILE_TYPE_FILE = 'file';

    const TOUSU_TYPE = 1;

    public static $type = [
        self::TOUSU_TYPE => 'tousu',
    ];

    public function getUploadConfig(){
        if(is_null(self::$config)){
            self::$config = [
                'uri' => '/public/uploads',
                'root' => sprintf('%s/public/uploads',realpath(ROOT_PATH)),
                'maxSize' => 50 * 1024 * 1024,
                'exts' => [
                    self::FILE_TYPE_IMAGE => ['gif', 'jpg', 'jpeg', 'png', 'bmp'],
                    self::FILE_TYPE_FLASH => ['swf', 'flv'],
                    self::FILE_TYPE_MEDIA => ['swf', 'flv', 'mp3', 'mp4', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb', 'amr'],
                    self::FILE_TYPE_FILE => ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2']

                ],
                'filed'=>'Filedata',
                'water' => '',
            ];
        }

        return self::$config;
    }


    public function submit($params = null){
        if(empty($params)){
            $params = Request::instance()->param();
        }
        $config = $this->getUploadConfig();
        $result = $this->receive($config);
        if (empty($result)) {
            return '上传失败';
        }
        return $result;
    }

    public function submits(){
        $config = $this->getUploadConfig();
        $result = $this->receive($config);
        if (empty($result)) {
            return '上传失败';
        }
        return $result;
    }

    /**
     * 判断是否为一个LIST数组
     * @param array $data
     * @return boolean
     */
    public function isList(&$data) {
        if (empty($data) || !is_array($data)) {
            return false;
        }
        $keys = array_keys($data);
        $values = array_values($data);
        return ($keys === array_keys($values));
    }

    /**
     * 打水印
     * @param string $dst
     * @param string $src
     * @return boolean
     */
    public function markWater($dst, $src = null) {
        if (empty($src)) {
            $config = $this->getUploadConfig();
            $src = $config['water'];
        }

        //$iw = new ImageWater();
        //$iw->setDst($dst);
        //$iw->setSrc($src);
        //$iw->create();
        //return true;
    }


    /**
     *  接收上传内容处理
     */
    public function receive($config = null){
        if(empty($_FILES)){
            return '上传为空';
        }
        if(is_null($config)){
            $config = $this->getUploadConfig();
        }
        $this->files = $config;
        $result = [];
        foreach($_FILES as $field => $file){
            if(!isset($file['name'])){
                return '非法上传';
            }
            if(is_array($file['name'])){
                $result[$field] = [];
                $keys = array_keys($file);
                foreach($file['name'] as $index=>$name){
                    $item = [];
                    foreach($keys as $key){
                        $item[$key] = $file[$key][$index];
                    }
                    $path = $this->upload($item);
                    $result[$field][$index] = $this->access($path);
                }
            }else{
                $path = $this->upload($file);
                $result[$field] = $this->access($path);
            }
        }
        return $result;
    }

    /**
     * 处理单个文件上传
     * @param array $file
     * @throws \Exception
     * @return string
     */
    public function upload($file) {
        $this->valid($file);
        $fileExt = substr($file['name'], strrpos($file['name'], '.') + 1);
        $fileExt = strtolower($fileExt);
        $newFileName = md5(uniqid()) . '.' . $fileExt;
        $savePath = $this->getSavePath($this->getFileType($fileExt));
        $filePath = $savePath . '/' . $newFileName;
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            return '上传文件失败';
        }
        chmod($filePath, self::FILE_CHMOD);
        $path = str_replace($this->files['root'], '', $filePath);
        return [
            'path' => $path,
            'name' => $file['name'],
            'size' => filesize($filePath),
        ];
    }

    protected function access($file) {
        if (empty($file)) {
            return null;
        }

        return [
            'name' => $file['name'],
            'path' => $file['path'],
            'url' => $this->files['uri'] . $file['path'],
            'size' => $file['size'],
        ];
    }


    /**
     * 根据文件后缀获取文件类型
     * @param string $ext
     * @return string
     */
    public function getFileType($ext) {
        $config = $this->getUploadConfig();
        foreach ($config['exts'] as $type => $exts) {
            if (in_array($ext, $exts)) {
                return $type;
            }
        }
        return null;
    }


    /**
     * 创建图片存放目录
     * @param null $type
     * @param null $params
     * @return string
     */
    protected function getSavePath($type = null,$params = null) {
        if(empty($params)){
            $params = Request::instance()->param();
        }
        $name = isset($params['type'])?self::$type[$params['type']]:'';
        $dir = $this->files['root'];
        if (!empty($type)) {
            $dir = $dir . '/' . $type . '/'. $name ;
            if (!is_dir($dir)) {
                mkdir($dir, self::DIR_CHMOD,true);
            }
        }
        $array = date('Ymd');
        $dir = $dir . '/' . $array;

        if (!is_dir($dir)) {
            mkdir($dir, self::DIR_CHMOD,true);
        }
        return $dir;
    }


    /**
     * 判断上传的格式是否正确
     * @param $file
     * @return string
     */
    protected function valid($file) {
        $fileName = $file['name'];
        $tmpName = $file['tmp_name'];
        $fileSize = $file['size'];

        if (empty($fileName)) {
            return '请选择文件';
        }

        $config = $this->files;
        $savePath = $config['root'];

        if (!is_dir($savePath)) {
            return '上传目录不存在';
        }

        if (!is_writable($savePath)) {
            return '上传目录没有写权限';
        }

        if ($fileSize > $config['maxSize']) {
            return '上传文件大小超过限制';
        }

        $array = explode('.', $fileName);
        $fileExt = array_pop($array);
        $fileExt = trim($fileExt);
        $fileExt = strtolower($fileExt);
        $valid = false;
        foreach ($config['exts'] as $exts) {
            if (in_array($fileExt, $exts)) {
                $valid = true;
                break;
            }
        }
        if (!$valid) {
            return '文件扩展名是不允许的扩展名';
        }
    }
}