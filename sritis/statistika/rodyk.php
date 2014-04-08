<?php
$html='Puslapio pagrindinė direktorija: '.$this->baseurl("");
$html.= '<b><div class="statistika">';
$html.= "Per parą apsilankė: " .$this->duomenys;
$html.= '</div>';

echo $html;