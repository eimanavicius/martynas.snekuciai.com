 <ul>
            <li ><a href=".">PAGRINDINIS</a></li>
            <li onMouseOver="rodyk('meniu1')" onmouseout="slepk('meniu1')" >NAUJIENOS
                <div class="paslepta" id="meniu1">
                    <ul>
                        <!--<li><a href="?page=naujienos&kat=Internetas">Puslapis</a><br></li>
                        <li><a href="?page=naujienos&kat=Gyvenimas">Gyvenimas</a><br></li>
                        <li><a href="?page=naujienos">Linksmos</a><br></li>
                        -->
                        <? 
                        $this->meniu= "visas";
                        $this->krauk('naujienos',0);
                        unset($this->meniu);?>
                    </ul>
                </div>
            </li>
            <li ><a href="muzika">MUZIKA</a></li>
            <li onMouseOver="rodyk('meniu2')" onmouseout="slepk('meniu2')">FOTO
            <div class="paslepta" id="meniu2">
                
            <? include ('./controller/foto/fotolistas.php'); ?> 
               
            </div>
            </li>
            <li onMouseOver="rodyk('meniu3')" onmouseout="slepk('meniu3')">INFORMACIJA
            <div class="paslepta" id="meniu3">
                <ul>
                    <li><a href="cv/?apie">Apie mane</a></li>
                    <li><a href="cv/?apie=cv">CV</a></li>
                    <li><a href="cv/?apie=darbai">Atlikti darbai</a></li>
                </ul>
            </div>
            </li>
            
          
        </ul>
