<?php

class Cefii_Contact_Plugin {

    // installation de la DB du mode
    function cefii_contact_install(){
        global $wpdb;
        $table_site = $wpdb->prefix.'cefiicontact';
        if($wpdb->get_var("SHOW TABLES LIKE '$table_site'") != $table_site){
            $sql= "CREATE TABLE `$table_site`(`id` BIGINT UNSIGNED NOT NULL
            AUTO_INCREMENT PRIMARY KEY , `nom` TEXT NOT NULL,`tel` TEXT NOT
            NULL)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
            require_once(ABSPATH.'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }

    // insertion de datas dans la DB
    function insertData($nom,$tel) {
        global $wpdb;
        $table = $wpdb->prefix.'cefiicontact';
        $sql = $wpdb->prepare("INSERT INTO ".$table."(nom,tel) VALUES (%s,%s)", $nom, $tel);
        $req = $wpdb->query($sql);
        return $req;
    }

    // récupération de datas dans la DB
    function selectData() {
        global $wpdb;
        $table = $wpdb->prefix.'cefiicontact';
        $sql = "SELECT * FROM ".$table;
        $liste = $wpdb->get_results($sql);
        return $liste;
    }

    // suppression de data dans la DB
    function deleteData($id) {
        global $wpdb;
        $table = $wpdb->prefix.'cefiicontact';
        $sql = $wpdb->prepare("DELETE FROM ".$table." WHERE id=%d LIMIT 1",$id);
        $req = $wpdb->query($sql);
        return $req;
    }

    // chargement de scripts dans le wp_head
    function cefii_contact_front_head() {
        wp_enqueue_script('front-cefii-contact-js', plugins_url('js/front-cefii-contact.js', __FILE__), array('jquery'));
        wp_localize_script('front-cefii-contact-js', 'cefiicontact', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'action' => 'cefii_contact',
            'nonce' => wp_create_nonce('cefii_contact_nonce')
            )
        );
    }

    // fonction d'insert de données depuis le formulaire front-end
    function cefii_contact_front_ajax() {
        check_ajax_referer('cefii_contact_nonce', 'nonce');
        $insertion = $this->insertData($_POST['nom'],$_POST['tel']);

        if($insertion == true) {
            $message = '<span style="color:green;">Votre demande a bien été envoyée.</span>';
        } else {
            $message = '<span style="color:red;">Une erreur est survenue, veuillez réessayer.</span>';
        }

        echo json_encode($message);
        exit();
    }

    // création du menu dans la barre d'admin
    function cefii_contact_menu() {
        $pagePlugin = add_menu_page('Cefii Contact','cefii contact', 'administrator', 'cefiiContact.php', array($this,'cefii_contact_admin'), 'dashicons-phone');
        add_action('admin_head-'.$pagePlugin,array($this,'cefii_contact_admin_head'));
    }

    //déclaration du fichier contenant le menu admin
    function cefii_contact_admin() {
        require_once('template-admin.php');
    }

    // déclaration du CSS du menu d'admin
    function cefii_contact_admin_head() {
        wp_register_style('cefii_contact_admin_css', plugins_url('css/cefii-contact-admin.css', __FILE__));
        wp_enqueue_style('cefii_contact_admin_css');

        wp_enqueue_script('cefii_contact_admin_js', plugins_url('js/admin-cefii-contact.js', __FILE__), array('jquery'));
        wp_localize_script('cefii_contact_admin_js', 'supprContact',array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'action' => 'suppr_cefii_contact',
            'nonce' => wp_create_nonce('suppr_cefii_contact_nonce')
            )
        );        
    }

    // fonction de suppression de données depuis le formulaire d'admin
    function cefii_contact_admin_ajax() {
        check_ajax_referer('suppr_cefii_contact_nonce','nonce');
        $del = $this->deleteData($_POST['id']);

        if($del){
            $message = 'Contact supprimé';
            $nbre = $this->count_contacts();
        } else {
            $message = 'Une erreur est survenue, veuillez réessayer.';
            $nbre = $this->count_contacts();
        }

        echo json_encode(array($message, $nbre));
        exit();
    }

    function ajout_icone_toolbar($wp_admin_bar){
        $nbre = $this->count_contacts();
        $args = array(
            'id' => 'cefii-contact',
            'title' => '<span class="ab-icon"></span><span class="ab-label">'.$nbre.'</span>',
            'href' => admin_url('admin.php?page=cefiiContact.php'),
            'meta' => array(
                'title' => 'contacts à rappeler'
            )
        );
        $wp_admin_bar->add_node($args);
    }

    function cefii_contact_add_style_admin() {
        wp_register_style('admin_toolbar_cefii_contact_css', plugins_url('css/admin-bar.css', __FILE__));
        wp_enqueue_style('admin_toolbar_cefii_contact_css');
    }

    function count_contacts(){
        global $wpdb;
        $contacts = $this->selectData();
        $nbreContacts = $wpdb->num_rows;
        return $nbreContacts;
    }

}