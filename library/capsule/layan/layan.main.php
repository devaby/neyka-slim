<?php 

namespace library\capsule\layan;

use \library\capsule\layan\mvc\model;
use \library\capsule\layan\mvc\view;
use \library\capsule\layan\mvc\controller;

class layan {

	public static function init($params) {
    	return new view($params,null);
   	}
   	
   	public static function loading() {
	   	return new view('loading',null);
   	}
   	
   	public static function permohonan($data) {
	   	return new view('permohonan',$data);
   	}
   	
   	public static function dokumen($data) {
	   	return new view('dokumen',$data);
   	}

    public static function printPemberitahuan($data) {
       return new view('printPemberitahuan',$data);
    }

    public static function printPenolakan($data) {
       return new view('printPenolakan',$data);
    }

    public static function printPerpanjangan($data) {
       return new view('printPerpanjangan',$data);
    }
    
    public static function printKeberatan($data) {
       return new view('printKeberatan',$data);
    }
   	
   	public static function getDokumen($data) {
	   	return new view('detailDokumen',$data);
   	}

    public static function getHoliday($data) {
       return new view('admin_settings_holiday_ajax',$data);
    }
   	
   	public static function getFormPemberitahuan($data) {
	   	return new view('formPemberitahuan',$data);
   	}
   	
   	public static function getFormPenolakan($data) {
	   	return new view('formPenolakan',$data);
   	}
   	
   	public static function getFormPerpanjangan($data) {
	   	return new view('formPerpanjangan',$data);
   	}
   	
   	public static function getLibraryContent($data){
       	return new view('library_content_ajax',$data);
    }
    
    public static function getGuestLibraryContent($data){
       	return new view('library_guest_content_ajax',$data);
    }
    
    public static function getUserLibraryContent($data){
       	return new view('library_user_content_ajax',$data);
    }
    
    public static function getOrderLibraryContent(){
       	return new view('library_content_order_ajax',null);
    }
    
    public static function storeOrder($data){
       	return model::storeOrder($data);
    }
    
    public static function cancelOrder($data){
       	return model::cancelOrder($data);
    }
    
    public static function printOrder(){
       	return model::printOrder();
    }
    
    public static function resetOrder(){
       	return model::resetOrder();
    }
   	   	
   	public static function saveDokumen($data) {
	   	return model::saveDokumen($data);
   	}

      public static function deletePemberitahuanDokumen($data) {
         return model::deletePemberitahuanDokumen($data);
      }

      public static function deletePerpanjanganDokumen($data) {
         return model::deletePerpanjanganDokumen($data);
      }

      public static function deletePenolakanDokumen($data) {
         return model::deletePenolakanDokumen($data);
      }

      public static function deleteKeberatanDokumen($data) {
         return model::deleteKeberatanDokumen($data);
      }

      public static function deletePemberitahuanDokumenMaster($data) {
         return model::deletePemberitahuanDokumenMaster($data);
      }

      public static function deletePerpanjanganDokumenMaster($data) {
         return model::deletePerpanjanganDokumenMaster($data);
      }

      public static function deletePenolakanDokumenMaster($data) {
         return model::deletePenolakanDokumenMaster($data);
      }

      public static function deleteKeberatanDokumenMaster($data) {
         return model::deleteKeberatanDokumenMaster($data);
      }

      public static function setDelivered($id){
         return model::setDelivered($id);
      }

      public static function deleteAttachment($id){
         return model::deleteAttachment($id);
      }
      
      public static function uploadFile($file,$path,$id) {
         return model::uploadFile($file,$path,$id);
      }
      
      public static function checkOrderNumber($data) {
	      return model::checkOrderNumber($data);
      }
      
      public static function layanSearchPermohonan($data) {
	      return new view('user_dashboard_ajax',$data);
      }
      
      public static function layanSearchPermohonanAdmin($data) {
	      return new view('admin_dashboard_ajax',$data);
      }
 
}
 
?>
