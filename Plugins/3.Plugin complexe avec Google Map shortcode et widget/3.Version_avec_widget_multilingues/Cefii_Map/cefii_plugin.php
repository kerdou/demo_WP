<?php

class Cefii_Map {    

    // à l'installation du plugin on crée la table dans la DB
    function cefii_map_install(){
        global $wpdb;
        $table_site = $wpdb->prefix.'cefiimap';
        if($wpdb->get_var("SHOW TABLES LIKE '$table_site'")!=$table_site) {
            $sql= "CREATE TABLE `$table_site`(`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY , `titre` TEXT NOT NULL,`longitude` TEXT NOT NULL, `latitude` TEXT NOT NULL)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
            require_once(ABSPATH.'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }

    /**
     * création du menu "Réglages > Cefii Map”
     * au chargement de la page d'options: on charge tous les scripts dans le <header> de WP avec add_action()
     */
    function init(){
        if(function_exists('add_options_page')) {
            $mapage = add_options_page('CEFii Map', 'CEFii Map', 'administrator', dirname(__FILE__), array($this, 'cefii_map_admin_page'));
            add_action('load-'.$mapage, array($this,'cefii_map_admin_header'));
        }
    }

    // liste des CSS et des scripts JS à charger au chargement de la page "Réglages > Cefii Map” et sur n'importe quelle page du site
    function cefii_map_admin_header(){
        wp_register_style('cefii_map_css', plugins_url('css/admin-cefii-map.css', __FILE__));
        wp_enqueue_style('cefii_map_css');
        wp_enqueue_script('cefii_map_js', plugins_url('js/admin-cefii-map.js', __FILE__), array('jquery'));
        wp_localize_script( 'cefii_map_js', 'textJs', array(
            'confirmation' => __( 'Do you want to delete this map?', 'Cefii_Map' )
        ));
        wp_enqueue_script('google_map_js', 'https://maps.googleapis.com/maps/api/js?key='.get_option('cleApi'));
    }

    // fonction dédiée au chargement des pages "Réglages > Cefii Map” pour la création des maps et de modif des maps existantes 
    function cefii_map_admin_page(){

        // charge la page de création de map ou d'éditoin
        if(isset($_GET['p']) && $_GET['p']=='map') {
            require_once('template-map.php');
            } else {
            require_once('template-admin.php');
        }

        // traitement de l'attribut "action"
        if(isset($_GET['action'])) {
            // en cas de création de map
            if($_GET['action'] == 'createmap') {
                if((trim($_POST['Cm-title']) != '') && (trim($_POST['Cm-latitude']) != '') && (trim($_POST['Cm-longitude'] )!= '')){
                    $insertmap = $this->insertmap($_POST['Cm-title'],$_POST['Cm-latitude'],$_POST['Cm-longitude']);
                    if($insertmap){                            
                        ?>
                        <script>
                            <?php
                            $location = get_bloginfo('url').'/wp-admin/options-general.php?page=Cefii_Map&map=ok';
                            ?>
                            window.location = "<?php echo $location; ?>";
                        </script>
                        <?php
                    } else {
                    echo '<p class="erreur">'. __('An error has occured', 'Cefii_Map') .'</p>';
                    }
                } else {
                echo '<p class="erreur">'. __('No field must be left empty', 'Cefii_Map') .'</p>';
                }
            // en cas de mise à jour de map    
            } elseif ($_GET['action'] == 'updatemap') {
                if((trim($_POST['Cm-title']) != '') && (trim($_POST['Cm-latitude']) != '') && (trim($_POST['Cm-longitude']) != '') && (trim($_POST['Cm-id']) != '')){
                    $updatemap = $this->updatemap($_POST['Cm-id'],$_POST['Cm-title'],$_POST['Cm-latitude'],$_POST['Cm-longitude']);
                    if($updatemap){
                        ?>
                            <script>
                            <?php
                                $location = get_bloginfo('url').'/wp-admin/options-general.php?page=Cefii_Map&p=map&id='.$_POST['Cm-id'].'&map=ok';
                            ?>
                            window.location= "<?php echo $location; ?>";
                            </script>
                        <?php
                    } else {
                        echo '<p class="erreur">'. __('An error has occured', 'Cefii_Map') .'</p>';
                    }
                } else {
                    echo '<p class="erreur">'. __('No field must be left empty', 'Cefii_Map') .'</p>';
                }
            // en cas de suppression de map    
            } elseif ($_GET['action'] == 'deletemap'){
                if(trim($_POST['Cm-id']) != ''){
                    $deletemap=$this->deletemap($_POST['Cm-id']);
                    if($deletemap){
                        ?>
                            <script>
                                <?php
                                    $location = get_bloginfo('url').'/wp-admin/options-general.php?page=Cefii_Map&map=deleteok';
                                ?>
                                window.location= "<?php echo $location; ?>";
                            </script>
                        <?php
                    } else {
                        echo '<p class="erreur">'. __('An error has occured', 'Cefii_Map') .'</p>';
                    }
                }
            }
        }

        // traitement de l'attribut "map"
        if(isset($_GET['map'])){
            // en cas de carte bien crée
            if($_GET['map'] == 'ok'){
                echo '<p class="succes">'. __('The map has been successfully registered', 'Cefii_Map') .'</p>';
            // cas de map bien supprimée    
            } elseif($_GET['map'] == 'deleteok'){
                echo '<p class="deleteSucces">'. __('The map has been successfully deleted', 'Cefii_Map') .'</p>';
            }
        }    
    }

    // insert DB de map
    function insertmap($title,$lat,$long){
        global $wpdb;
        $table_map = $wpdb->prefix.'cefiimap';
        $sql = $wpdb->prepare("INSERT INTO ".$table_map."(titre, latitude, longitude) VALUES (%s,%s,%s)", $title, $lat, $long);
        $req = $wpdb->query($sql);
        return $req;
    }

    // update DB de map
    function updatemap($id,$title,$lat,$long){
        global $wpdb;
        $table_map = $wpdb->prefix.'cefiimap';
        $sql = $wpdb->prepare("UPDATE ".$table_map." SET titre=%s, latitude=%s, longitude=%s WHERE id=%d", $title,$lat,$long,$id);
        $req = $wpdb->query($sql);
        if ($req === false){
            $result = false;
        } else{
            $result = true;
        }
        return $result;
    }

    // delete DB de map
    function deletemap($id){
        global $wpdb;
        $table_map = $wpdb->prefix.'cefiimap';
        $sql = $wpdb->prepare("DELETE FROM ".$table_map." WHERE id=%d LIMIT 1",$id);
        $req = $wpdb->query($sql);
        return $req;
    }

    // récupérer toutes les maps
    public static function getmaplist(){
        global $wpdb;
        $table_map = $wpdb->prefix.'cefiimap';
        $sql = "SELECT * FROM ".$table_map;
        $maplist = $wpdb->get_results($sql);
        return $maplist;
    }  

    // récupérer une map en particulier
    public static function getmap($id){
        global $wpdb;
        $table_map = $wpdb->prefix.'cefiimap';
        $sql = $wpdb->prepare("SELECT * FROM ".$table_map." WHERE id=%d LIMIT 1",$id);
        $map = $wpdb->get_results($sql);
        return $map;
    }

    // champ affichant la clé API de façon protégée
    function champ_cleApi(){
        ?>
            <input type="text" name="cleApi" id="cleApi" value="<?php echo get_option('cleApi'); ?>" size="50" />
        <?php
    }

    // création de l'option WP pour enregistrer la clé API Google Map car la tale CefiiMap n'a pas été prévue pour ça  
    function cefiiMap_options(){
        add_settings_section("cefiiMap-section", '', null, "Cefii_Map");
        add_settings_field("cleApi", __('Your API key', 'Cefii_Map'), array($this, 'champ_cleApi'), "Cefii_Map", "cefiiMap-section"); // Votre clé API
        register_setting("cefiiMap-section", "cleApi");
    }

    // ajout du script déclarant la API Google Map dans le <header> de WP
    function cefii_map_front_header(){
        wp_enqueue_script('google_map_js', 'https://maps.googleapis.com/maps/api/js?key='.get_option('cleApi'));
    }

    // affichage d'une Google Map dans les articles et les pages
    function cefii_map_shortcode($att){
        $map=$this->getmap($att['id']);
        ob_start();
        ?>
            <div id="map<?php echo $map[0]->id; ?>" style="width:400px;height:400px;"></div>
            <script>
                var coord = new google.maps.LatLng(<?php echo $map[0]->latitude; ?>,
                <?php echo $map[0]->longitude; ?>);
                var options = {
                    center: coord,
                    zoom: 10,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map = new google.maps.Map(document.getElementById("map<?php echo $map[0]->id; ?>"), options);
            </script>
        <?php return ob_get_clean();
    }

    // chargement des fichiers de traduction
    function cefii_map_load_textdomain() {
        load_plugin_textdomain( 'Cefii_Map', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
    }

}