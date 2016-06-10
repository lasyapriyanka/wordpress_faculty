<?php
/*
Template Name: Page builder with sidebar
*/
?>

<?php get_header(); ?>

    
	<div class="fac-page home">
		<div id="inside">
				
			<?php the_post(); ?>

			<div class="pageheader">
                <div class="headercontent">
                    <div class="section-container">
                        
                        <h2 class="title noborder"><?php the_title(); ?></h2>

                    </div>
                </div>
            </div>

            <div class="pagecontents has-sidebar">
                <div class="section color-1 row">
                    <div class="section-container col-md-9">

                		<?php the_content(); ?>
				
						<?php wp_link_pages(); ?>
                    </div>
                    <div class="col-md-3">
                    	<?php if ( is_active_sidebar( 'right_side_1' ) ) : ?>
						<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
							<?php dynamic_sidebar( 'right_side_1' ); ?>
						</div><!-- #primary-sidebar -->
						<?php endif; ?>
                    </div>
                </div>
            </div>
			
		</div>	
	</div>
	<div id="overlay"></div>
<?php get_footer(); ?>

