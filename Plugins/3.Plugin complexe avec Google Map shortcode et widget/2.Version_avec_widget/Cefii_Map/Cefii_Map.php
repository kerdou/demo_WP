<?php
/*
Plugin Name: Cefii Map
Description: permet d'insérer des cartes Google via un shortcode
Version: 1.0
Author: Gwen
Text Domain: Cefii_Map
Domain Path: /languages/
*/


class Cefii_Map_plugin {
    public function __construct(){
        include_once plugin_dir_path(__FILE__).'/cefii_plugin.php'; // chargement du fichier contenant le "gros" du plugin
        include_once plugin_dir_path( __FILE__ ).'/cefii-map-widget.php'; // chargement du fichier contenant le widget

        if (class_exists('Cefii_Map')) { // lancement du plugin
            $inst_map = new Cefii_Map();
        }

        // hooks lancant le plugin
        if(isset($inst_map)){
            register_activation_hook(__FILE__, array($inst_map, 'cefii_map_install')); // installation du plugin
            add_action('admin_menu', array($inst_map, 'init')); // création du menu "Réglages > Cefii Map”
            add_action("admin_init", array($inst_map, 'cefiiMap_options')); // création de l'option WP pour enregistrer la clé API Google Map car la tale CefiiMap n'a pas été prévue pour ça 
            add_action('wp_enqueue_scripts', array($inst_map,'cefii_map_front_header')); // ajout du script déclarant la API Google Map dans le <header> de WP
            add_action('widgets_init', function(){ // lancement du widget
                register_widget('CefiiMapWidget');
            });
            // add_action('plugins_loaded', array($inst_map,'cefii_map_load_textdomain')); // lancement de la traduction du plugin
            if(function_exists('add_shortcode')){ // lancement du shortcode
                add_shortcode('cefiimap', array($inst_map,'cefii_map_shortcode'));
            }
        }
    }
}

new Cefii_Map_plugin();