<?php

class Cefii_Contact_Widget extends WP_Widget {
    function __construct() {
        $widget_options = array(
            'classname' => 'widget_cefiicontact',
            'description' => 'Pour transmettre un numéro de téléphone'
        );

        parent ::__construct('widget-cefiicontact','CEFii Contact', $widget_options);
    }

    // formulaire du widget dans "apparences>widget"
    function form($instance) {
        $defaults= array(
            'title'=> "On vous rappelle !" // titre par défaut visible dans le formulaire
        );

        $instance= wp_parse_args($instance, $defaults); // mélange des settings par défaut du form et des infos venants de update()
        ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>">Titre :</label>
                <input class="widefat"
                type="text" id="<?php echo $this->get_field_id('title'); ?>"
                name="<?php echo $this->get_field_name('title'); ?>"
                value="<?php echo $instance['title']; ?>" />
            </p>
        <?php
    }

    // mise à jour des données vers et depuis le formulaire
    function update($new_instance, $old_instance){
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    // partie front-end du widget
    function widget($args,$instance) {
        extract($args);
        echo $before_widget;

        if($instance['title']!=''){
            echo $before_title.$instance['title'].$after_title;
        }

        echo 
        '<form id="cefiiContact" action="">
            <p>
                <label for="cefii_contact_nom">Votre nom :</label>
                <input type="text" id="cefii_contact_nom" name="cefii_contact_nom" />
            </p>
            <p>
                <label for="cefii_contact_tel">Votre téléphone :</label>
                <input type="text" id="cefii_contact_tel" name="cefii_contact_tel" />
            </p>
            <p>
                <input id="cefiiContactSubmit" type="button" value="Me rappeler">
            </p>
        </form>
        <div id="messageWidgetCefiiContact"></div>';

        echo $after_widget;
    }



}