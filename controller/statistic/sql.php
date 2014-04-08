<?php

class sql {
function __construct($ip = null) {
      
	  $db = new PDO('mysql:host=localhost;dbname=simne_demo', 'simne', 'a7mGc4V4');
	 $db-> query("SET CHARACTER SET utf8");
	 $this->kurti($db);
	 
	 if($ip == null){
	
	 $this->statistika($db);
//$dateTime = new DateTime("now");
//echo $dateTime->format("Y-m-d H:i:s");
//echo "<pre>";

//foreach($a as $b) {
  //echo $b['ip']."\n";
//}

}

else{

 $db-> exec("INSERT INTO statistic (ip, laikas) VALUES ('$ip',NOW())");
}


}
   
   function kurti($db) {
       $db-> query("CREATE TABLE statistic ( ip  VARCHAR(50), laikas TIMESTAMP)  ");
   }
   
   function statistika($db){
   
    $a = $db->query("select ip from statistic WHERE laikas >= DATE_SUB(NOW(), INTERVAL 1 DAY) GROUP BY ip")->fetchAll(PDO::FETCH_ASSOC);
$html = "Per parą apsilankė:" .count($a);
	

	echo $html;
	}


}