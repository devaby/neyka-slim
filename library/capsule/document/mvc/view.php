<?php

namespace library\capsule\document\mvc;

class view extends model {

protected $name;
protected $data;
protected $category;
protected $categorySel;
protected $text;
protected $url;
protected $optionGear;
protected $params;
protected $optionSearch;
protected $row;
    
    public function __construct($text,$params,$rowDisplay,$category,$folder,$id) {
    
    parent::__construct(); 
    
    if (empty($this->url)): $this->url = $GLOBALS['_neyClass']['router']; endif;

		
    if ($folder == '{folder}') {$data = $this->fetchData();} else {$data = $this->fetchFileFromFolder($folder);}
    
   	 	if (preg_match("/[|]/", $text)) {
    
        	$text = explode("|", $text);
    
        		if ($_SESSION['language'] == 'id') {
        		$text = $text[0];
        		}
        		else {
        		$text = $text[1];
        		}
        	
        }

    $this -> name 	  = $this->fetchDataID($id);
    $this -> category = $this->fetchDataForOptionCategory();
    $this -> categorySel = $category;
    $this -> text     = $text;
    $this -> data     = $data; 
    $this -> params   = $params; 
    $this -> row 	  = $rowDisplay;
    
    if (isset($_SESSION['admin']) || !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $this -> optionGear = "<span class='" . $this->params . "-optionGear'><img class='optionGear' src='/cornc/library/capsule/admin/image/settingCap.png'></span>";
    }
    
    $this -> $params();
    
    }
    
    public function normal() {  
    
    $view  = "<div class='" . $this->params . "'>";
    
    $myText = explode(" ", $this -> text);
    	
    	foreach ($myText as $value) {
    	$i++;
    		if ($i == 1) {
    		$view .= "<span class='" . $this->params . "-HeadingLeft'>" . $value . "</span> "; 
    		}
    		else {
    		$view .= "<span class='" . $this->params . "-HeadingRight'>" . $value . "</span>";
    		}
    	
    	}
    	
    	if (empty($this -> text)) {
    	$view .= "<span class='" . $this->params . "-HeadingLeft'>{text}</span> "; 
    	}
    
    $view .= $this -> optionGear;
    $view .= "<hr />";
    $view .= "<table>";

    	foreach ($this->data as $key => $value) {
    		
    		if (strlen($value[content]) >= 100) {
    		$contentLength = substr(preg_replace('/<[^>]*>/', '', $value[content]), 0, 100);
    		$contentLength = substr($contentLength, 0, strrpos($contentLength, ' ')).'...';
    		}
    		else {
    		$contentLength = preg_replace('/<[^>]*>/', '', $value[content]);
    		}
    	
    	$view .= "<tr><td class='" . $this->params . "-NewsHeader'><a href='index.php?id=" . $value[id] . "c'>$value[header]</a></td></tr>";
    	$view .= "<tr><td class='" . $this->params . "-NewsContent'>$contentLength</td></tr>";
    	$view .= "<tr><td></td></tr>";
    	
    	}
   	
   	$view .= "</table>";
    $view .= " </div>";
    
    echo $view;
    
    }
    
	public function table() {  
	    
	$view  = "<div class='" . $this->params . "'>";
	
	$myText = explode(" ", $this->text);
		
		foreach ($myText as $value) {
		$i++;
			if ($i == 1) {
			$view .= "<span class='" . $this->params . "-HeadingLeft'>" . $value . "</span> "; 
			}
			else {
			$view .= "<span class='" . $this->params . "-HeadingRight'>" . $value . "</span>";
			}
		
		}
		
		if (empty($this -> text)) {
		$view .= "<span class='" . $this->params . "-HeadingLeft'>{text}</span> ";
		}
	
	$view .= $this->optionGear; $view .= "<hr class='separator-line'/>"; $view .= "<table>";
	
	$i = 0;
	$z = 1;
	$c = count($this->data);
	
		for ($i; $i <= $this->row; $i++) {
		
		$filename = ucwords(strtolower(pathinfo($this->data[$i], PATHINFO_FILENAME)));
		$filesize = filesize($this->data[$i]); $filesize = number_format($filesize/1000) . " Kb";
		
		$view .= "<tr><td><a href='".$this->data[$i]."'>".$filename."</a></td><td class='" . $this->params . "-right'>".$filesize."</td></tr>";
	    
	    $view .= "<tr><td colspan=2><hr/></td></tr>";
	    
		}
		
	$view .= "</table>";
	$view .= " </div>";
	
	echo $view;
	
	}

