<?php
/*****
Karim somai
http://www.grafikking.com/
somaikarim@gmail.com
****/


class Thumbnail{
	var $filename;
	var $filename2;
	var $imageP;
	var $image;
	var $infoImage=array();
	var $maxW=180;
	var $maxH=135;
	var $Text="";

	var $setTypeImg=array(
		"png"=>array("image/png","ImageCreateFromPng"),
		"jpeg"=>array("image/jpeg","ImageCreateFromJpeg"),
		"jpg"=>array("image/jpeg","ImageCreateFromJpeg"),
		"gif"=>array("image/gif","ImageCreateFromGif")
	);

	var $blanc ;

	function SetNewWH(){

		list($w, $h) = getimagesize($this->filename);

		$nh=($this->maxW/$w)*$h;

		$this->infoImage[0]=$w;
		$this->infoImage[1]=$h;
		$this->infoImage[2]=$this->maxW;
		$this->infoImage[3]=ceil($nh);

	}

	function MakeNew(){
		$this->imageP = imagecreatetruecolor($this->infoImage[2], $this->infoImage[3]);
		$this->ext=strrchr(strtolower(basename($this->filename)), '.');
		$this->ext=substr($this->ext, 1);
		$this->image = $this->setTypeImg[$this->ext][1]($this->filename);
		$this->blanc= imagecolorallocate ($this->image,0xff,0xee,0xc5);
	}



	function FinirPImage(){

		imagecopyresampled($this->imageP, $this->image, 0, 0, 0, 0, $this->infoImage[2], $this->infoImage[3], $this->infoImage[0], $this->infoImage[1]);
		if($this->Text)
		imagestring ($this->imageP, 3, 2, $this->infoImage[3]-16, $this->Text, $this->blanc);
		imagejpeg($this->imageP, $this->filename2, 98);
		imagedestroy($this->imageP);
	}


}
?>