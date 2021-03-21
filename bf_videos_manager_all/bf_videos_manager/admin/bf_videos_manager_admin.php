<?php

class bf_videos_manager_Admin {
		
		/******* constructor *********************/
		public function __construct()
		{
			$this->init();
		}//EOF
		
		
		
		public function init()
		{
			add_action('wp_dashboard_setup', array($this,'mycustom_dashboard_widgets'));
			add_action('wp_dashboard_setup', array($this,'mycustom_dashboard_widget_stats'));
		  
		}//EOF
		
		
			function mycustom_dashboard_widgets() {
				global $wp_meta_boxes;

				wp_add_dashboard_widget('bf_videos_manager_widget', 'BF VIDEOS', array($this,'custom_dashboard_display'),array($this,'custom_dashboard_configure'));
				$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
				$bf_videos_manager_widget = array('bf_videos_manager_widget' => $normal_dashboard['bf_videos_manager_widget']);
				$sorted_dashboard = array_merge($bf_videos_manager_widget, $normal_dashboard);
				$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;


			}//EOF

			function mycustom_dashboard_widget_stats() {
				global $wp_meta_boxes;

				wp_add_dashboard_widget('bf_videos_manager_stats_widget', 'BF VIDEOS STATS', array($this,'custom_dashboard_display_stats'));
				


			}//EOF
			
			function custom_dashboard_display_stats($widget)
			{
				?>
				
				<p>Les principales valeurs statistiques de l'intégration BF VIDEOS</p>
				<div class="inside">
					
						<?php
						// global $wpdb;
						/*
						=== JUST AS REMINDER
						post_type => product_for_sale
						taxonomy => product_for_sale_genre 
						taxonomy => product_for_sale_author 
						taxonomy => product_for_sale_kw 
						*/

						$num_posts_bf_videos_manager = wp_count_posts( 'bf_videos_manager');
						// Main figures for product_for_sale
						$num_product_for_sale = $num_posts_bf_videos_manager->publish;
						
						// nb for Tag(s)
						$num_cats_bf_videos_manager_tag  = wp_count_terms('bf_videos_manager_tag');

						// nb for Categorie(s)
						$num_tags_bf_videos_manager_cat  = wp_count_terms('bf_videos_manager_cat');

						  ?>
				<h4><strong>Les chiffres-clés</strong></h4>
				<ul>
					<li>Nombre d' Tag(s) : <b><?php echo (''.$num_cats_bf_videos_manager_tag.''); ?></b></li>
					<li>Nombre de Categorie(s) : <b><?php echo (''.$num_tags_bf_videos_manager_cat.''); ?></b></li>
					</ul>
				
				
				
				<h4><strong>Les dernières vidéos enregistrées</strong></h4>
			
				<?php
						/* LAST POSTS */
						$args = array(
							'offset' => 0,
						    'orderby' => 'post_date',
						    'order' => 'DESC',
							'numberposts' => '3',
							'post_status' => 'publish',
							'post_type' => 'bf_videos_manager'
							);
					        $recent_posts = wp_get_recent_posts( $args );
							/* debug only */
							// print_r($recent_posts);

					        foreach( $recent_posts as $recent ) {
					        setup_postdata(get_post($recent['ID']));
							// Output
							echo ('<ul><li><a class="rsswidget" href="' . get_permalink($recent['ID']) . '" title="'.esc_attr(get_the_title($recent['ID'])).'">' .   get_the_title($recent['ID']).'</a> <span class="rss-date">'.get_the_time('j F Y', $recent['ID']).'</span><div class="rssSummary">'.$recent['post_excerpt'].'</div></li>');						
						}// EOL
						wp_reset_postdata();
				?>
				
				
				</div>
					
				  <?php
				}//EOF
				
			function custom_dashboard_display($widget)
			{
			  if ( !$bf_videos_manager_widget_options = get_option( 'bf_videos_manager_dashboard_widget_options' ) )
			  {
				  $product_to_sale_widget_options = array();
			  }//EOI
			  ?>
				<p>Cliquez sur "configurer" dans la barre ci-dessus pour modifier les valeurs</p>
				<p><b>Pas d'Api, mon nom peut-être <code>Bruno Flaven</code> : </b><?php echo $bf_videos_manager_widget_options['bf_videos_manager_public_name'];?></p>
				
			  <?php
			}//EOF



			function custom_dashboard_configure($widget_id) {
			  // Get widget options
			  if ( !$bf_videos_manager_widget_options = get_option( 'bf_videos_manager_dashboard_widget_options' ) )
			  {
				  $bf_videos_manager_widget_options = array();
			  }//EOI

			  // Update widget options
			  if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['bf_videos_manager_widget_post']) ) {
				  update_option( 'bf_videos_manager_dashboard_widget_options', $_POST['bf_videos_manager_widget'] );
			  }//EOI

			  // Retrieve feed URLs
			  $val_1 = $bf_videos_manager_dashboard_widget_options['bf_videos_manager_public_name'];

			  ?>
		<p>
			<label for="rc_mdm_url_1-"><?php _e('Entrez le nom du manager de Quotes ici. Ex : <code>Bruno Flaven</code>', 'bf_videos_manager_text_domain'); ?></label>
			<input class="widefat" id="rc_mdm_url_1" name="bf_videos_manager_widget[bf_videos_manager_public_name]" type="text" value="<?php if( isset($val_1) ) echo $val_1; ?>" />
		</p>
		<input name="bf_videos_manager_widget_post" type="hidden" value="1" />
		<?php

			}// EOF

	}//EOC
		