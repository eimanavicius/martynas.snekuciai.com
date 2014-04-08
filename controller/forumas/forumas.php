<?php
mysql_connect("localhost", "simne", "a7mGc4V4") or die(mysql_error());
mysql_select_db("simne_demo") or die(mysql_error());
mysql_query("SET NAMES utf8");
if (isset($_GET['klausimas']) && isset($_GET['atsakymas1']) && isset($_GET['atsakymas2'])  && isset($_GET['atsakymas3'])){
$atsakymai = $_GET['atsakymas1']." | ".$_GET['atsakymas2']." | ".$_GET['atsakymas3'];
    mysql_query("INSERT INTO forumas_temos (pavadinimas, atsakymai) VALUES ('".$_GET['klausimas']."', '$atsakymai')") or die(mysql_error());
    echo "YRAŠYTA";
    
}
if (!isset($_GET['kurti']) && !isset($_GET['id'])){
    echo '<BR>TEMŲ SĄRAŠAS<BR><BR>
        <div style="border: 1px solid black;">
';
    $preke= mysql_query("SELECT * FROM forumas_temos") or die(mysql_error());
        while($eilute = mysql_fetch_array($preke)){
            echo '<p><h2><a href="?page=forumas&id='.$eilute['id'].'">'.$eilute['pavadinimas'].'</a></h2></p>';
        }
       
        echo '</div><p><a href="?page=forumas&kurti=kurk">Kurk temą</a></p>';
}
if (isset($_GET['kurti'])){
    ?><form action="" method="GET" style="border: 1px solid black;">
        <p>Klausimas:<br>
        <textarea type="text" name="klausimas"></textarea>
        </p>
         <p>Atsakymas1:<br>
        <input type="text" name="atsakymas1">
        </p>
         <p>Atsakymas2:<br>
        <input type="text" name="atsakymas2">
        </p>
         <p>Atsakymas3:<br>
        <input type="text" name="atsakymas3">
        </p>
        <input type="hidden" name="page" value="forumas"><br>
        <input type="submit" value="OK">
    </form><?
}
if (isset($_GET['id'])){ 
    
   
$id = $_GET['id'];
$preke= mysql_query("SELECT * FROM forumas_temos WHERE id = '$id'") or die(mysql_error());
$preke2= mysql_query("SELECT * FROM forumas_atsakymai WHERE temos_id = '$id'") or die(mysql_error());
     while($eilute2 = mysql_fetch_array($preke2)){
           $a .=  "<p>".$eilute2['komentaras']."</p>";
     }
while($eilute = mysql_fetch_array($preke)){
            echo "<p><h2>".$eilute['pavadinimas']."</h2></p>";
            $atsakymas=explode(" | ", $eilute['atsakymai']);
                       
           ?><form action="?page=forumas&id=<? echo $id; ?>&atsakyk=taip" method="POST" style="border: 1px solid black;">
        <input type="radio" name="rinkosi" value="1"><? echo $atsakymas[0]; ?> <br>    
        <input type="radio" name="rinkosi" value="2"><? echo $atsakymas[1]; ?> <br>
        <input type="radio" name="rinkosi" value="3"><? echo $atsakymas[2]; ?> <br>
        <p>
        Komentaras
        <input type="text" name="komentaras">
        </p>
        <input type="hidden" name="atsakyk" value="taip">
        <input type="hidden" name="id" value="<? echo $_GET['id']; ?>">
        <input type="hidden" name="page" value="forumas"><br>
        <input type="submit" value="OK">
    </form><? 
        } 
        
        
    
        
        echo '<a href="?page=forumas">atgal</a><br>';
    if (isset($_GET['atsakyk'])){
        if(isset($_POST['rinkosi'])){
                  
        mysql_query("INSERT INTO forumas_atsakymai (temos_id, atsakymas, komentaras)
            VALUES ('".$_GET['id']."', '".$_POST['rinkosi']."', '".$_POST['komentaras']."')") or die(mysql_error());
    echo 'Atsakyta<br>';
    echo 'Statistika:<br><div style="border: 1px solid black;">';
    $preke= mysql_query("SELECT * FROM forumas_atsakymai WHERE temos_id = '".$_GET['id']."' ") or die(mysql_error());
   $balsuota=0;
    while($eilute = mysql_fetch_array($preke)){
      if ($eilute['atsakymas']==1) { $a = $a+1;}
      if ($eilute['atsakymas']==2) { $b = $b+1;}
       if ($eilute['atsakymas']==3) { $c = $c+1;}
     $balsuota = $balsuota+1;   
   }
   $preke= mysql_query("SELECT * FROM forumas_temos WHERE id = '".$_GET['id']."'") or die(mysql_error());
    $eilute = mysql_fetch_array($preke);
    $atsakymas=explode(" | ", $eilute['atsakymai']);
   echo $atsakymas[0].': '.$a.'<br>';
   echo $atsakymas[1].': '.$b.'<br>';
   echo $atsakymas[2].': '.$c.'<br>';
   echo 'Balsuota: '.$balsuota.'<br></div>';
   
    echo '<a href="?page=forumas">atgal</a>';
    }
    else {
        echo "NEPASIRINKTAS ATSAKYMAS";
    }
    
    }
    
    echo $a;
}
?>
