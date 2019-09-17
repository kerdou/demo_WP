<?php get_header(); ?>
    <!-- home.php -->

        <main> 
            <!-- page actualités -->
            <div id="articlesList_space"></div>

            <div id="articlesList">
                <?php
                if(have_posts()): while(have_posts()): the_post(); 
                ?>
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
                <!-- <div class="clear"></div> -->
            </div>    
        </main>        
     
<?php get_footer(); ?>