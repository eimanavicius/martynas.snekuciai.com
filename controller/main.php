<?php
class main {
    function __construct(){

if (isset($_GET['url'])) {$url = $_GET['url'];}
else{$url="naujienos";}
$url = explode("/", $url);
if ($url[0]==""){$url[0]="naujienos";  }
  

    
    
require 'controller/view.php';
$view = new view();

if(file_exists('controller/'.$url[0].'/default.php')){
$view->krauk($url[0]);
}
else{
$view->krauk('error');
}
}


}

?>
