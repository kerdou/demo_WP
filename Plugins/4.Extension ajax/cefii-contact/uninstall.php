<?php

if(!defined('WP_UNINSTALL_PLUGIN')){
    exit();
}

function cefii_contact_uninstall(){
    global $wpdb;
    $table_site = $wpdb->prefix.'cefiicontact';
    $sql = "DROP TABLE `$table_site`";
    $wpdb->query($sql);
}

cefii_contact_uninstall();