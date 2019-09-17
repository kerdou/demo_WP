<?php get_header(); ?>
<!-- single.php -->
<main>
	<?php if(have_posts()): while(have_posts()): the_post(); ?>
		<?php if(is_active_sidebar('sidebar-droite')) : ?>
		<section id="articleSeul" class="haut avecAside">
	<?php else : ?>	
		<section id="articleSeul" class="haut">
	<?php endif; ?>
			<div class="precSuiv">
				<div class="articlePrec">
					<?php previous_post_link(); ?>
				</div>
				<div class="articleSuiv">
					<?php next_post_link(); ?>
				</div>
			</div>
		<h2><?php the_title(); ?></h2>
		<?php the_content(); ?>
        <p>Les articles et le profil de <?php the_author_posts_link(); ?></p> <!-- lien vers l'auteur -->
        <p>Publié le <?php the_date(); ?></p> <!-- date de publication -->
        <p>Catégorie(s) : <?php the_category(); ?></p> <!-- catégorie de l'article -->
        <p class="motsCles"><?php the_tags(); ?></p> <!-- liste de mots-clé, étiquette cliquables -->
        <div id="commentaires">
            <h3>Commentaires de l'article :</h3>
            <?php comments_template(); ?> <!-- template gérant les commmentaires (comments.php s'il est présent dans le thème) -->
        </div>		
	</section>
	<?php endwhile; ?>
	<?php endif; ?>
	<?php get_sidebar(); ?>
</main>
<?php get_footer(); ?>