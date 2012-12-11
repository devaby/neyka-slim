<?php

namespace framework;

class video {

protected $path, $file, $extension, $size;

	public function __construct($path,$file,$size,$extension) {
	$this->path 	 = $path;
	$this->file 	 = $file;
	$this->size		 = $size;
	$this->extension = $extension;
	}
	
	public function thumbnail() {

	$second = 1;
	
	$cmd = "$ffmpeg -i $video 2>&1";
	
	     if (preg_match('/Duration: ((\d+):(\d+):(\d+))/s', `$cmd`, $time)) {
	     $total  = ($time[2] * 3600) + ($time[3] * 60) + $time[4];
	     $second = rand(1, ($total - 1));
	     }
	
	$ext = pathinfo($this->file, PATHINFO_FILENAME).".".$this->extension;
	
	$cmd = "$this->path -i ".$this->file." -deinterlace -an -ss $second -t 00:00:01 -r 1 -y -s $this->size -vcodec mjpeg -f mjpeg ".pathinfo($this->file, PATHINFO_DIRNAME)."/".$ext." 2>&1";
			  
	$return = `$cmd`;

	}

}

?>