	public function full() {  
	
	$view  = "<div class='" . $this->params . "'>";
	
	$myText = explode(" ", $this->text);

		$view .= "<span class='" . $this->params . "-HeadingLeft'>" . $this->name[prime] . "</span> "; 
	
		//foreach ($myText as $value) {
		//$i++;
			//if ($i == 1) {
			//$view .= "<span class='" . $this->params . "-HeadingLeft'>" . $value . "</span> "; 
			//}
			//else {
			//$view .= "<span class='" . $this->params . "-HeadingRight'>" . $value . "</span>";
			//}
		
		//}
	
	$view .= $this->optionGear; 

	$file  = model::fetchFolderFile();
	
		foreach ($file as $key => $value) {
		
			if ($value == '.' || $value == '..') {continue;}
		
			$path  = explode("/", $value); $count = count($path); $path = $path[$count-1];
				
			if(!empty($this->name)){	
				foreach ($this->name as $folder) {
					
					if ($folder == $path) {
					
					$this->data = $this->fetchFileFromFolder($path);
					
					}
					
				}
			}
						
		}
	
	//$view .= "<select class='" . $this->params . "-floatRight'>";
	
		//foreach ($file as $key => $value) {
		
		//if ($value == '.' || $value == '..') {continue;}
		
		//$path  = explode("/", $value); $count = count($path); $path = $path[$count-1];

			//if ($this->name == $path) {
			//$view .= "<option value='$value' selected='selected'>$path</option>";
			//$this->data = $this->fetchFileFromFolder($path);
			//}
			//else {
			//$view .= "<option value='$value'>$path</option>";
			//}
		//}

	//$view .= "</select>";
		
		if (empty($this -> text)) {
		$view .= "<span class='" . $this->params . "-HeadingLeft'>{text}</span> ";
		}
    $view .= "<br/>";
	$view .= "<hr class='separator-line'/>"; 
	$view .= "<table class='" . $this->params . "-table'>";
	$view .= "<thead>";
	$view .= "<tr>
				<td><input type='checkbox'></td>
				<td style='font-weight:bold'>Filename</td>
				<td style='font-weight:bold; text-align:right;'>Type</td>
				<td style='font-weight:bold; text-align:right;'>Size</td>
			  </tr>";
	$view .= "<tr><td colspan=4><hr class='separator-line'/></td></tr>";
	$view .= "</thead>";
	
	$i = 0;
	$z = 1;
	$c = count($this->data);
	
	if (!empty($this->data)) {
	
		for ($i; $i < $c; $i++) {
		
		$filename = ucwords(strtolower(pathinfo($this->data[$i], PATHINFO_FILENAME)));
		$filetype = ucwords(strtolower(pathinfo($this->data[$i], PATHINFO_EXTENSION)));
		$filesize = filesize(ROOT_PATH.$this->data[$i]); $filesize = number_format($filesize/1000) . " Kb";
		
		
		
		$view .= "<tr>
					<td class='" . $this->params . "-checkbox'><input type='checkbox' value='".$this->data[$i]."'></td>
					<td><a href='" . substr(APP,0,-1). "/" .$this->data[$i]."' target='_blank'>".model::getFileName($this->data[$i])."</a></td>
					<td class='" . $this->params . "-right'>".$filetype."</td>
					<td class='" . $this->params . "-right'>".$filesize."</td>
				  </tr>";
	    
	    $view .= "<tr><td colspan=4><hr class='separator-line'/></td></tr>";
	    
		}
		
	}
	else {
	
	$view .= "<tr><td style='text-align:center; padding-top:30%;' colspan=4>- No File's Has Been Added. Yet. -</td></tr>";
	
	}
		
	$view .= "</table>";
	$view .= "</div>";
	
	//$view .= '<script>$(document).ready(function(){$(\'table.full-table\').scrollbarTable(700);});</script>';
	
	echo $view;
	
	}
	
	
	public function showUndangUndang(){
	$view .= $this->optionGear;
	$view .= '<div class="events">';
	$view .= '            	<h4 class="heading backcolr">Peraturan Perundang-Undangan</h4> ';
		$view .= '<div class="dado-core-desc-left-body">';
                          $data = model::grouping($this->categorySel);
                          //print_r($this->category);
                          $view .= "<table cellpadding='0' cellspacing='0' class='core-listInformasiPublik-table'>";
                                      $view .= "<thead>";
                                                $view .= "<tr class='core-listInformasiPublik-thead-tr'>";
                                                $view .= "  <td style='min-width:50px;' class='align-center'>No.</td>";
                                                $view .= "  <td class='align-center'>Tahun</td>  ";
                                                $view .= "  <td class='align-center'>PUU</td>  ";
                                                $view .= "  <td class='align-center'>Nomor</td>  ";
                                                $view .= "  <td class='align-center'>Masalah</td>  ";												
                                                $view .= "  <td class='align-center'>Perihal</td>  ";
                                                $view .= "  <td class='align-center'>FIle</td>  ";
                                                $view .= "</tr>";
                                      $view .= "</thead>";
                                      $view .= "<tbody>";

                                    //print_r($data[0]['grouping'][0]);
                                    if(!empty($data[0]['grouping'])){
                                      foreach ($data[0]['grouping'] as $key => $value) {
                                        $view .= $this->recursiveIP($value,0);

                                     }
                                   }
   
                                $view .= "</tbody>";
                              $view .= "<tfoot>";
                              $view .= "<tr>";
                              $view .= "  <td style='width:20px;'></td>";
                              $view .= "  <td style='min-width:15%; max-width:100px;'></td>";
                              $view .= "  <td ></td>";
							  $view .= "  <td ></td>";
							  $view .= "  <td ></td>";
							  $view .= "  <td ></td>";
                              $view .= "  <td style='min-width:25%; '></td>";
                              $view .= "</tr>";
                              $view .= "</tfoot>";
                              $view .= "</table>";

                                 $view .= '</div>';
								       $view .= '</div>';
      

                         echo $view;
	}
	
	
	public function recursiveIP($data,$i){
      if(!empty($data)){
        if(empty($i) || $i == 0){
        
          $i = 0;
        
          $padding = $i ;
          $rowChild ="";
          $display ="";
        }else{
        
          $padding = $i * 20;
          $rowChild = "<img src='library/capsule/core/images/rowChild.png' style='padding-left:".$padding."px; margin-right:5px;'>";   
          $display = "style='display:none'";
        }
       
        
          $view .= "<tr class='core-listInformasiPublik-tbody-tr-klas' ".$display.">";
          $view .= "<td class='core-listInformasiPublik-collapse '><span class='core-image-actionPlus core-image-plus'></span>
                    <input type='hidden' name='child' value=''><input type='hidden' name='currentID' value='".$data['parent']['CAP_GRO_ID']."'>
                    <input type='hidden' name='parentID' value='".$data['parent']['CAP_GRO_PARENT']."'></td>";
          $view .= "<td class='core-listInformasiPublik-klas' colspan=\"5\">".$rowChild."<span>".$data['parent']['CAP_GRO_NAME']."</span></td>";
          $view .= "<td class='core-listInformasiPublik-ket align-center'>".$data['parent']['CAP_GRO_NOTE']."</td>";
          $view .= "</tr>";


           if(isset($data['item'])){
            $n=1;
            foreach ($data['item'] as $key => $value) {
              
              $view .= self::setItem($value,$n);
              $n++;
           }
         }

          if(isset($data['child'])){
             $i++;
            foreach ($data['child'] as $keys => $values) {
                          
              $view .= self::recursiveIP($values,$i);
              
            }


          }

          
       
        }


      return $view;
  }

  

