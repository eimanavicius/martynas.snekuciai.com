<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Vasara</title>
        <LINK href="http://www.greitas.com/vasara/img/stilius.css" rel="stylesheet" type="text/css">
           <base href="http://www.greitas.com/" >
		
    </head>
    <body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
        <script>
        function rodyk (id){
            mydiv = document.getElementById(id);
                
mydiv.style.display = "block"; //to show it
     
        }
         function slepk (id){
            mydiv = document.getElementById(id);
                 
mydiv.style.display = "none"; //to show it
     
        }
    
        
    </script>
        <div class="head">
        <div class="ritasi">
<?php

       $this->krauk('meniu', 0);
       $this->slaidas();
        ?>
            <div class="turinys">
       