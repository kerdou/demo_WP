<?php
/*
Template Name: Page sans sidebar
*/
?>
<!-- page-full.php -->
<?php get_header(); ?>
<main>
<?php if(have_posts()): while(have_posts()): the_post(); ?>
    <section id="pages" class="haut">
		<h2><?php the_title(); ?></h2>
		<?php the_content(); ?>
	</section>
<?php endwhile; ?>
<?php endif; ?>
</main>
<?php get_footer(); ?>










