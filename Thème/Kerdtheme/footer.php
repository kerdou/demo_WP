    <footer>

    <div id="footer_top">

        <!-- navbar footer -->
        <div id="menuFooter">
            <?php wp_nav_menu(array(
                'sort_column' => 'menu-order',
                'theme_location' => 'footer'
            ));
        ?>
        </div>
        <!-- fin navbar footer -->


        <!-- bloc contacts -->
        <?php 
            $tel = get_theme_mod('telephone');
            $adresse = get_theme_mod('adresse');
            $ville = get_theme_mod('ville');   
        
        if(!empty($tel) || !empty($adresse) || !empty($ville)):
            ?>
            <div id="footer_contact">
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
            <!-- fin  bloc contacts -->
            
            <?php 
        endif; ?>


        <!-- liens réseaux sociaux -->
        <?php
            $facebook = get_theme_mod('fb');   
            $twitter = get_theme_mod('tw');   
            $gplus = get_theme_mod('gplus');   
            $youtube = get_theme_mod('youtube');   
            $viadeo = get_theme_mod('viadeo');   
            $lkd = get_theme_mod('lkd');   
        
        if(($facebook!="http://") || ($twitter!="http://") || ($gplus!="http://") || ($youtube!="http://") || ($viadeo!="http://") || ($lkd!="http://")): 
        ?>
            <div id="social">
                <p>               
                    <?php
                    /*code à améliorer à l'aide de tableau et foreach par exemple */    
                    if(($facebook!="http://") && (!empty($facebook))){ 
                    ?>
                    <a href="<?php echo $facebook; ?>" title="rejoignez-nous sur facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    <?php
                    }
                    if(($twitter!="http://") && (!empty($twitter))){ 
                    ?>
                    <a href="<?php echo $twitter; ?>" title="rejoignez-nous sur twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                    <?php
                    }  
                    if(($gplus!="http://") && (!empty($gplus))){ 
                    ?>
                    <a href="<?php echo $gplus; ?>" title="rejoignez-nous sur google-plus"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                    <?php
                    }
                    if(($youtube!="http://") && (!empty($youtube))){ 
                    ?>
                    <a href="<?php echo $youtube; ?>" title="rejoignez-nous sur youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                    <?php
                    }
                    if(($viadeo!="http://") && (!empty($viadeo))){ 
                    ?>
                    <a href="<?php echo $viadeo; ?>" title="rejoignez-nous sur viadeo"><i class="fa fa-viadeo" aria-hidden="true"></i></a>
                    <?php
                    } 
                    if(($lkd!="http://") && (!empty($lkd))){ 
                    ?>
                    <a href="<?php echo $lkd; ?>" title="rejoignez-nous sur linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                    <?php
                    }
                    ?>
                </p>
            </div>
            <?php 
        endif;
        ?>

        <!-- fin liens réseaux sociaux -->
    </div>

    <!-- copyrights -->
    <div id="copyright">
        <p>Copyright &copy; <?php echo date('Y'); ?> - <?php bloginfo('name'); ?></p>
    </div>
    <!-- fin copyrights -->

    </footer>
</div><!-- wrapper -->
</body>
</html>