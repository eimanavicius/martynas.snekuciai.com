<?php 
class view {
    var $meniu;
	
	
public function krauk($view, $head = 1, $papildomas=null){
    
   if($head == 1){
    require 'controller/header.php';
}

  if($papildomas!=null){
       require 'controller/'.$view.'/'.$papildomas.'.php';
  }
  else{
    require 'controller/'.$view.'/default.php';
  }
    
    if($head == 1){
    require 'controller/footer.php';
    }
}

public function slaidas(){
    
    if(empty($_GET)){
          
 require 'js/slaidas.php';
  }
}

}