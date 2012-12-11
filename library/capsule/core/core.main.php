<?php

   namespace library\capsule\core;

   use \library\capsule\core\mvc\model;
   use \library\capsule\core\mvc\view;
   use \library\capsule\core\mvc\controller;

   class core {
	   
   	public static function init($params) {
   		return new view($params);
   	}
   	
   	public static function getContentNotContent($id,$type) {
   		return new view('contentInside',model::getFileToEdit($id,$type),array($id,$type));
   	}
   	
   	public static function getContentNotContentAdmin($id,$type) {
   		return new view('contentInsideAdmin',model::getFileToEdit($id,$type),array($id,$type));
   	}
   	
  	public static function getContentUser($id,$type) {
   		return new view('contentInsideContentUser',model::getContentToEdit($id,$type),array($id,$type));
   	}
   	
   	public static function getContentAdmin($id,$type) {
   		return new view('contentInsideContentAdmin',model::getContentToEdit($id,$type),array($id,$type));
   	}
   	
   	public static function getContentNotContentUserNew($id,$type) {
   		return new view('contentInsideUserNew',"",$type);
   	}
   	
   	public static function getContentNotContentPersonalNew($id,$type) {
   		return new view('contentInsidePersonalNew',"",$type);
   	}
	
	   public static function getContentNotContentAdminNew($id,$type) {
   		return new view('contentInsideAdminNew',"",$type);
   	}
   	
   	public static function getContentUserNew($id,$type) {
   		return new view('contentTextInsideUserNew',"",$type);
   	}
   	
   	public static function getContentPersonalNew($id,$type) {
   		return new view('contentTextInsidePersonalSitesNew',"",$type);
   	}
   	
   	public static function getContentAdminNew($id,$type) {
   		return new view('contentTextInsideAdminNew',"",$type);
   	}
   	
   	public static function originalContentUser($id,$type) {
   		return new view('originalContentUser',"",$type);
   	}

   	
   	public static function originalContentAdmin($id,$type) {
   		return new view('originalContentAdmin',"",$type);
   	}

      public static function nextPage($id,$type) {
         return new view('originalContentAdmin',$id,$type);
      }

	 public static function nextPageText($id,$type) {
         return new view('originalTextContentAdmin',$id,$type);
      }
   	
   	public static function originalTextContentUser($id,$type) {
   		return new view('originalTextContentUser',"",$type);
   	}
   	
   	public static function originalTextContentAdmin($id,$type) {
   		return new view('originalTextContentAdmin',"",$type);
   	}
   	public static function getLibraryContent($data){
       	return new view('library_content_ajax',$data);
    }
   	public static function createDirectory($type,$content,$mainID) {
   		model::createDirectory($type,$content,$mainID);
   	}
   	
   	public static function deleteContentNotContentUser($id,$type,$content,$del,$fkid,$mainID) {
   		if (!empty($del)) {model::deleteContent($del,$fkid);}
   		$lastID = model::saveContent($id,$content,$type,$mainID); 
   		if ($lastID != 'success' && is_numeric($lastID)) {$id = $lastID;return new view('contentInsideAjaxUser',model::getFileToEdit($id,$type),$id);}
   		else {return new view('contentInsideAjaxUser',model::getFileToEdit($id,$type),$id);}
   	}
   	
   	public static function deleteContentNotContent($id,$type,$content,$del,$fkid,$mainID) {
   		if (!empty($del)) {model::deleteContent($del,$fkid);}
   		$lastID = model::saveContent($id,$content,$type,$mainID); 
   		if ($lastID != 'success' && is_numeric($lastID)) {$id = $lastID;return new view('contentInsideAjaxAdmin',model::getFileToEdit($id,$type),$id);}
   		else {return new view('contentInsideAjaxAdmin',model::getFileToEdit($id,$type),$id);}
   	}
   	
   	public static function uploadItem($folder,$type,$files,$userID,$conId,$mainID) {
   		$model = new model(); $model->uploadItem($folder,$type,$files,$userID,$conId,$mainID);
   	}
   	
   	public static function uploadPhotoProfil($folder,$type,$files,$userID,$conId) {
   		$model = new model(); $model->uploadPhotoProfil($folder,$type,$files,$userID,$conId);
   	}
   	
   	public static function getImageUploaded($userID){
	   	return view::getImageUploaded($userID); 
   	}
   	
   	public static function updateContentNotContent($data,$del) {
   		model::saveDeleteContent($data,$del);
   	}
   	
   	public static function updateContent($data) {
   		model::updateContent($data);
   		//echo "dor";
   	}
   	
   	public static function editUser($data) {
   		model::editUser($data);
   		//echo "dor";
   	}
   	
   	public static function getMultipleLanguageContent($data) {
   		model::getMultipleLanguageContent($data);
   	}
   	
   	public static function getMultipleLanguageMenu($data) {
   		model::getMultipleLanguageMenu($data);
   	}
   	
   	public static function insertMainSubMenu($data) {
   		model::insertMainSubMenu($data);
   	}
   	
   	public static function insertSubMenu($data,$del) {
   		model::insertSubMenu($data,$del);
   	}
   	
   	public function metadata($id,$idData) {
         view::displayMetadata(model::metadata($id),$id,$idData); 
   	}
   	
   	public function saveMetadata($id,$del) {
   		model::saveMetadata($id,$del);
   	}
   	
   	public function classification($id) {
   		view::displayClassification(model::classification($id),$id,model::publisherID($id)); 
   	}
   	
   	public function saveClassification($id) {
   		model::saveClassification($id);
   	}
   	
   	public function tagging($id) {
   		view::displayTagging(model::tagging($id),$id); 
   	}
   	
   	public function saveTagging($id) {
   		model::saveTagging($id);
   	}

      public function showTagging($id) {
         view::showTagging(model::tagging($id),$id); 
      }
   	
   	public function searchOnTheFly($data){
   		view::resultSearchOnTheFly(model::searchOnTheFly($data));
   	}

      public function checkDirectory($data,$userID,$type){
         model::checkDirectory($data,$userID,$type);
      }
   	
   	public function insertSubKlasifikasi($data,$del){
         $model = new model();
   		$model->insertSubKlasifikasi($data,$del);
   		return new view("klasifikasi");
   	}
   	
   	public function insertSubPublisher($data,$del){
         $model = new model();
   		$model->insertSubPublisher($data,$del);
   		return new view("publisher");
   	}
   	
   	public function insertSubGrouping($data,$del){
         $model = new model();
   		$model->insertSubGrouping($data,$del);
   		return new view("grouping","","");
   	}

      public function getDadoDashboard($timeFrom , $timeUntil , $typeOfDate){
         return view::chartDado($timeFrom , $timeUntil , $typeOfDate);
      }
	  
	  public function getDadoDashboardYear($year){
         return view::chartDado(null,null,null,$year);
      }

      public function getDadoDashboardUser($timeFrom , $timeUntil , $typeOfDate){
         return view::chartDadoUser($timeFrom , $timeUntil , $typeOfDate);
      }
      
      public function getDadoDashboardUserYear($year){
         return view::chartDadoUser($timeFrom , $timeUntil , $typeOfDate);
      }

      public function setDefaultMetadata($data,$del){
         $model = new model(); $model->setDefaultMetadata($data,$del);
         return new view("setMetadata");
      }

   	public static function getSearchResult ($text) {
      	return new view('search',model::getSearchData($text));
      }
public static function getSearchResultUser ($text) {
      	return new view('searchuser',model::getSearchDataUser($text));
      }
      public function setRetensiWaktu($id){
         return new view('setRetensiWaktu',model::setRetensiWaktu($id));
      }  

      public function setRetensiWaktuContent($id){
         return new view('setRetensiWaktuContent',model::setRetensiWaktuContent($id));
      }  
      
      public function saveRetensiWaktu($id,$data){
      	 $model = new model();
      	 $model->saveRetensiWaktu($id,$data);
      } 
      
       public function saveRetensiWaktuContent($id,$data){
      	 $model = new model();
      	 $model->saveRetensiWaktuContent($id,$data);
      } 
      
      public function setShow($id){
	      return new view('setShow', model::setRetensiWaktu($id));
      }
      
      public function saveSetShow($id,$data){
      	 $model = new model();
      	 $model->saveSetShow($id,$data);
      } 
      
      public function setShowContent($id){
	      return new view('setShowContent', model::setRetensiWaktuContent($id));
      }
      
      public function saveSetShowContent($id,$data){
      	 $model = new model();
      	 $model->saveSetShowContent($id,$data);
      } 
      
      public function commentManagement($data){
	      
	      return new view("commentManagement",model::commentManagement($data));
      }
	
   }


?>
