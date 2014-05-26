<?php
class ThumbnailExecption extends Exception{
    public function __construct($message = null, $code = 0){
        parent::__construct($message,$code);
        error_log('Error in ' . $this->getFile() . ' Line: ' . $this->getLine() . ' Error: ' . $this->getMessage());
    }
}

class ThumbnailFileException extends ThumbnailExecption{}

class ThumbnailNotSupportedException extends ThumbnailExecption{}


class Thumbnail{
    private $maxWidth;
    private $maxHeight;
    private $scale;     //是否按原图比例缩放，默认是
    private $inflate;   //原图小于缩略图，是否放大，默认是
    private $types;     //缩放的图片类型
    private $imgLoaders;
    private $imageCreators;
    private $source;
    private $sourceWidth;
    private $sourceHeight;
    private $sourceMime;
    private $thumb;
    private $thumbWidth;
    private $thumbHeight;

    public function __construct($maxWidth,$maxHeight,$scale=true,$inflate=true){
        $this->maxWidth = $maxWidth;
        $this->maxHeight = $maxHeight;
        $this->scale = $scale;
        $this->inflate = $inflate;

        $this->types = array('image/jpeg','image/png','image/gif');
        $this->imgLoaders = array('image/jpeg'=>'imagecreatefromjpeg','image/png'=>'imagecreatefrompng','image/gif'=>'imagecreatefromgif');
        $this->imgCreators = array('image/jpeg'=>'imagejpeg','image/png'=>'imagepng','image/gif'=>'imagegif');
    }
    /**
     * 装载指定本地图片
     * getimagesize
     */
    public function loadFile($image){
        if(!$dims = @getimagesize($image)){
            throw new ThumbnailFileException('Could not find image: '.$image);
        }
        if(in_array($dims['mime'],$this->types)){
            $loader = $this->imgLoaders[$dims['mime']];
            $this->source = $loader($image);
            $this->sourceWidth = $dims[0];
            $this->sourceHeight = $dims[1];
            $this->sourceMime = $dims['mime'];
            $this->initThumb();
            return true;
        }else{
            throw new ThumbnailNotSupportedException('Image MIME type '.$dims['mime'].' not supported');
        }
    }
    /**
     * 从字符串装载图片，一般是从数据库中获得
     * imagecreatefromstring
     */
    public function loadData($image, $mime){
        if(in_array($mime,$this->types)){
            if($this->source = @imagecreatefromstring($image)){
                $this->sourceWidth = imagesx($this->source);
                $this->sourceHeight = imagesy($this->source);
                $this->sourceMine = $mime;
                $this->initThumb();
                return true;
            }else{
                throw new ThumbnailFileException('Could not load image from string');   
            }
        }else{
            throw new ThumbnailnotSupportedException('Image MIME type '.$mime.' not supported');
        }
    }
    /*
     * 生成缩略图，若传递一个文件名给该方法，那么缩略图将以指定的名称保存
     */
    public function buildThumb($file = null){
        $creator = $this->imgCreators[$this->sourceMime];
        if(isset($file)){
            return $creator($this->thumb,$file);
        }else{
            return $creator($this->thumb);
        }
    }

    public function getMime(){
        return $this->sourceMime;
    }

    public function getThumbWidth(){
        return $this->sourceWidth;
    }

    public function getThumbHeight(){
        return $this->sourceHeight;
    }

    /*
     * 处理缩放
     */
    public function initThumb(){
        if($this->scale){//按比例缩放
            if($this->sourceWidth > $this->maxWidth){
                $this->thumbWidth = $this->maxWidth;
                $this->thumbHeight = floor($this->sourceHeight * ($this->maxWidth/$this->sourceWidth));
            }else if($this->sourceWidth < $this->sourceHeight){
                $this->thumbHeight = $this->maxHeight;
                $this->thumbWidth = floor($this->sourceWidth * ($this->maxHeight/$this->sourceHeight));
            }else{
                $this->thumbWidth = $this->sourceWidth;
                $this->thumbHeight = $this->sourceHeight;
            }
        }else{
            $this->thumbWidth = $this->maxWidth;
            $this->thumbHeight = $this->maxHeight;
        }

        //创建空白缩略图
        $this->thumb = imagecreatetruecolor($this->thumbWidth,$this->thumbHeight);

        if($this->sourceWidth <= $this->maxWidth && $this->sourceHeight <= $this->maxHeight && $this->inflate = false){
            $this->thumb = $this->source;
        }else{
            imagecopyresampled($this->thumb, $this->source, 0,0,0,0, $this->thumbWidth,$this->thumbHeight,$this->sourceWidth,$this->sourceHeight);
        }
    }
}

