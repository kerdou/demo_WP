<?php get_header(); ?> <!-- intégration de header.php -->
<main>
	<!-- tag.php -->
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
	<?php if(is_active_sidebar('sidebar-droite')) : ?>
        <section id="pages" class="haut avecAside">
    <?php else : ?>	
        <section id="pages" class="haut">
    <?php endif; ?>
	<h2>Catégorie: <?php single_tag_title() ?></h2>

		<div id="articlesList">
		

			<?php if(have_posts()): while(have_posts()): the_post(); ?>
				<article <?php post_class(); ?>>
				<?php if(!get_post_format()) {
					get_template_part('content/content', 'default');
				} else {
					get_template_part('content/content', get_post_format());
				}
				?>
				</article>
				<?php endwhile; ?>
			<?php endif; ?>                
		</div> 		
	</section>
	<?php get_sidebar(); ?>
    <!-- fin de contenu de la page -->
    
</main>
<div class="clear"></div>
<?php get_footer(); ?>






