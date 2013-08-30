<?php
class Image {
	public $image_resource = null;
	public $width = 0;
	public $height = 0;
	public $ext;
	public $mime;
	
	public function __construct($image) {
		// 判断图片是否存在
		if(!file_exists($image)) {
			return false;
		}
		
		$info = getimagesize($image);
		if($info == false) {
			return false;
		}

		// 此时info分析出来,是一个数组
		$this->width  = $info[0];
		$this->height = $info[1];
		$this->ext    = substr($info['mime'],strpos($info['mime'],'/')+1);;
		$this->mime   = $info['mime'];
		
		// 创建原始图的画布
		$dfunc = 'imagecreatefrom' . $this->ext;
		$this->image_resource = $dfunc($image);		
	}

	/**
	 thumb 生成缩略图
	 等比例缩放,两边留白
	 **/
	public function output($filename=NULL,$width=300,$height=300) {
		// 首先判断待处理的图片存不存在
		if($this->image_resource == false &&
		   ($this->width ==0 || $this->height==0)
		) {
			return false;
		}
		
		// 计算缩放比例
		$calc = min($width/$this->width, $height/$this->height);
		// 创建缩略画布
		$tim = imagecreatetruecolor($width,$height);
		// 创建白色填充缩略画布
		$white = imagecolorallocate($tim,255,255,255);
		// 填充缩略画布
		imagefill($tim,0,0,$white);
		// 复制并缩略
		$dwidth = $calc*(int)$this->width;
		$dheight = $calc*(int)$this->height;
		//计算复制的位置
		$paddingx = (int)($width - $dwidth) / 2;
		$paddingy = (int)($height - $dheight) / 2;

		imagecopyresampled($tim,$this->image_resource,$paddingx,$paddingy,0,0,$dwidth,$dheight,$this->width,$this->height);

		$this->_output($tim,$filename);

		return true;
	}
	
	/*
	 * 输出到浏览器或保存到文件中
	 * */
	private function _output($image_source,$filename){
		if ($filename==NULL) {
			header('Content-Type: '.$this->mime);
		}
		
		$createfunc = 'image' . $this->ext;
		
		$createfunc($image_source,$filename);
		imagedestroy($image_source);
	}
	
	public function __destruct(){
		if (is_resource($this->image_resource)) {
			imagedestroy($this->image_resource);
		}
	}
}