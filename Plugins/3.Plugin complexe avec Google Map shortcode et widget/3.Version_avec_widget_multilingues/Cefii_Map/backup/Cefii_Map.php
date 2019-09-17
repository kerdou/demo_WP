<?php
/*
Plugin Name: Cefii Map
Description: permet d'insérer des cartes Google via un shortcode
Version: 1.0
Author: Gwen
Text Domain: Cefii_Map
Domain Path: /languages/
*/
__('Inserts Google Maps via a shortcode','Cefii_Map');

// vérifier si la classe Cefii_Map n'existe pas déjà
if(!class_exists('Cefii_Map')){

    class Cefii_Map {
        
        // fonction à l'installation du plugin
        function cefii_map_install(){
            global $wpdb; // classe globale wpdb accessible via la variable $wpdb. Permet de se connecter directemment à la DB.
            $table_site = $wpdb->prefix.'cefiimap'; // pour récupérer les préfixes de tables
            if($wpdb->get_var("SHOW TABLES LIKE '$table_site'") != $table_site){ // get_var() permet de vérifier si une table du même nom existe, si elle n'existe pas, création de la table
                $sql= "CREATE TABLE `$table_site`(`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY , `titre` TEXT NOT NULL,`longitude` TEXT NOT NULL, `latitude` TEXT NOT NULL)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
                require_once(ABSPATH.'wp-admin/includes/upgrade.php'); // fichier necessaire pour l'accés à la DB
                dbDelta($sql); // fonction permettant de créer et mettre à jour des tables
            }
        }

        // création de 'CEFii Map' dans 'Réglages' dans le menu d'admin. 
        // Lancé par add_action('admin_menu', array($inst_map, 'init'));
        function init(){
            if (function_exists('add_options_page')) {
                $mapage = add_options_page('CEFii Map', 'CEFii Map', 'manage_options', dirname(__FILE__), array($this, 'cefii_map_admin_page')); // le $this ne marchait pas, je l'ai remplacé par $inst_map. Depuis le CEFii Map s'affiche dans le menu.
                add_action('load-'.$mapage, array($this,'cefii_map_admin_header')); // lancement de cefii_map_admin_header() au chargement de la page d'admin
            }
        }

        // pour appeler le formulaire de création de carte
        // appelé depuis le dernier paramétre de add_options_page au sein de init()
        function cefii_map_admin_page(){

            if(isset($_GET['p']) && $_GET['p'] == 'map'){
                require_once('template-map.php');
                } else {
                require_once('template-admin.php');
            }

            // lancé par le action="?page=Cefii_Map&action=createmap" du formulaire de template-admin.php
            if(isset($_GET['action'])){
                if ($_GET['action'] == 'createmap'){
                    if ( (trim($_POST['Cm-title']) != '') && (trim($_POST['Cm-latitude']) != '') && (trim($_POST['Cm-longitude']) != '') ){
                        $insertmap = $this->insertmap($_POST['Cm-title'], $_POST['Cm-latitude'], $_POST['Cm-longitude']); // insertmap() est la méthode d'insert et de cnx à la DB

                        if($insertmap){ // si $insertmap est ok, renvoi vers la page de création de la map avec un message pour indiquer que la création s'est bien passé 
                        ?>
                            <script>
                                <?php
                                    $location = get_bloginfo('url').'/wp-admin/options-general.php?page=Cefii_Map&map=ok';
                                ?>
                                window.location= "<?php echo $location; ?>";
                            </script>
                        <?php
                        } else {
                            echo '<p class="erreur">'. __('An error has occured', 'Cefii_Map') .'</p>'; // Une erreur est survenue
                        }
                    } else {
                        echo '<p class="erreur">'. __('No field must be left empty', 'Cefii_Map') .'</p>'; // Veuillez remplir tous les champs
                    }
                } elseif ($_GET['action'] == 'updatemap'){
                    if( (trim($_POST['Cm-title']) != '') && (trim($_POST['Cm-latitude']) != '') && (trim($_POST['Cm-longitude']) != '') && (trim($_POST['Cm-id']) != '') ){
                        $updatemap = $this->updatemap($_POST['Cm-id'], $_POST['Cm-title'], $_POST['Cm-latitude'], $_POST['Cm-longitude']);
                        if($updatemap){
                            ?>
                                <script>
                                    <?php
                                        $location = get_bloginfo('url').'/wp-admin/options-general.php?page=Cefii_Map&p=map&id=' . $_POST['Cm-id'] . '&map=ok';
                                    ?>
                                    window.location= "<?php echo $location; ?>";
                                </script>
                            <?php
                        } else {
                        echo '<p class="erreur">'. __('An error has occured', 'Cefii_Map') .'</p>'; // Une erreur est survenue
                        }
                    } else {
                    echo '<p class="erreur">'. __('No field must be left empty', 'Cefii_Map') .'</p>'; // Veuillez remplir tous les champs
                    }
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
                        echo '<p class="erreur">'. __('An error has occured', 'Cefii_Map') .'</p>'; // Une erreur est survenue
                        }
                    }
                }             
            } 


            // message s'affichant sous le formulaire s'il a été bien enregistré
            if(isset($_GET['map'])){
                if($_GET['map'] == 'ok'){
                echo '<p class="succes">'. __('The map has been successfully registered', 'Cefii_Map') .'</p>'; // La carte a bien été enregistrée
                } elseif($_GET['map'] == 'deleteok'){
                    echo '<p class="deleteSucces">'. __('The map has been successfully deleted', 'Cefii_Map') .'</p>'; // La carte a bien été supprimée
                }
            }
        }    

        // chargement de fichiers côté admin
        // méthode de chargement des fichiers CSS et JS du menu Cefii map
        // appelé par au sein de init()
        function cefii_map_admin_header(){
            wp_register_style('cefii_map_css', plugins_url('css/admin-cefii-map.css', __FILE__)); // appel du fichier admin-cefii-map.css
            wp_enqueue_style('cefii_map_css'); // rajout de admin-cefii-map.css dans la file des fichiers CSS que WP doit charger
            wp_enqueue_script('cefii_map_js', plugins_url('js/admin-cefii-map.js', __FILE__), array('jquery')); // rajout de admin-cefii-map.js dans la file des fichiers JS que WP doit charger
            wp_localize_script( 'cefii_map_js', 'textJs', array('confirmation' => __( 'Do you want to delete this map?', 'Cefii_Map' ), )); // interfacage de traduction du texte de la boite de confirmation
            wp_enqueue_script('google_map_js', 'http://maps.googleapis.com/maps/api/js?key='.get_option('cleApi')); // script de l'API Google Map côté admin
        }

        // ajout des coordonnées dans la DB
        // lancé depuis cefii_map_admin_page()
        function insertmap($title, $lat, $long){
            global $wpdb;
            $table_map = $wpdb->prefix . 'cefiimap';
            $sql = $wpdb->prepare("INSERT INTO " . $table_map . "(titre, latitude, longitude) VALUES (%s,%s,%s)", $title, $lat, $long);
            $req = $wpdb->query($sql);
            return $req;
        }

        // récupération de la table des maps
        // appelé depuis template-admin.php
        public static function getmaplist(){
            global $wpdb;
            $table_map = $wpdb->prefix.'cefiimap';
            $sql = "SELECT * FROM ".$table_map;
            $maplist = $wpdb->get_results($sql);
            return $maplist;
        }

        // afficher le contenu de chaque map individuellement
        // appelé depuis les onglets de chaque map depuis template-map.php et template-map.php
        public static function getmap($id){
            global $wpdb;
            $table_map = $wpdb->prefix.'cefiimap';
            $sql = $wpdb->prepare("SELECT * FROM ".$table_map." WHERE id=%d LIMIT 1",$id);
            $map = $wpdb->get_results($sql);
            return $map;
        }

        // mise à jour des maps
        function updatemap($id, $title, $lat, $long){
            global $wpdb;
            $table_map = $wpdb->prefix.'cefiimap';
            $sql = $wpdb->prepare("UPDATE ".$table_map." SET titre=%s,latitude=%s,longitude=%s WHERE id=%d", $title, $lat, $long, $id);
            $req = $wpdb->query($sql);
            if ($req === false) {
                $result = false;
            } else {
                $result = true;
            }
            return $result;
        }

        // suppression d'une map
        function deletemap($id){
            global $wpdb;
            $table_map = $wpdb->prefix.'cefiimap';
            $sql = $wpdb->prepare("DELETE FROM ".$table_map." WHERE id=%d LIMIT 1", $id);
            $req = $wpdb->query($sql);
            return $req;
        }  
        
        // champ de la clé API Google map
        // lancé par la fonction cefiiMap_options() située juste en dessous
        function champ_cleApi(){
            ?>
                <input type="text" name="cleApi" id="cleApi" value="<?php echo get_option('cleApi'); ?>" size="50" />
            <?php
        }

        // gestion de l'intégration de la clé API google maps
        // lancé depuis add_action("admin_init") de if(isset($inst_map))
        function cefiiMap_options(){
            add_settings_section("cefiiMap-section", '', null, "Cefii_Map"); // pour ajouter un groupe d'options
            add_settings_field("cleApi", __('Your API key','Cefii_Map'), array($this,'champ_cleApi'), "Cefii_Map", "cefiiMap-section"); // pour ajouter le champ "clé API"
            register_setting("cefiiMap-section", "cleApi"); // pour enregisrer l'option au sein de WordPress
        }

        // chargement de fichiers côté front        
        function cefii_map_front_header(){
            wp_enqueue_script('google_map_js', 'http://maps.googleapis.com/maps/api/js?key='.get_option('cleApi')); // script de l'API Google Map côté front
        }

        // shortcode des maps pour le front
        function cefii_map_shortcode($att){
            $map = $this->getmap($att['id']);
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

        // fonction de chargement des fichiers de langue
        // lancée depuis le lanceur de hook
        function cefii_map_load_textdomain() {
            load_plugin_textdomain( 'Cefii_Map', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
        }
    } 
}

// vérifier si la classe Cefii_Map existe déjà
if(class_exists('Cefii_Map')){
    $inst_map = new Cefii_Map();

    // launcher des hooks
    if(isset($inst_map)){
        register_activation_hook(__FILE__, array($inst_map, 'cefii_map_install')); // register_activation_hook() se lance à l'activation du plugin et lance la fonction 'cefii_map_install'        
        add_action('admin_menu', array($inst_map, 'init')); // Lancement de la fonction init() pour faire la création de 'CEFii Map' dans 'Réglages' dans le menu d'admin.
        add_action("admin_init", array($inst_map, 'cefiiMap_options')); // lancement de la fonction 'cefiiMap_options' pour la gestion de la clé API Google map
        add_action('wp_enqueue_scripts', array($inst_map, 'cefii_map_front_header')); // chargement des fichiers pour le côté front
        add_action('plugins_loaded', array($inst_map,'cefii_map_load_textdomain')); // chargement des fichiers de langue
        
        // lancement de la méthode de short codes 'cefii_map_shortcode'
        if(function_exists('add_shortcode')){
            add_shortcode('cefiimap', array($inst_map, 'cefii_map_shortcode'));
        }
    }  
}

    



