<?php 


function publications_register(){
	$publications_labels = array(
	    'name' 					=> __('Publications','faculty'),
	    'singular_name' 		=> __('Publication','faculty'),
	    'add_new' 				=> __('Add New','faculty'),
	    'add_new_item' 			=> __("Add New Publication",'faculty'),
	    'edit_item' 			=> __("Edit Publication",'faculty'),
	    'new_item' 				=> __("New Publication",'faculty'),
	    'view_item' 			=> __("View Publication",'faculty'),
	    'search_items' 			=> __("Search Publications",'faculty'),
	    'not_found' 			=> __( 'No Publications found','faculty'),
	    'not_found_in_trash' 	=> __('No Publications found in Trash','faculty'), 
	    'parent_item_colon' 	=> ''
	);
	$publications_args = array(
	    'labels' 				=> $publications_labels ,
	    'public' 				=> true,
	    'publicly_queryable' 	=> true,
	    'show_ui' 				=> true, 
	    'query_var' 			=> true,
	    'rewrite' 				=> true,
	    'hierarchical' 			=> false,
	    'menu_position' 		=> null,
	    'capability_type' 		=> 'post',
	    'supports' 				=> array('title', 'editor','page-attributes'),
	    //'menu_icon' 			=> get_bloginfo('template_directory') . '/images/photo-album.png' //16x16 png if you want an icon
	); 
	register_post_type('publications', $publications_args);
	flush_rewrite_rules( false );
};
add_action('init', 'publications_register');


add_action( 'init', 'fac_create_publications_taxonomies', 0); 
function fac_create_publications_taxonomies(){
    register_taxonomy(
        'pubtype', 'publications', 
        array(
            'hierarchical'=> true, 
            'label' => 'Publication Types',
            'singular_label' => 'Publication Type',
            'show_admin_column' => true,
            'rewrite' => true
        )
    );    
}


function fac_custom_columns( $column ){
    global $post;
    
    switch ($column) {
        // case 'pubtype' : 
        // 	echo get_the_term_list( $post->ID, 'pubtype', '', ', ',''); 
        // 	break;
        case 'menu_order':
			$custom_post = get_post(get_the_ID());
			$custom = $custom_post->menu_order;
			echo $custom;
			break;
    }
}
add_action('manage_posts_custom_column', 'fac_custom_columns');

function fac_add_new_publications_columns( $columns ){
	    
	$columns['title']	= __('Publication Title',"faculty");
	$columns['menu_order'] = __('Order',"faculty");
	//unset($columns['taxonomy-pubtype']);
    unset($columns['jss_post_thumb']);

    return $columns;
}
add_filter('manage_edit-publications_columns', 'fac_add_new_publications_columns');


//make columns sortable
add_filter('manage_edit-publications_sortable_columns', 'fac_register_publications_sortable_columns');
function fac_register_publications_sortable_columns(){
	return array(
		'title' => "title",
		"date"  => "date",
		'menu_order' => 'menu_order',
		'taxonomy-pubtype' => 'taxonomy-pubtype'
	);
}


//add publication type as a filter
function fac_restrict_publications_by_type() {
	global $typenow;
	$post_type = 'publications'; 
	$taxonomy = 'pubtype'; 
	if ($typenow == $post_type) {
		$selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);
		wp_dropdown_categories(array(
			'show_option_all' => __("Show All {$info_taxonomy->label}"),
			'taxonomy' => $taxonomy,
			'name' => $taxonomy,
			'orderby' => 'name',
			'selected' => $selected,
			'show_count' => true,
			'hide_empty' => true,
		));
	};
}
add_action('restrict_manage_posts', 'fac_restrict_publications_by_type');



function fac_convert_id_to_term_in_query($query) {
	global $pagenow;
	$post_type = 'publications';
	$taxonomy = 'pubtype';
	$q_vars = &$query->query_vars;
	if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0) {
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		$q_vars[$taxonomy] = $term->slug;
	}
}
add_filter('parse_query', 'fac_convert_id_to_term_in_query');











function fac_get_pubtypes(){
	$taxonomy = 'pubtype';
	return get_terms($taxonomy);
}

