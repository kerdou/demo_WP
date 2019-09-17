<?php
/*
Template Name: Page contact
*/
?>
<?php get_header(); ?>
<main>

    <section id="page" class="haut">
    
	    <h2 id="model_contact_title" ><?php the_title(); ?></h2>

        <div id="model_contact">
        
            <!-- zone de formulaire de contact -->
            <?php the_content(); ?>
            <!-- fin de zone de formulaire de contact -->

            <!-- zone de coordonnées -->
            <?php 
            $tel = get_theme_mod('telephone');
            $adresse = get_theme_mod('adresse');
            $ville = get_theme_mod('ville');   
            
            if(!empty($tel) || !empty($adresse) || !empty($ville)):
                ?>
                <div id="contact">
                    <h3>Coordonnées:</h2>
                <?php
                    if(!empty($tel)) :
                        ?>
                        <p>
                            <i class="fa fa-phone" aria-hidden="true"></i> 
                            <a href="tel:<?php echo $tel; ?>"><?php echo $tel; ?></a>
                        </p>
                        <?php
                    endif;
                    if(!empty($adresse) || !empty($ville)) :
                        ?>
                        <p>
                            <i class="fa fa-location-arrow" aria-hidden="true"></i>
                            <?php echo $adresse; ?>
                        </p>
                        <p><?php echo $ville; ?></p>
                        <?php
                    endif;
                    ?>
                </div>
                <?php 
            endif;
            ?>
            <!-- fin de zone de coordonnées -->
        </div>
	</section> <!-- end of pages <section> -->
 
<?php //get_sidebar('contact'); ?>


<!-- zone d'affichage de la google map-->
<?php 
    $map = get_theme_mod('map');   
    if(!empty($map)){
        echo $map;
    }
?>
<!-- fin de zone d'affichage de la google map-->
</main>
<?php get_footer(); ?>










