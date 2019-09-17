<?php
/*
Plugin Name: CEFii Copyright
Plugin URI: http://www.cefii.fr
Description: Mon premier plugin !
Author: Moi
Version: 0.1
Licence: GPL2
*/

// fonction d'affichage de copyright
function copyright(){
    echo "<p>Copyright ajouté par mon plugin!</p>";
}

// lancement de la fonction copyright() dans le footer
add_action('wp_footer','copyright');