<?php 
/*Logo*/
$header_args = array(
    'flex-height' => true,
    'height' => 92,
    'flex-width' => true,
    'width' => 427,
    'default-image' => get_template_directory_uri().'/images/logoCefii.png'
);
add_theme_support('custom-header', $header_args);

/* option arrière plan */
add_theme_support('custom-background',array(
    'default-color' => 'cccccc'
));

/* fichiers à charger */
function themeExercice_files(){
    wp_enqueue_style('themeExercice-style',get_stylesheet_uri());
    wp_enqueue_style('fontAwesome-style',get_template_directory_uri().'/css/font-awesome.min.css');
    wp_enqueue_style('slider-style',get_template_directory_uri().'/css/jquery.bxslider.css');    
    wp_enqueue_script('slider-script',get_template_directory_uri().'/js/jquery.bxslider.min.js',array('jquery'));
    wp_enqueue_script('js-script',get_template_directory_uri().'/js/script.js',array('jquery'));
}
add_action('wp_enqueue_scripts','themeExercice_files');


/* ajout des styles définis dans les options du thème */
function themeExercice_header(){
?>
    <style>
        <?php 
            $titleColor = get_header_textcolor(); 
        ?>
        header h1, header h2 {
            color : #<?php echo $titleColor; ?>;
        }
    </style>
    <script>
        jQuery(document).ready(function () {
            jQuery('.bxslider').bxSlider({
                auto: true,
                autoControls: true
            });
            jQuery('nav .fa-bars').on('click',function(){
               jQuery("#menu-principal").slideToggle(); 
            });
        });
    </script>
<?php
}
add_action('wp_head','themeExercice_header');

/*Enregistrement des menus */
if(function_exists('register_nav_menus')){
    register_nav_menus(array(
        'principal' => 'Menu principal',
        'footer' => 'Menu footer'
    ));
}

/* Options du thème : images du slideshow (3) */ 
function themeExercice_customize_register($wp_customize){

   /* Image à la une */
   $wp_customize->add_section('imageALaUne_section',array(
    'title' => 'Image à la une',
    'priority' => 80    
    ));
    $wp_customize->add_setting('imageALaUne_setting',array(
        'default' => '',
    ));   
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'imageALaUne_setting',
            array(
                'label'      => 'Image',
                'section'    => 'imageALaUne_section',
                'settings'   => 'imageALaUne_setting',
            )
        )
    );


    /* slideshow */
    $wp_customize->add_section('slider',array(
        'title' => 'Slider',
        'priority' => 81
        
    ));
    $wp_customize->add_setting('image_slider1',array(
        'default' => '',
    ));
    $wp_customize->add_setting('image_slider2',array(
        'default' => '',
    ));
    $wp_customize->add_setting('image_slider3',array(
        'default' => '',
    ));
    $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'image_slider1',
           array(
               'label'      => 'Image 1 (730 x 200)',
               'section'    => 'slider',
               'settings'   => 'image_slider1',
           )
       )
   );
    $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'image_slider2',
           array(
               'label'      => 'Image 2 (730 x 200)',
               'section'    => 'slider',
               'settings'   => 'image_slider2',
           )
       )
   );
    $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'image_slider3',
           array(
               'label'      => 'Image 3 (730 x 200)',
               'section'    => 'slider',
               'settings'   => 'image_slider3',
           )
       )
   );


    /* Contact Footer */
    $wp_customize->add_section('my_footer',array(
        'title' => 'Contact footer',
        'priority' => 82
        
    ));
    $wp_customize->add_setting('telephone',array(
        'default' => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('telephone',array(
        'settings' => 'telephone',
        'label' => 'Téléphone',
        'section' => 'my_footer',
        'type' => 'text'
    ));
    $wp_customize->add_setting('adresse',array(
        'default' => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('adresse',array(
        'settings' => 'adresse',
        'label' => 'Adresse',
        'section' => 'my_footer',
        'type' => 'text'
    ));
    $wp_customize->add_setting('ville',array(
        'default' => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('ville',array(
        'settings' => 'ville',
        'label' => 'CP Ville',
        'section' => 'my_footer',
        'type' => 'text'
    ));
    /* Réseaux sociaux */
    $wp_customize->add_section('my_rs',array(
        'title' => 'Réseaux sociaux',
        'priority' => 83
        
    ));
    $wp_customize->add_setting('fb',array(
        'default' => 'http://',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('fb',array(
        'settings' => 'fb',
        'label' => 'Facebook',
        'section' => 'my_rs',
        'type' => 'url'
    ));
    $wp_customize->add_setting('tw',array(
        'default' => 'http://',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('tw',array(
        'settings' => 'tw',
        'label' => 'Twitter',
        'section' => 'my_rs',
        'type' => 'url'
    ));
    $wp_customize->add_setting('gplus',array(
        'default' => 'http://',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('gplus',array(
        'settings' => 'gplus',
        'label' => 'Google +',
        'section' => 'my_rs',
        'type' => 'url'
    ));
    $wp_customize->add_setting('youtube',array(
        'default' => 'http://',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('youtube',array(
        'settings' => 'youtube',
        'label' => 'YouTube',
        'section' => 'my_rs',
        'type' => 'url'
    ));
    $wp_customize->add_setting('viadeo',array(
        'default' => 'http://',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('viadeo',array(
        'settings' => 'viadeo',
        'label' => 'Viadeo',
        'section' => 'my_rs',
        'type' => 'url'
    ));
    $wp_customize->add_setting('lkd',array(
        'default' => 'http://',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('lkd',array(
        'settings' => 'lkd',
        'label' => 'LinkeDin',
        'section' => 'my_rs',
        'type' => 'text'
    ));
    /*google map */
    $wp_customize->add_section('google_map',array(
        'title' => 'Google Map',
        'priority' => 84 
    ));
    $wp_customize->add_setting('map',array(
        'default' => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('map',array(
        'settings' => 'map',
        'label' => 'Iframe de la carte',
        'section' => 'google_map',
        'type' => 'url'
    ));
    
}
add_action('customize_register','themeExercice_customize_register');

/* ajout du post format citation */
add_theme_support('post-formats', array('quote'));

/* activation des images à la une */
add_theme_support('post-thumbnails');

/* sidebar */
if(function_exists('register_sidebar')){
	register_sidebar(array(
		'id'=> 'sidebar-droite',
		'name'=> 'Barre latérale principale',
		'description' => "Colonne de widgets qui apparaît à droite",
		'before_widget'=>'',
		'after_widget'=>'',
		'before_title'=>'<h3>',
		'after_title'=>'</h3>',
	));
    register_sidebar(array(
		'id'=> 'sidebar-contact',
		'name'=> 'Barre latérale de la page contact',
		'description' => "Colonne de widgets qui apparaît à droite de la page Contact",
		'before_widget'=>'',
		'after_widget'=>'',
		'before_title'=>'<h3>',
		'after_title'=>'</h3>',
	));
}























?>