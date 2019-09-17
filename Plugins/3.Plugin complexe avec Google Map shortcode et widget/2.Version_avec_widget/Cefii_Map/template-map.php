<!-- onglets pour la création de map et lister les maps existantes -->
<div id="menuMap">
    <ul>
        <li><a href="?page=Cefii_Map">Créer une carte</a></li>
        <?php
            $maplist = $this->getmaplist();

            foreach($maplist as $getmap){
                if($_GET['id']==$getmap->id){
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

<!-- regroupe tout ce qiu est sous les onglets -->
<div class="wrapCefiiMap">

    <!-- titre de la carte courante -->
    <h2>CEFii Map</h2>
    <?php $map = $this->getmap($_GET['id']); ?>
    <h3 class="title">Carte : <?php echo $map[0]->titre; ?></h3>

    <!-- shortcode -->
    <div id="placecode">
        <p>Copiez (ctrl+c) le code et collez (ctrl+v) dans la page ou l'article où vous voulez voir apparaître votre carte :
            <input type="text" readonly value="[cefiimap id=&quot;<?php echo $map[0]->id; ?>&quot;]"/>
        </p>
    </div>

    <!-- settings et modifs de la carte -->
    <div class="left">
        <h3 class="title">Paramètres :</h3>
        <form id="formMap" action="?page=Cefii_Map&action=updatemap" method="post">
            <input type="hidden" name="Cm-id" value="<?php echo $map[0]->id ?>" />
            <p class="errorCefiiMap" id="Cm-title-error">Veuillez renseigner un titre</p>
            <p>
                <label for="Cm-title">Titre* :</label><br />
                <input type="text" id="Cm-title" name="Cm-title" value="<?php echo $map[0]->titre; ?>" />
            </p>
            <p class="errorCefiiMap" id="Cm-lat-error">Veuillez renseigner une latitude</p>
            <p>
                <label for="Cm-latitude">Latitude* :</label><br />
                <input type="text" id="Cm-latitude" name="Cm-latitude" value="<?php echo $map[0]->latitude; ?>" />
            </p>
            <p class="errorCefiiMap" id="Cm-long-error">Veuillez renseigner une longitude</p>
            <p>
                <label for="Cm-longitude">Longitude* :</label><br />
                <input type="text" id="Cm-longitude" name="Cm-longitude" value="<?php echo $map[0]->longitude; ?>" />
            </p>
            <p>
                <input type="button" id="bt-map" value="Mettre à jour" class="button-primary" />
            </p>
            <small>* champs obligatoires</small>
        </form>

        <!-- bouton de suppression de la carte courante -->
        <form id="formSuppr" action="?page=Cefii_Map&action=deletemap" method="post">
            <p>
                <input type="hidden" name="Cm-id" value="<?php echo $map[0]->id ?>" />
            </p>
            <p>
                <input type="button" id="suppr-map" value="Supprimer la carte" class="button-secondary" />
            </p>
        </form>

    </div>

    <!-- affichage de l'aperçu de la map courante -->
    <div class="left">
        <h3 class="title">Aperçu :</h3>
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

    <!-- sert à faire un clear:both des <div class="left"> qui a un float:left -->
    <div class="clear"></div>

</div>