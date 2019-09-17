<i class="fa fa-quote-left" aria-hidden="true"></i>
<h2><?php the_author(); ?></h2>
<?php the_excerpt(); ?>
<a href="<?php echo get_permalink(); ?>"> Lire la suite...</a>
<p class="infos">
	<?php comments_number('Aucun commentaire','Un seul commentaire','% commentaires'); ?> <!-- affichage suivant le nombre de commentaires -->
</p>