<?php
if(!defined('WP_UNINSTALL_PLUGIN')){
    exit();
}

function cefii_map_uninstall(){
    global $wpdb;
    $table_site = $wpdb->prefix.'cefiimap';
    $sql = "DROP TABLE `$table_site`";
    $wpdb->query($sql);
}

cefii_map_uninstall();