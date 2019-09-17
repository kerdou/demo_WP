<?php

// déclaration du Widget
class CefiiMapWidget extends WP_Widget{

    function __construct() {
        $widget_options = array(
            'classname' => 'widget_cefiimap', // classe du widget dans le HTML
            'description' => 'Pour afficher une Google Map' // description du widget dans "apparences > widget"
        );
        parent ::__construct('widget-cefiiMap', 'CEFii Map', $widget_options); // rattachement à la classe WP_Widget
    }

    // récupération des données existantes avant envoi ou formulaire
    // mise à jour des données avec celles provenant du formulaire
    function update($new_instance, $old_instance){
        $instance = $old_instance; // sauvegarde des valeurs précédentes
        $instance['title'] = strip_tags($new_instance['title']); // strip_tags() permet de sécuriser les champs
        $instance['afficheTitre'] = strip_tags($new_instance['afficheTitre']); // strip_tags() permet de sécuriser les champs
        $instance['carteExistante'] = strip_tags($new_instance['carteExistante']); // strip_tags() permet de sécuriser les champs
        return $instance; // renvoi des données vers le form()
    }

    // formulaire dans "apparences > widget"
    function form($instance) {
        $defaults= array( // titre affiché du formulaire
                 'title'=>"CEFii Map"
        );
        
        $instance= wp_parse_args($instance, $defaults); // mélange des données par défaut des champs avec les données actuelles

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo 'Titre du Widget'; ?>:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php  echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('carteExistante'); ?>"><?php echo 'Sélectionnez une carte'; ?> :</label>
            <select id="<?php echo $this->get_field_id('carteExistante'); ?>" name="<?php echo $this->get_field_name('carteExistante'); ?>" >
                <option value="0"></option>
                <?php
                    $listeCartes = CEfii_Map::getmaplist();
                    foreach($listeCartes as $getmap){
                        if($instance['carteExistante'] == $getmap->id) {
                            $selected='selected';
                        } else {
                            $selected='';
                        }
                        echo '<option '.$selected.' value="'.$getmap->id.'">'.$getmap->titre.'</option>';
                    } 
                ?>
            </select>
        </p>
        <p>
            <?php echo 'Ou créez une nouvelle carte'; ?> <a href="<?php echo admin_url()."options-general.php?page=Cefii_Map"; ?>"><?php echo 'ici'; ?></a> 
        </p>
        <p>
            <?php
                if(isset($instance['afficheTitre']) && $instance['afficheTitre'] == "oui"){
                    $coche = "checked";
                } else {
                    $coche = "";
                } 
            ?>
            <label for=""><?php echo 'Voulez-vous afficher le titre de la carte?'; ?> :</label>
            <input type="checkbox" <?php echo $coche; ?> value="oui" name="<?php echo $this->get_field_name('afficheTitre'); ?>" id="<?php echo $this->get_field_id('afficheTitre'); ?>" />
            <label for="<?php echo $this->get_field_id('afficheTitre'); ?>"><?php echo 'Oui'; ?></label>
        </p> 
        <?php
    }

    // affichage du widget dans les sidebars
    function widget($args, $instance) {
        extract($args); // permet de convertir les clés d'un tableau en variables
        echo $before_widget; // balises avant le contenu, H1 par exemple

        if ($instance['title'] != '') {
            echo $before_title.$instance['title'].$after_title;
        }

        if ($instance['carteExistante'] != '0') {
            $idCarte = $instance['carteExistante'];
            $carteChoisie = Cefii_Map::getmap($idCarte);
            $titre = $carteChoisie[0]->titre;
            $latitude = $carteChoisie[0]->latitude;
            $longitude = $carteChoisie[0]->longitude;

            if ($instance['afficheTitre'] == "oui") {
                echo "<h2>".$titre."</h2>";
            } 

            ?>
                <div id="widgetmap-<?php echo $this->id; ?>" style="width:100%; height:200px; "></div>
                <script type="text/javascript">
                    var coord = new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>);
                    var options = {
                        center: coord, 
                        zoom: 10,
                        mapTypeId: google.maps.MapTypeId.ROADMAP 
                    };
                    var map = new google.maps.Map(document.getElementById("widgetmap-<?php echo $this->id; ?>"), options);
                </script>
            <?php
        }

        echo $after_widget; // balises après le contenu, <h1> par exemple
    }
}