function fac_taxonomy_name($type){
     global $post;
 
    $terms = get_the_terms( $post->ID , 'pubtype' );

    if ( ! is_array($terms))
    	return;
    
    if ($type =="slug"  ){
	    foreach ( $terms as $termphoto ) { 
	        echo ' '.$termphoto->slug; 
	    }
	}else{
		foreach ( $terms as $termphoto ) {

			$t_id = $termphoto->term_id;
    		$term_meta = get_option( "faulty_pubtypes_$t_id" );
    		//echo "<pre>";var_dump($term_meta['faculty_label_color']);echo"</pre>";
    		if ( is_array($term_meta) ){
    			if (array_key_exists('faculty_label_color', $term_meta))
    				echo '<span class="'.$term_meta['faculty_label_color'].'">'.$termphoto->name.'</span>'; 
    			else
    				echo '<span class="label label-warning">'.$termphoto->name.'</span>'; 
    		}else{
    			echo '<span class="label label-warning">'.$termphoto->name.'</span>'; 
    		}
	        
	    }
	} 
}






//add field to new page
add_action( 'pubtype_add_form_fields', 'fac_pubtype_add_meta_field', 10, 2 );

function fac_pubtype_add_meta_field() {
        

	$out = '<div class="form-field">';
	// this will add the custom meta field to the add new term page
	wp_nonce_field( plugin_basename( __FILE__ ), 'owlab_media_nonce' );

	$out .= '<div class="drop_meta_item_group">
	    <label for="faculty_label_color">'.__('Label color','faculty').'</label>
	    <select name="term_meta[faculty_label_color]" id="faculty_label_color">';
	                
	    $out .= fac_pub_get_layouts();

	$out .='</select>';     


	$out .='</div><!-- end form-field -->';       
	echo $out;


}
function fac_pub_get_layouts($selected=null){
	$types = array(
        'label label-default'   => __('Default','faculty'),
        'label label-primary'   => __('Blue','faculty'),
        'label label-success'   => __('Green','faculty'),
        'label label-info'   => __('Cyan','faculty'),
        'label label-warning'   => __('Orange','faculty'),
        'label label-danger'   => __('Red','faculty'),
    );

    $out = '';
    $i = 0;
    foreach ( $types as $id=>$value){
        $out .= '<option value="'.$id.'" ';
        if ( isset($selected) ){
            if( $selected == $id )
                $out .= 'selected';
        }else{
            if ($i == 0)
               $out .= 'selected'; 
        }
        $out .='>'.$value.'</option>';
        $i++;
    }

    return $out;
}


// add field to edit page
add_action( 'pubtype_edit_form_fields', 'fac_pubtype_edit_meta_field', 10, 2 );
function fac_pubtype_edit_meta_field($term) {

    // put the term ID into a variable
    $t_id = $term->term_id;

    // retrieve the existing value(s) for this meta field. This returns an array
    $term_meta = get_option( "faulty_pubtypes_$t_id" );
    
    ?>
   

    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="faculty_label_color"><?php  _e('Label color','faculty')?> </label>
        </th>
        <td>
            <select name="term_meta[faculty_label_color]" id="faculty_label_color">
                <?php $selected = esc_attr( $term_meta['faculty_label_color'] ) ? esc_attr( $term_meta['faculty_label_color'] ) : null; ?>
                <?php echo fac_pub_get_layouts($selected); ?>
            </select>
            <br/>
        </td>
    </tr>
    <?php 
}


//save
add_action( 'edited_pubtype', 'fac_save_pubtype_custom_meta', 10, 2 );  
add_action( 'create_pubtype', 'fac_save_pubtype_custom_meta', 10, 2 );

function fac_save_pubtype_custom_meta($term_id) {
        
    //owlabpfl_layout_type
        

    if ( isset( $_POST['term_meta'] ) ) {
        
        $t_id = $term_id;
        $term_meta = get_option( "faulty_pubtypes_$t_id" );
        $cat_keys = array_keys( $_POST['term_meta'] );
        foreach ( $cat_keys as $key ) {
            if ( isset ( $_POST['term_meta'][$key] ) ) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        // Save the option array.
        update_option( "faulty_pubtypes_$t_id", $term_meta );
    }

}