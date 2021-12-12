<?php
  class bf_videos_manager_Shortcodes {
		
		/******* constructor *********************/
		public function __construct()
		{
			$this->init();
		}//EOF
		
		
		
		public function init()
		{
			
				/*****************************************************************************************/
				      /// SHORTCODES
				/*****************************************************************************************/
				/* Register the [bf_videos_manager_fulllist] shortcode. */
				add_shortcode('bf_videos_manager_fulllist',array($this,'do_videos_listing'));
				
				/* Register the [bf_videos_manager_single] shortcode. */
				add_shortcode('bf_videos_manager_single',array($this,'do_video_single'));
				
				
				/* Register the [bf_videos_manager_random] shortcode. */
				add_shortcode('bf_videos_manager_random',array($this,'do_video_random'));
				
	
					
			
		  
		}//EOF
		

		/*****************************************************************************************/
		/*
		USAGE : Listing of all the quotes
		[bf_videos_manager_fulllist]
		*/
		/*****************************************************************************************/
	
		/*****************************************************************************************/
		/*
		FUNCTION :
		do_videos_listing
		*/
		/*****************************************************************************************/
	function do_videos_listing ($atts,$content) {
		
		extract( shortcode_atts( array(
									/*  USELESS */
									),
						$atts));
		ob_start();				

		$args = array(
			'posts_per_page'=> -1,
			'post_type'=>'bf_videos_manager',
			);
		$query = new WP_Query($args);
		$all_videos = $query->posts;

		ob_start();
		
		// print_r ($all_videos);
		foreach ($all_videos as $video_single) {

      $bf_video_tag = get_post_meta($video_single->ID,'bf_videos_manager_tag', true);
      $bf_video_link = get_post_meta($video_single->ID,'bf_videos_manager_video_link', true);
      $video_img = get_the_post_thumbnail($video_single->ID);
      $permalink = get_permalink($video_single->ID);

                ?>
                  <div class="textwidget text">
                      <?php
                      /* DEBUG */
                      // print_r($video_single);
                      ?>
                      <?php 

              /* echo (''.$video_img.''); */

              ?>
                      
                      
                      <p class="video-excerpt"><?php 


              echo do_shortcode('<code>'.$bf_video_link.' '.$bf_video_main_tag.'</code>');
              
              
              ?></p>
                      


                      <?php 

          $bf_video_tag = get_the_term_list($video_single->ID, 'bf_videos_manager_tag', 'Tag(s) : ', ', ', '' );
          $bf_video_cat = get_the_term_list($video_single->ID, 'bf_videos_manager_cat', 'Categorie(s) : ', ', ', '' );


                      /* AUTHORS */
                      if ( !empty( $bf_video_tag)) {
                          echo (''.$bf_video_tag.'');
                          echo ('<br>');
                      } 

                      /* FLAVORS */
                      if ( !empty( $bf_video_cat)) {
                          echo (''.$bf_video_cat.'');
                          echo ('<br>');
                      }
                      ?>
						
				        
				
				 <?php
				  /* SEP */
          print('<br/><br/>');
				  ?>
				</div>
				<!-- separator -->
				<div class="clear-div"></div>
			

			
		<?php

		}//EFL
		
			$output_string = ob_get_contents();
			wp_reset_query();
			ob_end_clean();			
			return $output_string;

		}//EOF
			/*****************************************************************************************/
			/*
			END FUNCTION :
			do_videos_listing
			*/
			/*****************************************************************************************/
	
	
	    /*****************************************************************************************/
      /*
      USAGE: List a specific quote based on the ID of the post_type

      [bf_videos_manager_single posts="966"]

      */
      /*****************************************************************************************/



      								/*****************************************************************************************/
      								/*
      								FUNCTION :
      								do_video_single
      								*/
      								/*****************************************************************************************/
      									function do_video_single($atts,$content)
      									{

      											extract( shortcode_atts( array(
      														'posts' => '0',
      														),
      															$atts));

      											ob_start();				

      											$args = array(
      												'post_type'=>'bf_videos_manager',
      												'post__in' => array($posts),
      											);

      											$query = new WP_Query($args);
      											$all_videos = $query->posts;
      											// print_r($all_videos);
      											//$all_videos = count(query_posts($args));
      											//The Loop
      											if (empty($all_videos)) {

      												echo ('<code>Désolé, il n\'y as pas de video avec un ID de cette valeur  <strong>'.$posts.'</strong></code>');
      											}
      											foreach($all_videos as $video_single)
      											{
                              $bf_video_tag = get_post_meta($video_single->ID,'bf_videos_manager_tag', true);
                              $bf_video_link = get_post_meta($video_single->ID,'bf_videos_manager_video_link', true);


                              $video_img = get_the_post_thumbnail($video_single->ID);
                              $permalink = get_permalink($video_single->ID);

      					?>
      						<div class="textwidget text">
          						<?php
          						/* DEBUG */
          						// print_r($video_single);
          						?>
          						<?php 

          		/* echo (''.$video_img.''); */

          		?>
          						
          						
          						<p class="video-excerpt"><?php 


              echo do_shortcode('<code>'.$bf_video_link.' '.$bf_video_main_tag.'</code>');
              
              
          		?></p>
                      


          						<?php 

          $bf_video_tag = get_the_term_list($video_single->ID, 'bf_videos_manager_tag', 'Tag(s) : ', ', ', '' );
          $bf_video_cat = get_the_term_list($video_single->ID, 'bf_videos_manager_cat', 'Categorie(s) : ', ', ', '' );


          						/* AUTHORS */
          						if ( !empty( $bf_video_tag)) {
          								echo (''.$bf_video_tag.'');
          								echo ('<br>');
          						} 

          						/* FLAVORS */
          						if ( !empty( $bf_video_cat)) {
          								echo (''.$bf_video_cat.'');
          								echo ('<br>');
          						}
          					  ?>



          				 <?php
          				  /* SEP */
                    print('<br/><br/>');
          				  ?>
          				</div>
          				<!-- separator -->
          				<div class="clear-div"></div>

      					        

      											<?php
      											 }//EOL	
      											?>
      											<?php
      											$output_string = ob_get_contents();
      											wp_reset_query();
      											ob_end_clean();			
      											return $output_string;

      										}//EOF
                      /*****************************************************************************************/
                      /*
                      END FUNCTION :
                      do_video_single
                      */
                      /*****************************************************************************************/


                      /*****************************************************************************************/
                      /*
                      USAGE: List a random quote

                      [bf_videos_manager_random]

                      */
                      /*****************************************************************************************/



                      								/*****************************************************************************************/
                      								/*
                      								FUNCTION :
                      								do_video_random
                      								*/
                      								/*****************************************************************************************/
                      									function do_video_random($atts,$content)
                      									{

                      											extract( shortcode_atts( array(
                      														'posts' => '0',
                      														),
                      															$atts));

                      											ob_start();				

                      											$args = array(
                      												'post_type'=>'bf_videos_manager',
                      												// 'post__in' => array($posts),
                      												'posts_per_page' => '1',
                      												'orderby' => 'rand',
                      											);

                      											$query = new WP_Query($args);
                      											$all_videos = $query->posts;
                      											// print_r($all_posts);
                      											//$all_posts = count(query_posts($args));
                      											//The Loop
                      											if (empty($all_videos)) {

                      												echo ('<code>Désolé, il n\'y as pas de video avec un ID de cette valeur  <strong>'.$posts.'</strong>');
                      											}
                      											foreach($all_videos as $video_single)
                      											{
                                          
                                          
                $bf_video_tag = get_post_meta($video_single->ID,'bf_videos_manager_tag', true);
                $bf_video_link = get_post_meta($video_single->ID,'bf_videos_manager_video_link', true);


                              $video_img = get_the_post_thumbnail($video_single->ID);
                              $permalink = get_permalink($video_single->ID);

                ?>
                  <div class="textwidget text">
                      <?php
                      /* DEBUG */
                      // print_r($video_single);
                      ?>
                      <?php 

              // echo (''.$video_img.'');

              ?>
                      
                      
                      <p class="video-excerpt"><?php 


              echo do_shortcode('<code>'.$bf_video_link.'</code>');
              
              
              ?></p>
                      


            <?php 

          $bf_video_tag = get_the_term_list($video_single->ID, 'bf_videos_manager_tag', 'Tag(s) : ', ', ', '' );
          $bf_video_cat = get_the_term_list($video_single->ID, 'bf_videos_manager_cat', 'Categorie(s) : ', ', ', '' );


                      /* AUTHORS */
                      if ( !empty( $bf_video_tag)) {
                          echo (''.$bf_video_tag.'');
                          echo ('<br>');
                      } 

                      /* FLAVORS */
                      if ( !empty( $bf_video_cat)) {
                          echo (''.$bf_video_cat.'');
                          echo ('<br>');
                      }
                      ?>




                          				 <?php
                          				  /* SEP */
                                    print('<br/><br/>');
                          				  ?>
                          				</div>
                          				<!-- separator -->
                          				<div class="clear-div"></div>



                      											<?php
                      											 }//EOL	
                      											?>
                      											<?php
                      											$output_string = ob_get_contents();
                      											wp_reset_query();
                      											ob_end_clean();			
                      											return $output_string;

                      										}//EOF
                                      /*****************************************************************************************/
                                      /*
                                      END FUNCTION :
                                      do_video_random
                                      */
                                      /*****************************************************************************************/
				
			
          
      	
  			
  }//EOC
  
  ?>