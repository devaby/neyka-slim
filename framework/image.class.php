<?php

namespace framework;

class image {

public $header;
public $img;
public $percent;
public $width;
public $height;
public $newWidth;
public $newHeight;
public $imageP;
public $image;
public $type;

	public function __construct($img,$resize) {
	$this->img 		= $img;
	$this->percent 	= $resize;
	
	self::setOriginal(); self::resize(); self::resample();
	
	}
	
	public function setOriginal() {
	list($width, $height, $type) = getimagesize($this->img); $this->width = $width; $this->height = $height; $this->type = $type;
	}
	
	public function resize() {
	$this->newWidth  = $this->width  * $this->img; $this->newHeight = $this->height * $this->img;
	}
	
	public function resample() {
	$this->imageP = imagecreatetruecolor($this->newWidth, $this->newHeight);
	$this->image  = imagecreatefromjpeg($this->img);
	imagecopyresampled($this->imageP, $this->image, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $this->width, $this->height);
	}
	
	public function header() {
	return header('Content-type: image/'.$this->type.'');
	}
	
	public function output() {
	return imagejpeg($this->imageP, null, 100);
	}
	


}

