<?php

namespace framework;

final class template implements iengine {

public 
$path,
$meta,
$script,
$link, 
$title,
$template,

$htmlHeader = array(
		   'HTML 5' 				=> '<!DOCTYPE html>',
		   'HTML 4.01 strict' 		=> '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">',
		   'HTML 4.01 Transitional' => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">',
		   'HTML 4.01 Frameset' 	=> '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">',
		   'XHTML 1.0 Strict' 		=> '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">',
		   'XHTML 1.0 Transitional' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
		   'XHTML 1.0 Frameset'		=> '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">',
		   'XHTML 1.1'				=> '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">'
		   );
	
	public function __construct() {
		$this->setDoctype()->setTemplate()->setPath()->setMeta()->setHelper(); //->buildHTML();
	}
	
	public function setDoctype() {
	
		foreach ($this->htmlHeader as $key => $value) {
			if ($key == DOCUMENT_TYPE) {
			$this->htmlHeader = $value; 
			return $this;
			}
			
		}

	}
	
	public function setPath() {
		$this->path = PRIME_TEMPLATE;
		return $this;
	}
	
	public function setMeta() {
		$this->meta = METADATA;
		return $this;
	}
	
	public function setTemplate() {
		$this->template = file_get_contents(PRIME_TEMPLATE);
		return $this;
	}
	
	public function setHelper() {
		$this->link   = GLOBAL_LINK; 
		$this->script = GLOBAL_SCRIPT;
		return $this;
	}

}

?>