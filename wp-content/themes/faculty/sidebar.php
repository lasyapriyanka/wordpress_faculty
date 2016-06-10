<a href="#sidebar" class="mobilemenu"><i class="fa fa-bars"></i></a>

<div id="sidebar">
    <div id="sidebar-wrapper">
        
        <!-- Profile/logo section-->
        <div id="profile" class="clearfix">
            <div class="portrate 
            <?php if (ot_get_option('hide_logo')=='on'): ?>
                hidden-xs 
            <?php endif; ?>
            ">
              <a href="<?php echo get_site_url();?>"><img src="<?php echo ot_get_option('personal_photo') ?>" alt="<?php echo ot_get_option( 'person_name' ); ?>"></a>
            </div>
            <div class="title">
                <h2><?php echo ot_get_option( 'person_name' ); ?></h2>
                <h3><?php echo ot_get_option( 'sub_title' ); ?></h3>
            </div>   
        </div>
        <!-- /Profile/logo section-->

        <!-- Main navigation-->
        <div id="main-nav">

            <?php  
            wp_nav_menu( array(
              'theme_location' => 'sidemenu',
              'menu' => '',
              'container' => false,
              'menu_class' => false,
              'items_wrap' => '<ul id = "navigation" class = "%2$s">%3$s</ul>',
              'depth' => 0,
              'walker' => ''//new fac_walker_nav_menu
            ) ); ?>
        </div>
        <!-- /Main navigation-->

        <?php if(ot_get_option('side-footer-layout')=='after-the-nav'): ?>
        <?php get_template_part( 'side-footer' ); ?>
        <?php endif; ?>
    </div>
    <?php if(ot_get_option('side-footer-layout')=='stick-to-bottom'): ?>
    <?php get_template_part( 'side-footer' ); ?>
    <?php endif; ?>
   
</div>