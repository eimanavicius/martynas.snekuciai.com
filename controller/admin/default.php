<?php
mysql_connect("localhost", "simne", "a7mGc4V4") or die(mysql_error());
mysql_select_db("simne_demo") or die(mysql_error());
mysql_query("SET NAMES utf8");

if($_POST){
mysql_query("INSERT INTO naujienos (pavadinimas,  tekstas, tema) VALUES ('".$_POST['pavadinimas']."','".$_POST['tekstas']."', '".$_POST['tema']."')") or die(mysql_error());
}


?>