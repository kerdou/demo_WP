<?php
/*
Plugin Name: Cefii Contact
Description: Widget permettant à un internaute de communiquer son téléphone afin d'être
rappelé
Version: 1.0
*/

class Cefii_Contact {
    function __construct(){
        include_once plugin_dir_path( __FILE__ ).'/cefii-contact-widget.php';
        add_action('widgets_init', function(){
            register_widget('Cefii_Contact_Widget');
        });

        include_once plugin_dir_path( __FILE__ ).'/cefii-contact-plugin.php';
        $inst_contact = new Cefii_Contact_Plugin();
        register_activation_hook(__FILE__, array($inst_contact, 'cefii_contact_install'));

        add_action('wp_head', array($inst_contact, 'cefii_contact_front_head'));

        if(isset($_POST['action'])) {
            add_action('wp_ajax_nopriv_cefii_contact', array($inst_contact,'cefii_contact_front_ajax'));
            add_action('wp_ajax_cefii_contact', array($inst_contact,'cefii_contact_front_ajax'));
        }

        add_action('admin_menu', array($inst_contact,'cefii_contact_menu'));  
        
        add_action('wp_ajax_suppr_cefii_contact', array($inst_contact,'cefii_contact_admin_ajax'));

        add_action( 'admin_bar_menu', array($inst_contact,'ajout_icone_toolbar'), 100 );
        add_action('admin_enqueue_scripts', array($inst_contact, 'cefii_contact_add_style_admin'));
    }
}

new Cefii_Contact();