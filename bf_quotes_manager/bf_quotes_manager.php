<?php
/*
Plugin Name: bf_quotes_manager
Plugin URI: http://flaven.fr
Description: Full built-up quotes manager
Version: 1.0
Author: Bruno Flaven
Author URI: http://hecube.net
*/
/* Pour les nice-urls  citations-auteurs-mantras */
	
	
	
	
	/*
     * register with hook 'wp_print_styles'
     */
    add_action('wp_print_styles', 'add_my_stylesheet_bf_quotes_manager');

/*
 * Enqueue style-file, if it exists.
 */
function add_my_stylesheet_bf_quotes_manager() {
$style_url_quotes_manager = plugin_dir_url( __FILE__ ).'css/bf_quotes_manager.css';
wp_enqueue_style( 'he3_front_css_quotes_manager', $style_url_quotes_manager);

}//EOF

		/*****************************************************************************************/
		      /// SHORTCODES
		/*****************************************************************************************/
		
		// 	/*******  For shortcodes functions see this file shortcodes/bf_quotes_manager_shortcodes.php ********/
	 	// Loading first required 
		require_once('shortcodes/bf_quotes_manager_shortcodes.php');
		require_once('admin/bf_quotes_manager_admin.php');
			
		class Bf_Quotes_Manager {
			
				
				
/*****************************************************************************************/
 /// Settings:
/*****************************************************************************************/
				//---- plugin options
				var $customfields;				

				const CUSTOM_POST_TYPE_ID = 'bf_quotes_manager';
				// const myplugin_text_domain = 'bf_quotes_manager_text_domain';
				const myplugin_text_domain = 'bf_quotes_manager';
				
				/******* constructor *********************/
				public function __construct()
				{
					
					$this->create_custom_post_type_extra_fields();
					$this->init();

				}//EOF
				
			 	private function load_plugin_textdomain() 
				{
				        load_plugin_textdomain('bf_quotes_manager_text_domain', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
						add_action('init', array($this, 'load_plugin_textdomain'));
				
				 }//EOF
				
				
								
				private function create_custom_post_type_extra_fields()
				{
					$this->customfields = new stdClass;
					
					/* bf_quotes_manager_main_text */
					$this->customfields->bf_quotes_manager_main_text = new stdClass;
					$this->customfields->bf_quotes_manager_main_text->type = 'textarea';
					$this->customfields->bf_quotes_manager_main_text->title = '<b>Quote texte :</b><br>';												
					$this->customfields->bf_quotes_manager_main_text->description = '<code>Veuillez entrer le texte de la quote. <br> Ex: <b>Ma patrie, c’est la langue française</b></code>';
					
					/* bf_quotes_manager_main_author */
					$this->customfields->bf_quotes_manager_main_author = new stdClass;
					$this->customfields->bf_quotes_manager_main_author->type = 'text';
					$this->customfields->bf_quotes_manager_main_author->title = '<b>Quote auteur :</b><br>';												
					$this->customfields->bf_quotes_manager_main_author->description = '<code>Veuillez entrer le texte de la quote. <br> Ex: <b>Albert Camus</b></code>';
					
					
				

				
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



				//*******  For shortcodes functions see this file shortcodes/bf_quotes_manager_shortcodes.php ********/
				$sc = new Bf_Quotes_Manager_Shortcodes;
				
				
				//*******  For admin widgets functions see this file admin/bf_quotes_manager_admin.php ********/
				$adm = new Bf_Quotes_Manager_Admin;
				
				
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
										'name' => __('Quotes',self::myplugin_text_domain), // CAUTION Used in <title></title>
										/* Pour les nice-urls  citations-auteurs-mantras */
										// 'name' => __('Citations, Auteurs, Mantras',self::myplugin_text_domain), // CAUTION Used in <title></title>
										 'singular_name' => __('Quote',self::myplugin_text_domain),
										  'add_new' => __('Add New Quote',self::myplugin_text_domain),
										    'add_new_item' => __('Add New Quote',self::myplugin_text_domain),
										    'edit_item' => __('Edit Quote',self::myplugin_text_domain),
											'new_item' => __('New Quote',self::myplugin_text_domain),
											'all_items' => __('All Quotes',self::myplugin_text_domain),
										    'view_item' => __('View Quote',self::myplugin_text_domain),
										    'search_items' => __('Search Quotes',self::myplugin_text_domain),
										    'not_found' => __('No Quote Found',self::myplugin_text_domain),
										    'not_found_in_trash' => __('No Quote Found In Trash',self::myplugin_text_domain),
											'search_items' => __('Search Quotes',self::myplugin_text_domain),
										    'popular_items' => __('Popular Quotes',self::myplugin_text_domain),
										    'separate_items_with_commas' => __('Separate quotes with commas',self::myplugin_text_domain),
										    'add_or_remove_items' => __('Add or remove Quotes',self::myplugin_text_domain),
										    'choose_from_most_used' => __('Choose from the most popular Quotes',self::myplugin_text_domain),
											'parent_item_colon' => '',
											'menu_name' =>  __('Quotes',self::myplugin_text_domain)
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
									// 'capability_type' => 'bf_quotes_manager_editor',

									/* Specific control over capabilities. */
									/*
									'capabilities' => array(
										'edit_post' => 'edit_post_bf_quotes_manager_editor',
										'edit_posts' => 'edit_posts_bf_quotes_manager_editor',
										'edit_others_posts' => 'edit_others_bf_quotes_manager_editor',
										'publish_posts' => 'publish_posts_bf_quotes_manager_editor',
										'read_post' => 'read_post_bf_quotes_manager_editor',
										'read_private_posts' => 'read_private_bf_quotes_manager_editor',
										'delete_post' => 'delete_post_bf_quotes_manager_editor',
									),
								*/								
								'has_archive' => true, 
								'hierarchical' => false,
								'menu_position' => null,
								// Add 'revisions' (will store revisions) to the post_type 08/11/13
								'supports' => array( 'title', 'editor','author', 'revisions', 'thumbnail', 'excerpt', 'comments' ),
								'query_var' => 'bf_quotes_manager',
								'rewrite' => array(
									// 'slug' => 'books',
									/* Pour les nice-urls  livre-achat-occasion-ressources-formation */
									'slug' => 'les-citations',
								    'with_front' => false,
								  ),
								'menu_icon' => WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)). '/image/quotes_img.png'
							  );
						register_post_type(self::CUSTOM_POST_TYPE_ID,$args);
						

				}//EOF
				
				/********************************************************
				 *					REGISTER TAXONOMIES					*
				 ********************************************************/
				
				public function register_taxonomies()
				{	
					
					/*- AUTHOR -*/
					/* Add new taxonomy, make it hierarchical (like categories) */
					/* Set up the product taxonomy arguments. */
				    $bf_quotes_manager_author_args = array(
						'hierarchical'      => true,
				    'query_var' => 'bf_quotes_manager_author',
						'exclude_from_search'=> false, 
				        'show_tagcloud' => true,
				        'rewrite' => array(
				            'slug' => 'auteurs-citations',
				            'with_front' => false
				        ),
				
				            'labels' => array(
				            'name' => __('Authors',self::myplugin_text_domain),
								    /* Pour les nice-urls  citations-auteurs-mantras */
										// 'name' => __('Citations, Auteurs, Mantras',self::myplugin_text_domain), // CAUTION Used in <title></title>
							'singular_name' => __('Author',self::myplugin_text_domain),
							'edit_item' => __('Edit Author',self::myplugin_text_domain),
							'update_item' => __('Update Author',self::myplugin_text_domain),
							'add_new_item' => __('Add New Author',self::myplugin_text_domain),
							'new_item_name' => __('New Author Name',self::myplugin_text_domain),
							'all_items' => __('All Authors',self::myplugin_text_domain),
							'search_items' => __('Search Author',self::myplugin_text_domain),
							'popular_items' => __('Popular Author',self::myplugin_text_domain),
							'separate_items_with_commas' => __('Separate Authors with commas',self::myplugin_text_domain),
							'add_or_remove_items' => __('Add or remove Authors',self::myplugin_text_domain),
							'choose_from_most_used' => __('Choose from the most popular Authors',self::myplugin_text_domain),
				        ),
				    );
				 
				/* Register the product keyword taxonomy. THIS IS CATEGORY */
			    register_taxonomy( 'bf_quotes_manager_author', array( 'bf_quotes_manager' ), $bf_quotes_manager_author_args );
					
					/*- FLAVOR -*/
					/* Add new taxonomy, make it hierarchical (like categories) */
					/* Set up the product taxonomy arguments. */
				    $bf_quotes_manager_flavor_args = array(
						'hierarchical'      => true,
				    'query_var' => 'bf_quotes_manager_flavor',
						'exclude_from_search'=> false, 
				        'show_tagcloud' => true,
				        'rewrite' => array(
				            'slug' => 'saveurs-citations',
				            'with_front' => false
				        ),
				
				        'labels' => array(
				            'name' => __('Flavors',self::myplugin_text_domain),
								    /* Pour les nice-urls  citations-auteurs-mantras */
										// 'name' => __('Citations, Auteurs, Mantras',self::myplugin_text_domain), // CAUTION Used in <title></title>
							'singular_name' => __('Flavor',self::myplugin_text_domain),
							'edit_item' => __('Edit Flavor',self::myplugin_text_domain),
							'update_item' => __('Update Flavor',self::myplugin_text_domain),
							'add_new_item' => __('Add New Flavor',self::myplugin_text_domain),
							'new_item_name' => __('New Flavor Name',self::myplugin_text_domain),
							'all_items' => __('All Flavors',self::myplugin_text_domain),
							'search_items' => __('Search Flavor',self::myplugin_text_domain),
							'popular_items' => __('Popular Flavor',self::myplugin_text_domain),
							'separate_items_with_commas' => __('Separate Flavors with commas',self::myplugin_text_domain),
							'add_or_remove_items' => __('Add or remove Flavors',self::myplugin_text_domain),
							'choose_from_most_used' => __('Choose from the most popular Flavors',self::myplugin_text_domain),
				        ),
				    );
				 
				/* Register the product keyword taxonomy. THIS IS CATEGORY */
			    register_taxonomy( 'bf_quotes_manager_flavor', array( 'bf_quotes_manager' ), $bf_quotes_manager_flavor_args );
			
			
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
					add_meta_box( 'bf_quotes_manager_customfields-metabox',  __('Settings for Quote',self::myplugin_text_domain), array($this,'render_bf_quotes_manager_content_meta_box'), self::CUSTOM_POST_TYPE_ID, 'normal', 'core' );
					
				}
				public function render_bf_quotes_manager_content_meta_box()
				{
						global $post;
						
						$bf_quotes_manager_info_content = get_post_meta( $post->ID, 'bf_quotes_manager_info_content', true );
						
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
							add_options_page('Settings Admin', 'Quotes Help', 'manage_options', 'bf_quotes_manager-setting-admin', array($this, 'create_admin_page'));
						}
						
						/*****************************************************************************************/
						      /// ADMIN PAGE FOR HELP
						/*****************************************************************************************/

						public function create_admin_page(){
							?>
							<div class="wrap">
								<?php screen_icon(); ?>
								<h2>Explications sur les shortcodes de BF Quotes</h2>
								<p>Les statistiques complètes sont disponibles via le widget situé au début du <a href="<?php echo get_admin_url();?>">tableau de bord</a></p>
								<form method="post" action="options.php">
									<?php
											// This prints out all hidden setting fields
									settings_fields('bf_quotes_manager_option_group');	
									do_settings_sections('bf_quotes_manager-setting-admin');
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
	<td valign="top"><textarea name="bf_quotes_manager_shortcodes" rows="<?php echo $nb_rows_textarea;?>" cols="<?php echo $nb_cols_textarea;?>" id="bf_quotes_manager_shortcodes" class="small-text code">[bf_quotes_manager_fulllist_alpha_flavor]</textarea></td>
	<td valign="top">Listing an alphabetic list of quotes based on flavor</td>
	<td valign="top"><code>See function do_quote_random in <code>shortcodes/bf_quotes_manager_shortcodes.php</code></td>

</tr>
<!-- // line -->


<!-- line -->
<tr>
	<td valign="top"><textarea name="bf_quotes_manager_shortcodes" rows="<?php echo $nb_rows_textarea;?>" cols="<?php echo $nb_cols_textarea;?>" id="bf_quotes_manager_shortcodes" class="small-text code">[bf_quotes_manager_fulllist_alpha_author]</textarea></td>
  <td valign="top">Listing an alphabetic list of quotes based on author</td>
	<td valign="top"><code>See function do_quote_random in <code>shortcodes/bf_quotes_manager_shortcodes.php</code></td>

</tr>
<!-- // line -->

                  <!-- line -->
    							<tr>
    								<td valign="top"><textarea name="bf_quotes_manager_shortcodes" rows="<?php echo $nb_rows_textarea;?>" cols="<?php echo $nb_cols_textarea;?>" id="bf_quotes_manager_shortcodes" class="small-text code">[bf_quotes_manager_random]</textarea></td>
    								<td valign="top">Listing a random quote</td>
    								<td valign="top"><code>See function do_quote_random in <code>shortcodes/bf_quotes_manager_shortcodes.php</code></td>

    							</tr>
    							<!-- // line -->
    							
    							

    							<!-- line -->
    							<tr>
    								<td valign="top"><textarea name="bf_quotes_manager_shortcodes" rows="<?php echo $nb_rows_textarea;?>" cols="<?php echo $nb_cols_textarea;?>" id="bf_quotes_manager_shortcodes" class="small-text code">[bf_quotes_manager_single posts="966"]</textarea></td>
    								<td valign="top">Listing one quote based on the ID of the quote</td>
    								<td valign="top"><code>See function do_quote_single in <code>shortcodes/bf_quotes_manager_shortcodes.php</code></td>

    							</tr>
    							<!-- // line -->
    							
    							<!-- line -->
    							<tr>
    								<td valign="top"><textarea name="bf_quotes_manager_shortcodes" rows="<?php echo $nb_rows_textarea;?>" cols="<?php echo $nb_cols_textarea;?>" id="bf_quotes_manager_shortcodes" class="small-text code">[bf_quotes_manager_fulllist]</textarea></td>
    								<td valign="top">Listing of all the quotes from the manager</td>
    								<td valign="top"><code>See function do_quotes_listing in <code>shortcodes/bf_quotes_manager_shortcodes.php</code></td>

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
							Check out bf_quotes_manager.css in <code>css/bf_quotes_manager.css</code> 
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
		$Bf_Quotes_Manager_wp_instance = new Bf_Quotes_Manager;	

	
?>