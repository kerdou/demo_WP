<div id="apiKey">
    <p><strong>Important. Une clé API est nécessaire pour afficher les cartes Google.</strong></p>
    <a href="https://console.developers.google.com/" target="_blank" class="button-primary">Obtenir une clé API gratuitement </a>
    <p>Après création de la clé API, collez-la ci-dessous.</p>
    <form method="post" action="options.php"></form>
    <p>Cela ne prendra pas plus de 5 minutes avant que les cartes s'affichent.</p>
</div>

<form method="post" action="options.php">
    <?php
        settings_fields("cefiiMap-section");
        do_settings_sections("Cefii_Map");
        submit_button("Enregistrer la clé");
    ?>
</form>

<div class="wrapCefiiMap">
    <div id="menuMap">
        <ul>
            <li id="active">Créer une carte</li>
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

<h2>CEFii Map</h2>
<h3 class="title">Créer une carte :</h3>
<form id="formMap" action="?page=Cefii_Map&action=createmap" method="POST">
    <p class="errorCefiiMap" id="Cm-title-error">Veuillez renseigner un titre</p>
    <p>
        <label for="Cm-title">Titre* :</label><br />
        <input type="text" id="Cm-title" name="Cm-title" />
    </p>
    <p class="errorCefiiMap" id="Cm-lat-error">Veuillez renseigner une latitude</p>
    <p>
        <label for="Cm-latitude">Latitude* :</label><br />
        <input type="text" id="Cm-latitude" name="Cm-latitude" />
    </p>
    <p class="errorCefiiMap" id="Cm-long-error">Veuillez renseigner une longitude</p>
    <p>
        <label for="Cm-longitude">Longitude* :</label><br />
        <input type="text" id="Cm-longitude" name="Cm-longitude" />
    </p>
    <p>
        <input type="button" id="bt-map" value="Enregistrer" class="button-primary" />
    </p>
    <small>* champs obligatoires</small>
</form>
</div>