<!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
    <title>
        <?php bloginfo('name'); ?>
        -
        <?php 
            if(is_home() || is_front_page()){
                bloginfo('description');
            } else {
                wp_title("",true);
            }
        ?>
    </title>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="wrapper">
    <a id="retourAccueil" href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>">
        <header>
            <h1 id="titre"><?php bloginfo('name'); ?></h1>
            <div id="logo">
                <?php $image = get_header_image();
                if(!empty($image)) : ?>
                    <img 
                        src="<?php echo esc_url($image); ?>"
                        width="<?php echo get_custom_header()->width; ?>"
                        height="<?php echo get_custom_header()->height; ?>" 
                        alt="logo" 
                    />
                <?php else : ?>
                    <img
                        src="<?php echo get_theme_support('custom-header','default-image'); ?>"
                        alt="logo"
                    />
                <?php endif; ?> 
            </div>
            <h2 id="slogan"><?php bloginfo('description'); ?></h2>
        </header>
    </a> 
    <nav>
        <i  id="burgerButton" class="fa fa-bars" aria-hidden="true"></i>
        <?php wp_nav_menu(array(
                'sort_column' => 'menu-order',
                'theme_location' => 'principal'
            ));
        ?>
    </nav>   
    
   
  
 












