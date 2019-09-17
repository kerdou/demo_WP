<!-- section pour la récupération d'une nouvelle clé API Google Map -->
<div id="apiKey">
    <p><strong><?php _e('Caution. An API key is required in order to display the Google Maps','Cefii_Map'); ?></strong></p> <!-- Important. Une clé API est nécessaire pour afficher les cartes Google. -->
    <a href="https://console.developers.google.com/" target="_blank" class="button-primary"><?php _e('Obtain an API key for free','Cefii_Map'); ?></a> <!-- Obtenir une clé API gratuitement -->
    <p><?php _e('Once the API key is created, please paste it here','Cefii_Map'); ?></p> <!-- Après création de la clé API, collez-la ci-dessous. -->
    <form method="post" action="options.php"></form>
    <p><?php _e('The map display can take up to 5 minutes','Cefii_Map'); ?></p> <!-- Cela ne prendra pas plus de 5 minutes avant que les cartes s'affichent. -->
</div>

<!-- section affichant de maniére protegée la clé API Google Key, permet aussi de la modifier -->
<form method="post" action="options.php">
    <?php
        settings_fields("cefiiMap-section");
        do_settings_sections("Cefii_Map");
        submit_button(__('Register key', 'Cefii_Map')); // "Enregistrer la clé"
    ?>
</form>

<!-- onglets pour la création d'une nouvelle map ou la selection d'un map existante -->
<div class="wrapCefiiMap">
    <div id="menuMap">
        <ul>
            <li id="active"><?php _e('Create map','Cefii_Map'); ?></li> <!-- Créer une carte -->
            <?php
                    $maplist = $this->getmaplist();
                    foreach($maplist as $getmap){
                        echo "<li>
                        <a href=\"?page=Cefii_Map&p=map&id=".$getmap->id."\">".$getmap->titre."</a>
                        </li>";
                    }
                ?>
        </ul>
    </div>
</div>

<!-- champ pour les settings et la validation de la nouvelle map -->
<h2><?php _e('CEFii Map','Cefii_Map'); ?></h2>
<h3 class="title"><?php _e('CEFii Map','Cefii_Map'); ?></h3> <!-- CEFii Map -->
<form id="formMap" action="?page=Cefii_Map&action=createmap" method="POST">
    <p class="errorCefiiMap" id="Cm-title-error"><?php _e('Please enter a title','Cefii_Map'); ?></p> <!-- Veuillez renseigner un titre -->
    <p>
        <label for="Cm-title"><?php _e('Title* :','Cefii_Map'); ?></label><br /> <!-- Titre* : -->
        <input type="text" id="Cm-title" name="Cm-title" />
    </p>
    <p class="errorCefiiMap" id="Cm-lat-error"><?php _e('Please enter a latitude','Cefii_Map'); ?></p><!-- Veuillez renseigner une latitude -->
    <p>
        <label for="Cm-latitude"><?php _e('Latitude* :','Cefii_Map'); ?></label><br /> <!-- Latitude* : -->
        <input type="text" id="Cm-latitude" name="Cm-latitude" />
    </p>
    <p class="errorCefiiMap" id="Cm-long-error"><?php _e('Please enter a longitude','Cefii_Map'); ?></p> <!-- Veuillez renseigner une longitude -->
    <p>
        <label for="Cm-longitude"><?php _e('Longitude* :','Cefii_Map'); ?></label><br /> <!-- Longitude* : -->
        <input type="text" id="Cm-longitude" name="Cm-longitude" />
    </p>
    <p>
        <input type="button" id="bt-map" value="<?php _e('Submit','Cefii_Map'); ?>" class="button-primary" /> <!-- value="Enregistrer" -->
    </p>
    <small><?php _e('* mandatory fields','Cefii_Map'); ?></small> <!-- * champs obligatoires -->
</form>
</div>