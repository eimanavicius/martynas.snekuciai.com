<?php
mysql_connect("localhost", "simne", "a7mGc4V4") or die(mysql_error());
mysql_select_db("simne_demo") or die(mysql_error());
mysql_query("SET NAMES utf8");

if (isset($this->meniu))
{       //temu saraso spausdinimas meniu
    $masyvas = array();
    $preke= mysql_query("SELECT * FROM naujienos ") or die(mysql_error());
           while($eilute = mysql_fetch_array($preke)){
        if (!in_array($eilute['tema'], $masyvas)) {    
            $masyvas[]=$eilute['tema'];
        }	
}

foreach ($masyvas as $geras) {
    echo '<li><a href="naujienos/&kat='.$geras.'">'.$geras.'</a></li>';
}

}
else {

          if (isset($_GET['id'])){          //naujienos rodymas
           $id = $_GET['id'];
           $preke= mysql_query("SELECT * FROM naujienos WHERE id = '$id' ") or die(mysql_error());
           $eilute = mysql_fetch_array($preke);
           echo '<a id="valdyk" href="/naujienos/?kat='.$eilute['tema'].'">Atgal</a>';
           echo '<center><p><div class="antraste">'.$eilute['pavadinimas'].'</div></p></center>';
           echo '<p style="text-align:justify;">'.$eilute['tekstas'].'</p>';
           echo '<span>Autorius: '.$eilute['autorius'].'</span><br>';
           echo '<span>Ikelta: '.$eilute['laikas'].'</span>';
           
         }  
        
         
      if (isset($_GET['kat']) ) {       //kategorijos rodymas
            $kategorija = $_GET['kat'];
            $preke= mysql_query("SELECT * FROM naujienos WHERE tema = '$kategorija' ") or die(mysql_error()); 
            echo '<a href="index.php">Pagrindinis</a>';
            echo '<div class="antraste">'.$kategorija.' naujienų sąrašas</div>';
            while($eilute = mysql_fetch_array($preke)){
                echo '<a id="listas" href="?page=naujienos&id='.$eilute['id'].'">'.$eilute['pavadinimas'];
                echo '<div class="data">'.$eilute['laikas'].'</div>';                    
                echo '</a>';
            }
            
         }
         
       if (!isset($_GET['kat']) && !isset($_GET['id'])){ //pagrindine struktura
           $masyvas = array();
    $preke= mysql_query("SELECT * FROM naujienos ") or die(mysql_error());
           while($eilute = mysql_fetch_array($preke)){  //temu masyvas
        if (!in_array($eilute['tema'], $masyvas)) {    
            $masyvas[]=$eilute['tema'];
        }
           }
        foreach ($masyvas as $geras) {  //kiekvienos temos rodo naujienas
    echo '<div class="antraste"><a  href="naujienos/&kat='.$geras.'">'.$geras.'</a></div>';
$preke= mysql_query("SELECT * FROM naujienos WHERE tema = '$geras' ") or die(mysql_error()); 
    while($eilute = mysql_fetch_array($preke)){
                echo '<a id="listas" href="naujienos/&id='.$eilute['id'].'">'.$eilute['pavadinimas'];
                echo '<div class="data">'.$eilute['laikas'].'</div>';                    
                echo '</a>';
               
            }
            echo "<br>";
}
           
         
         
}    
}
        
   
  // print_r($_SERVER['HTTP_REFERER']);
?>
