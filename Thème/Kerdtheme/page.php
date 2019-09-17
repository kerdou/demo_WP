<?php get_header(); ?>
    <!-- page.php -->

    <main>
        <!-- image à la une -->
        <?php 
        $imageUne = get_theme_mod('imageALaUne_setting');

        if (!empty($imageUne)) {    
            ?>
            <div id="divImgUne">                
                <img id="imgUne" src="<?php echo $imageUne; ?>" alt="image à la une" async="on"> 
            </div>
        <?php
        }
        ?>
        <!-- fin de image à la une -->
            
        <!-- contenu de la page -->
        <div>
            <?php if(have_posts()): while(have_posts()): the_post(); ?>
                <?php if(is_active_sidebar('sidebar-droite')) : ?>
                    <section id="pages" class="haut avecAside">
                        <?php else : ?>	
                            <section id="pages" class="haut">
                        <?php endif; ?>

                        <h2><?php the_title(); ?></h2>
                        <?php the_content(); ?>
                    </section>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
        <!-- fin de contenu de la page -->
        <?php get_sidebar(); ?>
    </main>
     
<?php get_footer(); ?>