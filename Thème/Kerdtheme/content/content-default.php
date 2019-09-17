<div class="une">
    <span class="uneHelper"></span>
    <?php the_post_thumbnail('large'); ?>
</div>
<div class="content-article">
    <h2>
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h2>
    <?php the_excerpt(); ?>
    <a href="<?php echo get_permalink(); ?>"> Lire la suite...</a>
    <p class="infos">
		<?php comments_number('Aucun commentaire','Un seul commentaire','% commentaires'); ?> <!-- affichage suivant le nombre de commentaires -->
	</p>    
</div>

