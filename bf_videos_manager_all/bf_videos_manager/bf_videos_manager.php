<?php
/*
Plugin Name: bf_videos_manager
Plugin URI: http://flaven.fr
Description: Full built-up videos manager for YT video
Version: 1.0
Author: Bruno Flaven
Author URI: http://flaven.fr
*/
/* Pour les nice-videos-tutos */
	
	
	
	
	/*
     * register with hook 'wp_print_styles'
     */
    add_action('wp_print_styles', 'add_my_stylesheet_bf_videos_manager');

/*
 * Enqueue style-file, if it exists.
 */
function add_my_stylesheet_bf_videos_manager() {
$style_url_videos_manager = plugin_dir_url( __FILE__ ).'css/bf_videos_manager.css';
wp_enqueue_style( 'bf_front_css_videos_manager', $style_url_videos_manager);

}//EOF

		/*****************************************************************************************/
		      /// SHORTCODES
		/*****************************************************************************************/
		
		// 	/*******  For shortcodes functions see this file shortcodes/bf_videos_manager_shortcodes.php ********/
	 	// Loading first required 
		require_once('shortcodes/bf_videos_manager_shortcodes.php');
		require_once('admin/bf_videos_manager_admin.php');
			
		class bf_videos_manager {
			
				
				/*****************************************************************************************/
				      /// Settings:
				/*****************************************************************************************/
				//---- plugin options
				var $customfields;				

				const CUSTOM_POST_TYPE_ID = 'bf_videos_manager';
				// const myplugin_text_domain = 'bf_videos_manager_text_domain';
				const myplugin_text_domain = 'bf_videos_manager';
				
				/******* constructor *********************/
				public function __construct()
				{
					
					$this->create_custom_post_type_extra_fields();
					$this->init();

				}//EOF
				
			 	private function load_plugin_textdomain() 
				{
				        load_plugin_textdomain('bf_videos_manager_text_domain', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
						add_action('init', array($this, 'load_plugin_textdomain'));
				
				 }//EOF
				
				
								
				private function create_custom_post_type_extra_fields()
				{
					$this->customfields = new stdClass;
					
					
					/* bf_videos_manager_video_link */
					$this->customfields->bf_videos_manager_video_link = new stdClass;
					$this->customfields->bf_videos_manager_video_link->type = 'text';
					$this->customfields->bf_videos_manager_video_link->title = '<b>Enter the YT Video Link:</b><br>';												
					$this->customfields->bf_videos_manager_video_link->description = 'Please enter the full YT video URL like below or leave it empty! <br><code><b>https://www.youtube.com/watch?v=6wgrY8YC4QQ</b></code>';
					
					/* bf_videos_manager_video_id */
					$this->customfields->bf_videos_manager_video_id = new stdClass;
					$this->customfields->bf_videos_manager_video_id->type = 'text';
					$this->customfields->bf_videos_manager_video_id->title = '<b> Enter ONLY the YT Video ID:</b><br>';												
					$this->customfields->bf_videos_manager_video_id->description = 'Please enter ONLY the YT video ID like below or leave it empty! <br><code><b>6wgrY8YC4QQ</b></code>';
					
					/* bf_videos_manager_video_link_to_content */
					$this->customfields->bf_videos_manager_video_link_to_content = new stdClass;
					$this->customfields->bf_videos_manager_video_link_to_content->type = 'text';
					$this->customfields->bf_videos_manager_video_link_to_content->title = '<b> Enter ONLY the WP post ID or the WP page ID:</b><br>';
					$this->customfields->bf_videos_manager_video_link_to_content->description = 'Please enter ONLY the WP post ID or the WP page ID like below or leave it empty! <br><code><b>11654</b></code>';
				

					/* bf_videos_manager_video_link_to_amazon */
					$this->customfields->bf_videos_manager_video_link_to_amazon = new stdClass;
					$this->customfields->bf_videos_manager_video_link_to_amazon->type = 'text';
					$this->customfields->bf_videos_manager_video_link_to_amazon->title = '<b> Enter the full Amazon URL or the shortlink:</b><br>';
					$this->customfields->bf_videos_manager_video_link_to_amazon->description = 'Please enter the Amazon URL like below or leave it empty! <br><code><b>https://www.amazon.com/dp/B08645F8DZ/</b></code>';
				
					/* bf_videos_manager_video_link_to_github */
					$this->customfields->bf_videos_manager_video_link_to_github = new stdClass;
					$this->customfields->bf_videos_manager_video_link_to_github->type = 'text';
					$this->customfields->bf_videos_manager_video_link_to_github->title = '<b> Enter the full Github URL:</b><br>';
					$this->customfields->bf_videos_manager_video_link_to_github->description = 'Please enter the Github URL or the shortlink like below or leave it empty!<br><code><b>https://github.com/bflaven/book-small-guide-zambia-wordpress-running-news-website</b></code>';


					/* bf_videos_manager_video_link_to_youtube_channel */
					$this->customfields->bf_videos_manager_video_link_to_youtube_channel = new stdClass;
					$this->customfields->bf_videos_manager_video_link_to_youtube_channel->type = 'text';
					$this->customfields->bf_videos_manager_video_link_to_youtube_channel->title = '<b> Enter the full Youtube Channel URL.</b><br>';
					$this->customfields->bf_videos_manager_video_link_to_youtube_channel->description = 'Please enter the Youtube Channel URL or the shortlink like below or leave it empty! <br><code><b>https://bit.ly/3bDSF2x</b></code>';


				}//EOF
				
				
				private function init()
				{
					// TextDomain
					add_action('init',array($this,'load_my_plugin_text_domain'));
					// CUSTOM POST TYPE				
					add_action( 'init', array($this,'register_custom_post_type' ));
					/* SET UP THE TAXONOMIES */
					add_action( 'init', array($this,'register_taxonomies' ));
					add_action( 'admin_init', array($this,'add_custom_fields_metabox' ),15,2);				
					add_action( 'save_post', array($this,'save_custom_fields' ));
					
					/*****************************************************************************************/
					      /// SHORTCODES
					/*****************************************************************************************/



				//*******  For shortcodes functions see this file shortcodes/bf_videos_manager_shortcodes.php ********/
				$sc = new bf_videos_manager_Shortcodes;
				
				
				//*******  For admin widgets functions see this file admin/bf_videos_manager_admin.php ********/
				$adm = new bf_videos_manager_Admin;
				
				
				// settings page
				
				if(is_admin()){
					add_action('admin_menu', array($this, 'add_plugin_page'));
					add_action('admin_init', array($this, 'page_init'));
				}
					
				}//EOF
				
				
																
				
				
				function load_my_plugin_text_domain()
				{
						load_plugin_textdomain( self::myplugin_text_domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
				}//EOF
				
					
				function do_custom_field($customfield) {
						global $post;
						$value = get_post_meta( $post->ID, $customfield, true );
						$type = $this->customfields->$customfield->type;
						// var_dump ($customfield);
						?>
						<p><?php echo $this->customfields->$customfield->title; ?>
						<?php
                       
						switch($type)
						{
							case 'text' :
										self::do_text($customfield,$value);
										break;	
							case 'checkbox' :
										self::do_checkbox($customfield,$value);
										break;	
							case 'textarea' :
										self::do_textarea($customfield,$value);
										break;
							case 'image' :
										self::do_image($customfield,$value);
										break;
							case 'color' :
										self::do_color($customfield,$value);
										break;
							case 'checkbox' :
										self::do_checkbox($customfield,$value);
										break;
							case 'richtext' :
										self::do_richtext($customfield,$value);
										break;
							case 'dropdown' :
							$drop_options = $this->customfields->$customfield->options;
							self::do_dropdown($customfield,$value,$drop_options);
							break;							
										
						}
						?>
						<?php echo $this->customfields->$customfield->description; ?>
						</p>
                        <?php		
								
				}
				
				
				/********************************************************
				 *					CUSTOM POST TYPE					*
				 ********************************************************/					
				
				public function register_custom_post_type()
				{
	
						
						$labels = array(
										'name' => __('Videos',self::myplugin_text_domain), // CAUTION Used in <title></title>
										/* Pour les nice-urls  citations-auteurs-mantras */
										// 'name' => __('Citations, Auteurs, Mantras',self::myplugin_text_domain), // CAUTION Used in <title></title>
										 'singular_name' => __('Video',self::myplugin_text_domain),
										  'add_new' => __('Add New Video',self::myplugin_text_domain),
										    'add_new_item' => __('Add New Video',self::myplugin_text_domain),
										    'edit_item' => __('Edit Video',self::myplugin_text_domain),
											'new_item' => __('New Video',self::myplugin_text_domain),
											'all_items' => __('All Videos',self::myplugin_text_domain),
										    'view_item' => __('View Video',self::myplugin_text_domain),
										    'search_items' => __('Search Videos',self::myplugin_text_domain),
										    'not_found' => __('No Video Found',self::myplugin_text_domain),
										    'not_found_in_trash' => __('No Video Found In Trash',self::myplugin_text_domain),
											'search_items' => __('Search Videos',self::myplugin_text_domain),
										    'popular_items' => __('Popular Videos',self::myplugin_text_domain),
										    'separate_items_with_commas' => __('Separate videos with commas',self::myplugin_text_domain),
										    'add_or_remove_items' => __('Add or remove Videos',self::myplugin_text_domain),
										    'choose_from_most_used' => __('Choose from the most popular Videos',self::myplugin_text_domain),
											'parent_item_colon' => '',
											'menu_name' =>  __('Videos',self::myplugin_text_domain)
											);
						
						$args = array(
								'labels' => $labels,
								'has_archive' => true,
								'public' => true,
								'exclude_from_search'=> false,
								'publicly_queryable' => true,
								'show_ui' => true, 
								'_builtin' => false,
								'show_in_menu' => true,
								'hierarchical' => false,
								'show_tagcloud' => false, 
								// 'rewrite' => true,
									/* Global control over capabilities. */
									// 'capability_type' => 'bf_videos_manager_editor',

									/* Specific control over capabilities. */
									/*
									'capabilities' => array(
										'edit_post' => 'edit_post_bf_videos_manager_editor',
										'edit_posts' => 'edit_posts_bf_videos_manager_editor',
										'edit_others_posts' => 'edit_others_bf_videos_manager_editor',
										'publish_posts' => 'publish_posts_bf_videos_manager_editor',
										'read_post' => 'read_post_bf_videos_manager_editor',
										'read_private_posts' => 'read_private_bf_videos_manager_editor',
										'delete_post' => 'delete_post_bf_videos_manager_editor',
									),
								*/								
								'has_archive' => true, 
								'hierarchical' => false,
								'menu_position' => null,
								// Add 'revisions' (will store revisions) to the post_type 08/11/13
								'supports' => array( 'title', 'editor','author', 'revisions', 'thumbnail', 'excerpt', 'comments' ),
								'query_var' => 'bf_videos_manager',
								'rewrite' => array(
									// 'slug' => 'books',
									/* Pour les nice-urls  livre-achat-occasion-ressources-formation */
									// 'slug' => 'les-citations',
									'slug' => 'videos',
								    'with_front' => false,
								  ),
								// 'menu_icon' => WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)). '/image/quotes_img.png'
								'menu_icon' => 'dashicons-media-video'
							  );
						register_post_type(self::CUSTOM_POST_TYPE_ID,$args);
						

				}//EOF
				
				/********************************************************
				 *					REGISTER TAXONOMIES					*
				 ********************************************************/
				
				public function register_taxonomies()
				{	
					
					/*- TAGS -*/
					/* Add new taxonomy, make it hierarchical (like categories) */
					/* Set up the product taxonomy arguments. */
				    $bf_videos_manager_author_args = array(
						'hierarchical'      => true,
				    'query_var' => 'bf_videos_manager_tag',
						'exclude_from_search'=> false, 
				        'show_tagcloud' => true,
				        'rewrite' => array(
				            // 'slug' => 'auteurs-citations',
				            'slug' => 'videos-tags',
				            'with_front' => false
				        ),
				
				            'labels' => array(
				            'name' => __('Tags',self::myplugin_text_domain),
								    /* Pour les nice-urls  citations-auteurs-mantras */
										// 'name' => __('Citations, Auteurs, Mantras',self::myplugin_text_domain), // CAUTION Used in <title></title>
							'singular_name' => __('Tag',self::myplugin_text_domain),
							'edit_item' => __('Edit Tag',self::myplugin_text_domain),
							'update_item' => __('Update Tag',self::myplugin_text_domain),
							'add_new_item' => __('Add New Tag',self::myplugin_text_domain),
							'new_item_name' => __('New Tag Name',self::myplugin_text_domain),
							'all_items' => __('All Tags',self::myplugin_text_domain),
							'search_items' => __('Search Tag',self::myplugin_text_domain),
							'popular_items' => __('Popular Tag',self::myplugin_text_domain),
							'separate_items_with_commas' => __('Separate Tags with commas',self::myplugin_text_domain),
							'add_or_remove_items' => __('Add or remove Tags',self::myplugin_text_domain),
							'choose_from_most_used' => __('Choose from the most popular Tags',self::myplugin_text_domain),
				        ),
				    );
				 
				/* Register the product keyword taxonomy. THIS IS CATEGORY */
			    register_taxonomy( 'bf_videos_manager_tag', array( 'bf_videos_manager' ), $bf_videos_manager_author_args );
					
					/*- CATEGORIES -*/
					/* Add new taxonomy, make it hierarchical (like categories) */
					/* Set up the product taxonomy arguments. */
				    $bf_videos_manager_flavor_args = array(
						'hierarchical'      => true,
				    'query_var' => 'bf_videos_manager_cat',
						'exclude_from_search'=> false, 
				        'show_tagcloud' => true,
				        'rewrite' => array(
				            // 'slug' => 'saveurs-citations',
				            'slug' => 'videos-categories',
				            'with_front' => false
				        ),
				
				        'labels' => array(
				            'name' => __('Categories',self::myplugin_text_domain),
								    /* Pour les nice-urls  citations-auteurs-mantras */
										// 'name' => __('Citations, Auteurs, Mantras',self::myplugin_text_domain), // CAUTION Used in <title></title>
							'singular_name' => __('Category',self::myplugin_text_domain),
							'edit_item' => __('Edit Category',self::myplugin_text_domain),
							'update_item' => __('Update Category',self::myplugin_text_domain),
							'add_new_item' => __('Add New Category',self::myplugin_text_domain),
							'new_item_name' => __('New Category Name',self::myplugin_text_domain),
							'all_items' => __('All Categories',self::myplugin_text_domain),
							'search_items' => __('Search Categories',self::myplugin_text_domain),
							'popular_items' => __('Popular Categories',self::myplugin_text_domain),
							'separate_items_with_commas' => __('Separate Categories with commas',self::myplugin_text_domain),
							'add_or_remove_items' => __('Add or remove Categories',self::myplugin_text_domain),
							'choose_from_most_used' => __('Choose from the most popular Categories',self::myplugin_text_domain),
				        ),
				    );
				 
				/* Register the product keyword taxonomy. THIS IS CATEGORY */
			    register_taxonomy( 'bf_videos_manager_cat', array( 'bf_videos_manager' ), $bf_videos_manager_flavor_args );
			
			
				}// EOF
				
				//-------------------- CUSTOM FIELDS FOR CUSTOM POSTTYPE ------------------//
				public function save_custom_fields($post_id)
				{
					global $post;
					foreach($this->customfields as $property => $value)
					{
						if(isset($_POST[$property]))
						{
								//ATTENTION IL FAUT NETTOYER LES $_POST !!!!!!!!!
								$cleaned_input = $_POST[$property];					
								
								update_post_meta( $post->ID, $property, $cleaned_input );							
						}
					}
				}
				
				
				
				//------------------------ METABOXES ----------------------//
				
				public function add_custom_fields_metabox()
				{
					add_meta_box( 'bf_videos_manager_customfields-metabox',  __('Settings for Video',self::myplugin_text_domain), array($this,'render_bf_videos_manager_content_meta_box'), self::CUSTOM_POST_TYPE_ID, 'normal', 'core' );
					
				}
				public function render_bf_videos_manager_content_meta_box()
				{
						global $post;
						
						$bf_videos_manager_info_content = get_post_meta( $post->ID, 'bf_videos_manager_info_content', true );
						
						?>
						<?php
							foreach($this->customfields as $property => $value)
							{
								$this->do_custom_field($property);								
							}
					
						
						?>
						
					<?php	
						
				}
				/****************************************************
				 *						HELPERS						*
				 ****************************************************/
				
			
			
				function do_text($option,$value)
								{
												?>												
												<input type="text" name="<?php echo $option;?>" id="<?php echo $option;?>" value="<?php echo $value; ?>" class="regular-text" /><br><span class="description"></span>
												<?php		
												
								}
				//-----------------------------------------
				function do_textarea($option,$value)
				{
												?>
												<textarea name="<?php echo $option;?>" id="<?php echo $option;?>" rows="5" cols="125" tabindex="6"><?php echo $value; ?></textarea>
												
												<?php		
												
								}
								
					function do_image($option,$value,$exists)
					{
									$test_exists = $exists;
									if($test_exists !=-1 && $test_exists !='' )
									{
													?>
													<img src="<?php echo $test_exists; ?>" id="interstitial_image_view"><br/>
													<?php
									}
									
									?>
																<input id="interstitial_image" name="interstitial_image" type="text" size="60" value="<?php echo $value; ?>"/>
																<input id="upload_image_button" value="Get image" type="button" onclick="myMediaPopupHandler();" />
												<?php
								}
								
						function do_color($option,$value)
						{
										
										$option_value = get_option($option,'#FFF');
												
												?>
												<div class="color-picker" style="position:relative;">
													<input type="text" name="<?php echo $option;?>" id="color" value="<?php echo $value; ?>" />
													<div style="position: absolute;" id="colorpicker"></div>
												</div>
								<?php
								}
					function do_checkbox($option,$value)
					{
						?>
						<input type="checkbox" name="<?php echo $option;?>" id="<?php echo $option;?>" value="1" <?php checked( $value, 1 );?>/>
						<?php
					}
	
					function do_richtext($option,$value)
					{
						$args = array("textarea_name" => $option);
						wp_editor( $value, $option, $args );

					}
					
					function do_dropdown($option,$option_value,$drop_options)
					{
						?>						
						<select name="<?php echo $option;?>" id="<?php echo $option;?>">						
						<?php
							foreach($drop_options as $key=>$value)
							{
								$str = '<option value="'.$key.'"';
								if($key == $option_value)$str.=' selected="selected" ';
								$str.='>'.$value.'</option>';
								echo $str;
							}
						?>						
						</select>
						<?php
					}
					
					
						function add_plugin_page()
						{
							 // This page will be under "Settings"
							add_options_page('Settings Admin', 'Videos Help', 'manage_options', 'bf_videos_manager-setting-admin', array($this, 'create_admin_page'));
						}
						
						/*****************************************************************************************/
						      /// ADMIN PAGE FOR HELP
						/*****************************************************************************************/

						public function create_admin_page(){
							?>
							<div class="wrap">
								<?php screen_icon(); ?>
								<h2>Explications sur les shortcodes de BF Videos</h2>
								<p>Les statistiques complètes sont disponibles via le widget situé au début du <a href="<?php echo get_admin_url();?>">tableau de bord</a></p>
								<form method="post" action="options.php">
									<?php
											// This prints out all hidden setting fields
									settings_fields('bf_videos_manager_option_group');	
									do_settings_sections('bf_videos_manager-setting-admin');
								?>
									<?php //submit_button(); ?>
								</form>
							</div>
							
							

							<?php
							/* values  */
							$nb_rows_textarea = '3';
							$nb_cols_textarea = '30';

							?>
							
							
							<h3>Frequently Asked Questions</h3>
							
							<ol>
							
							  	<!-- SHORTCODES -->
    							<li>

    							<p><strong>How do I use the shortcodes?</strong></p>

    							<table class="form-table" border="0">
    							<tr valign="top">
    							<th scope="row"><strong>SHORTCODE</strong></th>
    							<th scope="row"><strong>DESCRIPTION</strong></th>
    							<th scope="row"><strong>FUNCTION</strong></th>
    							</tr>











                  <!-- line -->
    							<tr>
    								<td valign="top"><textarea name="bf_videos_manager_shortcodes" rows="<?php echo $nb_rows_textarea;?>" cols="<?php echo $nb_cols_textarea;?>" id="bf_videos_manager_shortcodes" class="small-text code">[bf_videos_manager_random]</textarea></td>
    								<td valign="top">Listing a random video</td>
    								<td valign="top"><code>See function do_video_random in <code>shortcodes/bf_videos_manager_shortcodes.php</code></td>

    							</tr>
    							<!-- // line -->
    							
    							

    							<!-- line -->
    							<tr>
    								<td valign="top"><textarea name="bf_videos_manager_shortcodes" rows="<?php echo $nb_rows_textarea;?>" cols="<?php echo $nb_cols_textarea;?>" id="bf_videos_manager_shortcodes" class="small-text code">[bf_videos_manager_single posts="966"]</textarea></td>
    								<td valign="top">Listing one quote based on the ID of the quote</td>
    								<td valign="top"><code>See function do_quote_single in <code>shortcodes/bf_videos_manager_shortcodes.php</code></td>

    							</tr>
    							<!-- // line -->
    							
    							<!-- line -->
    							<tr>
    								<td valign="top"><textarea name="bf_videos_manager_shortcodes" rows="<?php echo $nb_rows_textarea;?>" cols="<?php echo $nb_cols_textarea;?>" id="bf_videos_manager_shortcodes" class="small-text code">[bf_videos_manager_fulllist]</textarea></td>
    								<td valign="top">Listing of all the videos from the manager</td>
    								<td valign="top"><code>See function do_videos_listing in <code>shortcodes/bf_videos_manager_shortcodes.php</code></td>

    							</tr>
    							<!-- // line -->

    							</table>
    							</li>

							
							<li>
							<!-- CSS -->
							
							<p><strong>How do I change the style?</strong></p>

							<table class="form-table">
							<tr valign="top">
							<th scope="row">The CSS</th>
							<td>
							Check out bf_videos_manager.css in <code>css/bf_videos_manager.css</code> 
							</td>
							</tr>
							</table>
							</li>
							
							</ul>
						
							
						<?php
					}//EOF


						function page_init()
						{
							//
						}//EOF
					
			
		} // end of class
		

		/* Instantiate the class */
		$bf_videos_manager_wp_instance = new bf_videos_manager;	

	
?>