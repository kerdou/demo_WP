<div id="menuMap">
    <ul>
        <li><a href="?page=Cefii_Map"><?php _e('Create map','Cefii_Map'); ?></a></li> <!-- Créer une carte -->
        <?php
            $maplist = $this->getmaplist();
            foreach($maplist as $getmap){
                if($_GET['id'] == $getmap->id){
                    $active = " id=\"active\" ";
                } else {
                    $active = "";
                }
                echo "<li ".$active.">
                <a href=\"?page=Cefii_Map&p=map&id=".$getmap->id."\">".$getmap->titre."</a>
                </li>";
            }
        ?>
    </ul>
</div>

<div class="wrapCefiiMap">
    <h2><?php _e('CEFii Map','Cefii_Map'); ?></h2> <!-- CEFii Map -->
    <?php $map = $this->getmap($_GET['id']); ?>
    <h3 class="title"><?php _e('Map : ','Cefii_Map'); ?><?php echo $map[0]->titre; ?></h3> <!-- Carte :  -->
    <div class="left">
        <h3 class="title"><?php _e('Settings : ','Cefii_Map'); ?></h3> <!-- Paramètres : -->
        <div id="placecode">
            <p><?php _e('Copy (ctrl+c) the code and paste it (ctrl+v) into the page or article where you want it to be displayed','Cefii_Map'); ?>
                <input type="text" readonly value="[cefiimap id=&quot;<?php echo $map[0]->id;?>&quot;]"/> 
            </p>  <!-- Copiez (ctrl+c) le code et collez (ctrl+v) dans la page ou l'article où vous voulez voir apparaître votre carte : -->
        </div>
        <form id="formMap" action="?page=Cefii_Map&action=updatemap" method="post">
            <input type="hidden" name="Cm-id" value="<?php echo $map[0]->id ?>" />
            <p class="errorCefiiMap" id="Cm-title-error"><?php _e('Please enter a title','Cefii_Map'); ?></p> <!-- Veuillez renseigner un titre -->
            <p>
                <label for="Cm-title"><?php _e('Title* :','Cefii_Map'); ?></label><br /> <!-- Titre* : -->
                <input type="text" id="Cm-title" name="Cm-title" value="<?php echo $map[0]->titre; ?>" />
            </p>
            <p class="errorCefiiMap" id="Cm-lat-error"><?php _e('Please enter a latitude','Cefii_Map'); ?></p> <!-- Veuillez renseigner une latitude -->
            <p>
                <label for="Cm-latitude"><?php _e('Latitude* :','Cefii_Map'); ?></label><br /> <!-- Latitude* : -->
                <input type="text" id="Cm-latitude" name="Cm-latitude" value="<?php echo $map[0]->latitude; ?>" />
            </p>
            <p class="errorCefiiMap" id="Cm-long-error"><?php _e('Please enter a longitude','Cefii_Map'); ?></p> <!-- Veuillez renseigner une longitude -->
            <p>
                <label for="Cm-longitude"><?php _e('Longitude* :','Cefii_Map'); ?></label><br /> <!-- Longitude* : -->
                <input type="text" id="Cm-longitude" name="Cm-longitude" value="<?php echo $map[0]->longitude; ?>" />
            </p>
            <p>
                <input type="button" id="bt-map" value="<?php _e('Update','Cefii_Map'); ?>" class="button-primary" /> <!-- value="Mettre à jour" -->
            </p>
            <small><?php _e('* mandatory fields','Cefii_Map'); ?></small> <!-- * champs obligatoires -->
        </form>
        <form id="formSuppr" action="?page=Cefii_Map&action=deletemap" method="post">
            <p>
                <input type="hidden" name="Cm-id" value="<?php echo $map[0]->id ?>" />
            </p>
            <p>
                <input type="button" id="suppr-map" value="<?php _e('Delete','Cefii_Map'); ?>" class="button-secondary" /> <!-- value="supprimer la carte" -->
            </p>
        </form>
    </div>

    <div class="left">
        <h3 class="title"><?php _e('Preview : ','Cefii_Map'); ?></h3> <!-- Aperçu : -->
        <div id="map"></div>
        <script>
            var coord = new google.maps.LatLng( <?php echo $map[0]->latitude; ?> , <?php echo $map[0]->longitude; ?> );
            var options = {
                center: coord,
                zoom: 10,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("map"), options);
        </script>
    </div>
    <div class="clear"></div>
</div>

