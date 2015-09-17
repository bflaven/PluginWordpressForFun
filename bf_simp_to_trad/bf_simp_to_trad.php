<?php
/*
Plugin Name: Simp to Trad
Plugin URI: http://flaven.fr
Description: A plugin to clone posts in simplified Chinese and convert it into traditional Chinese
Version: 1.0
Author: Bruno Flaven
Author URI: http://flaven.fr
License: GPLv2
*/
/**
 * Convert simp to trad
 *
 */

/*
 * Function creates post duplicate as a draft and redirects then to the edit post screen
 */
function rd_duplicate_post_as_draft(){

	require_once('library/ZhConversion_simp_to_trad.php');

	global $wpdb;

	if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
		wp_die('No post to duplicate has been supplied!');
	}
 
	/*
	 * get the original post id
	 */
	$post_id = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);
	/*
	 * and all the original post data then
	 */
	$post = get_post( $post_id );
 
	/*
	 * if you don't want current user to be the new post author,
	 * then change next couple of lines to this: $new_post_author = $post->post_author;
	 */
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID;
 
	/*
	 * if post data exists, create the post duplicate
	 */
	if (isset( $post ) && $post != null) {
 
		/*
		 * new post data array
		 */
		$post_content_trad = strtr(strtr($post->post_content, $zh2TW), $zh2Hant);	
		$post_excerpt_trad = strtr(strtr($post->post_excerpt, $zh2TW), $zh2Hant);	
		$post_name_trad = strtr(strtr($post->post_name, $zh2TW), $zh2Hant);	
		$post_title_trad = strtr(strtr($post->post_title, $zh2TW), $zh2Hant);	
		
		$args = array(

			
			/* It is here you make the change */
			//'post_content'   => $post->post_content,
			'post_content' =>  $post_content_trad,
			// 'post_excerpt'   => $post->post_excerpt,
			'post_excerpt'   => $post_excerpt_trad,

			/* disable the post_name to force the creation of the slug */
			// 'post_name'      => $post->post_name,
			// 'post_name'      => $post_name_trad,

			// 'post_title'     => $post->post_title,
			'post_title'     => $post_title_trad,
			
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,			
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);
 
 	   
 	    // var_dump($post_title_trad);
		
		/*
		 * insert the post by wp_insert_post() function
		 */
		$new_post_id = wp_insert_post( $args );
 
		/*
		 * get all current post terms ad set them to the new post draft
		 */
		// returns array of taxonomy names for post type, ex array("category", "post_tag");
		
		$taxonomies = get_object_taxonomies($post->post_type);
		foreach ($taxonomies as $taxonomy) {
		$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
			wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
		}
	
		/*
		 * duplicate all post meta
		 */
		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos)!=0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				$meta_value = addslashes($meta_info->meta_value);
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query.= implode(" UNION ALL ", $sql_query_sel);
			$wpdb->query($sql_query);
		}
 
 
		/*
		 * finally, redirect to the edit post screen for the new draft
		 */
		wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
		exit;
	} else {
		wp_die('Post creation failed, could not find original post: ' . $post_id);
	}
}
add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );
 
/*
 * Add the duplicate link to action list for post_row_actions
 */
function rd_duplicate_post_link( $actions, $post ) {
	if (current_user_can('edit_posts')) {
		$actions['duplicate'] = '<a href="admin.php?action=rd_duplicate_post_as_draft&amp;post=' . $post->ID . '" title="Duplicate this item" rel="permalink">Clone Simp to Trad</a>';
	}
	return $actions;
}
 
add_filter( 'post_row_actions', 'rd_duplicate_post_link', 10, 2 );

	
/*****************************************************************************************/
      /// ADMIN PAGE FOR HELP
/*****************************************************************************************/


class options_page {

	function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}
	function admin_menu () {
		add_options_page('SimpToTrad', 'Simp to Trad','manage_options','SimpToTrad_slug', array( $this, 'settings_page' ) );
		
		
	}
	function settings_page () {
		// echo 'This is the page content';
		?>
		<div class="wrap">
			<h2>Explanations for the Simp To Trad Chinese plugin</h2>
			
			
			<p>&nbsp;</p>

			<p><b>Once installed, this plugin allow to get a direct link in the post listing named "Clone Simp to Trad" that enable the clone and the conversation of a regular post into traditional Chinese.</b></p>
			<p>&nbsp;</p>
			<p><b>This is the first version of the plugin. It clearly deserves 3 functional enhancements. <i>These 3 enhancements might be made in a next version but may be not.</i></b></p>
			<p>&nbsp;</p>
			<ol>
				<li>A direct link available in each content element (article, page, tag result ... etc) via two ideograms: 繁 (trad) 簡 (simp).</li>
				<li>The ability for the admin to perform a preview with the help of an ajax request of any translation before publishing it.</li>
				<li>The ability to add translation strings directly into the translation file available in the library directory o this plugin.</li>
			</ol>
		</div>		
	
	<?php
	}
}
		new options_page;
		

						

?>