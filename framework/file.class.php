<?php

namespace framework;

class file {

public $file;

	public function __construct($folder) {
	$this->file = $folder;
	}
	
	public function checkFolderExistence() {
	if (is_dir($this->file)) {return 0;} else {return 1;};
	}
	
	public function setFile($file) {
	$this->file = $file;
	return $this;
	}
	
	public function isFile() {
	return file_exists($this->file);
	}
	
	public function isDirectory() {
	return is_dir($this->file);
	}
	
	public function getFolderContent() {
	return scandir($this->file);
	}
	
	public function createDirectory() {
	return mkdir($this->file);
	}
	
	public function renameDirectory($oldFile) {
	return rename($oldFile,$this->file);
	}
	
	public function deleteFile() {
	unlink($this->file);
	}
	
	public function deleteDirectory() {
	$status = self::recursiveDelete($this->file);
	


	}
	
	public function recursiveDelete($path) {
    $path = rtrim($path, '/').'/'; $handle = opendir($path);
    	while(false !== ($file = readdir($handle))) {
        	if($file != '.' and $file != '..' ) {
            $fullpath = $path.$file;
            if(is_dir($fullpath)) self::recursiveDelete($fullpath); else unlink($fullpath);
        	}
   	 	}
    closedir($handle);
	    rmdir($path);
	   
	}

}

?>