  public function setItem($value,$i){
    $c=$i%2;
    if($c==0){
      $n='-2';
    }else{
      $n='';
    }
        if(isset($value[0]['metadata'])){
	    foreach($value[0]['metadata'] as $keys => $values){
	    	switch(strtolower($values['CAP_CON_MET_HEADER'])){
		    	case strtolower('Nomor Dokumen'):
		    		
		    		$nomor = $values['CAP_CON_MET_CONTENT'];
		    	break;
		    	case strtolower('Judul Dokumen'):
		    		$perihal = $value['CAP_CON_MET_CONTENT'];
		    	break;
		    	case strtolower('Masalah'):
		    		$masalah = $values['CAP_CON_MET_CONTENT'];
		    	break;
		    	case strtolower('PUU'):
		    		$puu = $values['CAP_CON_MET_CONTENT'];
		    	break;
		    	case strtolower('Tahun Terbit'):
		    		$tahun = $values['CAP_CON_MET_CONTENT'];
		    	break;
	    	}
	    }
    }
    
    if($value['CAP_LAN_COM_VALUE']){
	    $download = "<a href=\"".$value['CAP_LAN_COM_VALUE']."\ target=\"_blank\">Download</a>";
    }

    $view .= "<tr class='core-listInformasiPublik-tbody-tr-file".$n."' style='display:none'>";
      $view .= "<td class='core-listInformasiPublik-no align-center'><input type='hidden' name='parentID' value='".$value[CAP_GRO_ID]."'>";
      $view .= "<input type='hidden' name='itemID' value='".$value[CAP_LAN_COM_ID]."'>";
      $view .= "".$i."</td>";
	  
	  $view .= "<td class='core-listInformasiPublik-file border-left' colspan=\"1\">".$tahun."</td>";
	  $view .= "<td class='core-listInformasiPublik-file border-left' colspan=\"1\">".$puu."</td>";
	  $view .= "<td class='core-listInformasiPublik-file border-left' colspan=\"1\">".$nomor."</td>";
      $view .= "<td class='core-listInformasiPublik-file border-left' colspan=\"1\">".$masalah."</td>";
	  $view .= "<td class='core-listInformasiPublik-file border-left' colspan=\"1\">".$perihal."</td>";
	  $view .= "<td class='core-listInformasiPublik-file border-left' colspan=\"1\">$download</td>";
     
      /*$view .= "<td class='core-listInformasiPublik-action border-left align-center'><span class='core-image-actionTagging core-image-showTagging'></span><span class='core-image-actionClassification core-image-classificationShow'></span><span class='core-image-actionFolder core-image-folderShow'></span><span class='core-image-actionDownload core-image-download'></span></td>";*/
      $view .= "</tr>";
      
      return $view;

  }
		    
    
}















?>
