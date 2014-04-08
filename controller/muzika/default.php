<?php
mysql_connect("localhost", "simne", "a7mGc4V4") or die(mysql_error());
mysql_select_db("simne_demo") or die(mysql_error());
mysql_query("SET NAMES utf8");


    echo '<div class="antraste">'.$view.'</div>';
        echo '<h2>2013</h2>';
        audio("../audio/2013/");
          echo '<h2>2012</h2>';
       audio("../audio/2012/");

function  audio($kelias){

	$handle = opendir ($kelias);
        while (false !== ($file = readdir($handle))) {
            if (!is_dir($kelias.$file)){
             ?><div ><a id="listas" href="http://www.greitas.com/<? echo $kelias; echo($file); ?>"/><? echo($file); ?></a></div><?
            }
        
         }
   
}
  // print_r($_SERVER['HTTP_REFERER']);
?>
