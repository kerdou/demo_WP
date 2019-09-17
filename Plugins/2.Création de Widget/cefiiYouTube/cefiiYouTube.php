<?php
/*
Plugin Name: CEFII YouTube
Description: widget permettant l'affichage d'une vidéo youtube
Version: 1.0
Author: Moi
*/

// lancement de la fonction d'enregistrement du Widget
add_action('widgets_init','my_register_cefii_youtube');


// fonction enregistrement du Widget
function my_register_cefii_youtube(){
    register_widget('CefiiYouTube');
}


// classe définissant le widget, étendre la classe parent WP_Widget
class CefiiYouTube extends WP_Widget{

    // constructeur du widget necessitant le constructeur parent
    function __construct() {
        $widget_options = array(
            'classname' => 'widget_cefiiyoutube',
            'description' => 'widget permettant l\'affichage de vidéo youtube'
        );

        parent ::__construct('widget-cefiiYoutube', 'CEFii YouTube', $widget_options);
    }

    // fonction permettant de gérer l'affichage du widget dans le front-end
    function widget($args,$instance) {
        extract($args); // permet de convertir les clés d'un tableau en variables
        echo $before_widget; // balises avant la video, H1 par exemple
        echo $before_title.$instance['title'].$after_title; // $instance['title'] vient du formulaire                 
        if($instance['idVideo']!=""){ // $instance['idVidoo'] vient du formulaire            
            ?>
                <iframe src="https://www.youtube.com/embed/<?php echo $instance['idVideo']; ?>" allowfullscreen></iframe> <!-- iframe de la video elle-même avec l'id fournit par $instance['idVideo'] -->
            <?php
        }
        echo $after_widget; // balises aprés la vidéo H1 par exemple
    }
        

    // fonction permettant WP de sauvagrder les nouvelles valeurs
    function update($new_instance, $old_instance){
        $instance = $old_instance; // sauvegarde des valeurs précédentes
        $instance['title'] = strip_tags($new_instance['title']); // strip_tags() permet de sécuriser les champs 
        $instance['idVideo'] = strip_tags($new_instance['idVideo']); // strip_tags() permet de sécuriser les champs 
        return $instance;
    }

    // formulaire de configuration du Widget dans Apparence > Widgets
    function form($instance) {

        // définition d'un titre par défaut dans le form
        $defaults= array(
            'title'=>"Vidéo CEFii Youtube"
        );

        // ajout du titre par défaut dans la variable $instance
        $instance= wp_parse_args($instance, $defaults);

        ?>
            <p>
                <!-- la methode get_field_id() permet de récupérer l'ID du champ -->
                <!-- la méthode get_field_name() permet de récupérer le name du champ -->  
                <label for="<?php echo $this->get_field_id('title'); ?>">Titre :</label>
                <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" 
                name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo
                $instance['title']; ?>" /> <!-- la classe Widefat est utilisée pour garder la cohérence avec les autres Widgets -->
            </p>
            <p>
                <!-- la methode get_field_id() permet de récupérer l'ID du champ -->
                <!-- la méthode get_field_name() permet de récupérer le name du champ -->
                <label for="<?php echo $this->get_field_id('idVideo'); ?>">Identifiant de la vidéo youTube :</label>
                <input class="widefat" type="text" id="<?php echo $this->get_field_id('idVideo'); ?>"
                name="<?php echo $this->get_field_name('idVideo'); ?>" value="<?php echo
                $instance['idVideo']; ?>" /> <!-- la classe Widefat est utilisée pour garder la cohérence avec les autres Widgets -->
            </p>
        <?php
        }

}

