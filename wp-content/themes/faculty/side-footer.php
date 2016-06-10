<!-- Sidebar footer -->
<?php if (ot_get_option( 'side_footer' )=='on'): ?>
<div id="side-footer" <?php if(ot_get_option('side-footer-layout')=='after-the-nav'): ?> class="not-sticky"<?php endif; ?>>
    <div class="social-icons">
        <ul>
            <?php if (ot_get_option( 'si_email' )=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_email_address' ); ?>"><i class="fa fa-envelope-o"></i></a></li>
            <?php endif; ?>

            <?php if (ot_get_option( 'si_facebook' )=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_facebook_url' ); ?>"><i class="fa fa-facebook"></i></a></li>
            <?php endif; ?>
            <?php if (ot_get_option( 'si_twitter' )=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_twitter_url' ); ?>"><i class="fa fa-twitter"></i></a></li>
            <?php endif; ?>
            
            <?php if (ot_get_option( 'si_gplus' )=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_gplus_url' ); ?>"><i class="fa fa-google-plus"></i></a></li>
            <?php endif; ?>

            <?php if (ot_get_option( 'si_linkedin' )=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_linkedin_url' ); ?>"><i class="fa fa-linkedin"></i></a></li>
            <?php endif; ?>
            <?php if (ot_get_option( 'si_academia' )=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_academia_url' ); ?>"><i class="academia"></i></a></li>
            <?php endif; ?>
            <?php if (ot_get_option( 'si_rg' )=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_rg_url' ); ?>"><i class="researchgate"></i></a></li>
            <?php endif; ?>

            

            <?php if (ot_get_option( 'si_youtube' )=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_youtube_url' ); ?>"><i class="fa fa-youtube"></i></a></li>
            <?php endif; ?>
            
            <?php if (ot_get_option( 'si_instagram' )=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_instagram_url' ); ?>"><i class="fa fa-instagram"></i></a></li>
            <?php endif; ?>
            <?php if (ot_get_option( 'si_flickr' )=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_flickr_url' ); ?>"><i class="fa fa-flickr"></i></a></li>
            <?php endif; ?>
            <?php if (ot_get_option( 'si_pinterest' )=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_pinterest_url' ); ?>"><i class="fa fa-pinterest"></i></a></li>
            <?php endif; ?>
            <?php if (ot_get_option( 'si_rss' )=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_rss_url' ); ?>"><i class="fa fa-rss"></i></a></li>
            <?php endif; ?>
        </ul>
    </div>

    <?php if ( is_active_sidebar( 'footer_of_sidebar' ) ) : ?>
    <div id="side-footer-widget">
        <?php dynamic_sidebar( 'footer_of_sidebar' ); ?>
    </div>
    <?php endif; ?>

    <?php if (ot_get_option( 'copyright' )!=''): ?>
    <div id="copyright"><?php echo ot_get_option( 'copyright' ) ?></div>
    <?php endif; ?>

</div>
<?php endif; ?>
 <!-- /Sidebar footer -->