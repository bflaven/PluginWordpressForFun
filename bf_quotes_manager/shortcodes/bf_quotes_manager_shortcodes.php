<?php
  class Bf_Quotes_Manager_Shortcodes {
		
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
				/* Register the [bf_quotes_manager_fulllist] shortcode. */
				add_shortcode('bf_quotes_manager_fulllist',array($this,'do_quotes_listing'));
				
				/* Register the [bf_quotes_manager_single] shortcode. */
				add_shortcode('bf_quotes_manager_single',array($this,'do_quote_single'));
				
				
				/* Register the [bf_quotes_manager_random] shortcode. */
				add_shortcode('bf_quotes_manager_random',array($this,'do_quote_random'));
				
				/* Register the [bf_quotes_manager_fulllist_alpha] shortcode. */
				add_shortcode('bf_quotes_manager_fulllist_alpha_author',array($this,'do_quotes_listing_alpha_order_author'));
				
				
				/* Register the [bf_quotes_manager_fulllist_alpha] shortcode. */
				add_shortcode('bf_quotes_manager_fulllist_alpha_flavor',array($this,'do_quotes_listing_alpha_order_flavors'));
				// 
				
				
			
		  
		}//EOF
		

		/*****************************************************************************************/
		/*
		USAGE : Listing of all the quotes
		[bf_quotes_manager_fulllist]
		*/
		/*****************************************************************************************/
	
		/*****************************************************************************************/
		/*
		FUNCTION :
		do_quotes_listing
		*/
		/*****************************************************************************************/
	function do_quotes_listing ($atts,$content) {
		
		extract( shortcode_atts( array(
									/*  USELESS */
									),
						$atts));
		ob_start();				

		$args = array(
			'posts_per_page'=> -1,
			'post_type'=>'bf_quotes_manager',
			);
		$query = new WP_Query($args);
		$all_quotes = $query->posts;

		ob_start();
		
		// print_r ($all_quotes);
		foreach ($all_quotes as $quote_single) {
      $bf_quote_main_text = get_post_meta($quote_single->ID,'bf_quotes_manager_main_text', true);
      $bf_quote_main_author = get_post_meta($quote_single->ID,'bf_quotes_manager_main_author', true);
      $quote_img = get_the_post_thumbnail($quote_single->ID);
      $permalink = get_permalink($quote_single->ID);
			
			?>

			
				<div class="textwidget text">
						<?php
						/* DEBUG */
						// print_r($quote_single);
						?>
					  <p class="quote-excerpt"><?php 


    echo do_shortcode('[box title="'.$bf_quote_main_author.'" type="whitestroke" pb_margin_bottom="yes" width="1/1" el_position="first"] [blockquote3]'.$bf_quote_main_text.' '.$bf_quote_main_author.'[/blockquote3] [/box]');
    
    
		?></p>
		
		
						<?php 

$bf_quote_author = get_the_term_list($quote_single->ID, 'bf_quotes_manager_author', 'Auteur(s) : ', ', ', '' );
$bf_quote_flavor = get_the_term_list($quote_single->ID, 'bf_quotes_manager_flavor', 'Saveur(s) : ', ', ', '' );


						/* AUTHORS */
						if ( !empty( $bf_quote_author)) {
								echo (''.$bf_quote_author.'');
								echo ('<br>');
						} 

						/* FLAVORS */
						if ( !empty( $bf_quote_flavor)) {
								echo (''.$bf_quote_flavor.'');
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
			do_quotes_listing
			*/
			/*****************************************************************************************/
	
	
	    /*****************************************************************************************/
      /*
      USAGE: List a specific quote based on the ID of the post_type

      [bf_quotes_manager_single posts="966"]

      */
      /*****************************************************************************************/



      								/*****************************************************************************************/
      								/*
      								FUNCTION :
      								do_quote_single
      								*/
      								/*****************************************************************************************/
      									function do_quote_single($atts,$content)
      									{

      											extract( shortcode_atts( array(
      														'posts' => '0',
      														),
      															$atts));

      											ob_start();				

      											$args = array(
      												'post_type'=>'bf_quotes_manager',
      												'post__in' => array($posts),
      											);

      											$query = new WP_Query($args);
      											$all_quotes = $query->posts;
      											// print_r($all_posts);
      											//$all_posts = count(query_posts($args));
      											//The Loop
      											if (empty($all_quotes)) {

      												echo ('<code>Désolé, il n\'y as pas de livre avec un ID de cette valeur  <strong>'.$posts.'</strong></code>');
      											}
      											foreach($all_quotes as $quote_single)
      											{
      											  $bf_quote_main_text = get_post_meta($quote_single->ID,'bf_quotes_manager_main_text', true);
                              $bf_quote_main_author = get_post_meta($quote_single->ID,'bf_quotes_manager_main_author', true);
                              $quote_img = get_the_post_thumbnail($quote_single->ID);
                              $permalink = get_permalink($quote_single->ID);

      					?>
      						<div class="textwidget text">
          						<?php
          						/* DEBUG */
          						// print_r($quote_single);
          						?>
          						<?php 

          		/* echo (''.$quote_img.''); */

          		?>
          						
          						
          						<p class="quote-excerpt"><?php 


              echo do_shortcode('[box title="'.$bf_quote_main_author.'" type="whitestroke" pb_margin_bottom="yes" width="1/1" el_position="first"] [blockquote3]'.$bf_quote_main_text.' '.$bf_quote_main_author.'[/blockquote3] [/box]');
              
              
          		?></p>
                      


          						<?php 

          $bf_quote_author = get_the_term_list($quote_single->ID, 'bf_quotes_manager_author', 'Auteur(s) : ', ', ', '' );
          $bf_quote_flavor = get_the_term_list($quote_single->ID, 'bf_quotes_manager_flavor', 'Saveur(s) : ', ', ', '' );


          						/* AUTHORS */
          						if ( !empty( $bf_quote_author)) {
          								echo (''.$bf_quote_author.'');
          								echo ('<br>');
          						} 

          						/* FLAVORS */
          						if ( !empty( $bf_quote_flavor)) {
          								echo (''.$bf_quote_flavor.'');
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
                      do_quote_single
                      */
                      /*****************************************************************************************/


                      /*****************************************************************************************/
                      /*
                      USAGE: List a random quote

                      [bf_quotes_manager_random]

                      */
                      /*****************************************************************************************/



                      								/*****************************************************************************************/
                      								/*
                      								FUNCTION :
                      								do_quote_random
                      								*/
                      								/*****************************************************************************************/
                      									function do_quote_random($atts,$content)
                      									{

                      											extract( shortcode_atts( array(
                      														'posts' => '0',
                      														),
                      															$atts));

                      											ob_start();				

                      											$args = array(
                      												'post_type'=>'bf_quotes_manager',
                      												// 'post__in' => array($posts),
                      												'posts_per_page' => '1',
                      												'orderby' => 'rand',
                      											);

                      											$query = new WP_Query($args);
                      											$all_quotes = $query->posts;
                      											// print_r($all_posts);
                      											//$all_posts = count(query_posts($args));
                      											//The Loop
                      											if (empty($all_quotes)) {

                      												echo ('<code>Désolé, il n\'y as pas de livre avec un ID de cette valeur  <strong>'.$posts.'</strong>');
                      											}
                      											foreach($all_quotes as $quote_single)
                      											{
                                          
                                          
                    $bf_quote_main_text = get_post_meta($quote_single->ID,'bf_quotes_manager_main_text', true);
                    $bf_quote_main_author = get_post_meta($quote_single->ID,'bf_quotes_manager_main_author', true);
                    $permalink = get_permalink($quote_single->ID);

                      					?>
                      						<div class="textwidget text">
                          						<?php
                          						/* DEBUG */
                          						// print_r($quote_single);
                          						?>
                          						<p class="quote-excerpt"><?php 


                              echo do_shortcode('[box title="'.$bf_quote_main_author.'" type="whitestroke" pb_margin_bottom="yes" width="1/1" el_position="first"] [blockquote3]'.$bf_quote_main_text.' '.$bf_quote_main_author.'[/blockquote3] [/box]');
                              
                              
                          		?></p>


                          						<?php 

                          $bf_quote_author = get_the_term_list($quote_single->ID, 'bf_quotes_manager_author', 'Auteur(s) : ', ', ', '' );
                          $bf_quote_flavor = get_the_term_list($quote_single->ID, 'bf_quotes_manager_flavor', 'Saveur(s) : ', ', ', '' );


                          						/* AUTHORS */
                          						if ( !empty( $bf_quote_author)) {
                          								echo (''.$bf_quote_author.'');
                          								echo ('<br>');
                          						} 

                          						/* FLAVORS */
                          						if ( !empty( $bf_quote_flavor)) {
                          								echo (''.$bf_quote_flavor.'');
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
                                      do_quote_random
                                      */
                                      /*****************************************************************************************/
				
			/*****************************************************************************************/
  		/*
  		USAGE : Listing of all the quotes by alphabetic order based on author
  		[bf_quotes_manager_fulllist_alpha_author]
  		*/
  		/*****************************************************************************************/

  		/*****************************************************************************************/
  		/*
  		FUNCTION :
  		do_quotes_listing_alpha_order_author
  		*/
  		/*****************************************************************************************/
  	function do_quotes_listing_alpha_order_author ($atts,$content) {

  		extract( shortcode_atts( array(
  									/*  USELESS */
  									),
  						$atts));
  		ob_start();				
      // print_r ($all_quotes);
  			?>
            
            <?php /*  INSERT */ ?>

            <?php
            $categories = get_terms('bf_quotes_manager_author', 'orderby=count&order=DESC&hide_empty=1');
             foreach( $categories as $category ): 
             ?>
             <?php 
             // Prints the cat/taxonomy group title 
             // echo ('<b>'.$category->name.'</b>');
             ?>
             <?php
             $posts = get_posts(array(
             'post_type' => 'bf_quotes_manager',
             'taxonomy' => $category->taxonomy,
             'term' => $category->slug,
             'nopaging' => true,
             ));
             foreach($posts as $post): 
             setup_postdata($post); //enables the_title(), the_content(), etc. without specifying a post ID
             
             $bf_quote_main_text = get_post_meta($post->ID,'bf_quotes_manager_main_text', true);
             $bf_quote_main_author = get_post_meta($post->ID,'bf_quotes_manager_main_author', true);
             $quote_img = get_the_post_thumbnail($post->ID);
             $permalink = get_permalink($post->ID);
             ?>


              <div class="textwidget text">
      						<?php
      						/* DEBUG */
      						// print_r($post);
      						?>
      						<p class="quote-excerpt"><?php 


          echo do_shortcode('[box title="'.$bf_quote_main_author.'" type="whitestroke" pb_margin_bottom="yes" width="1/1" el_position="first"] [blockquote3]'.$bf_quote_main_text.' '.$bf_quote_main_author.'[/blockquote3] [/box]');
          
          
      		?></p>
                  


      						<?php 

      $bf_quote_author = get_the_term_list($post->ID, 'bf_quotes_manager_author', 'Auteur(s) : ', ', ', '' );
      $bf_quote_flavor = get_the_term_list($post->ID, 'bf_quotes_manager_flavor', 'Saveur(s) : ', ', ', '' );


      						/* AUTHORS */
      						if ( !empty( $bf_quote_author)) {
      								echo (''.$bf_quote_author.'');
      								echo ('<br>');
      						} 

      						/* FLAVORS */
      						if ( !empty( $bf_quote_flavor)) {
      								echo (''.$bf_quote_flavor.'');
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
 

             <?php endforeach; ?>

            <?php endforeach; ?>

            <?php /*  INSERT */ ?>

  		<?php
  			$output_string = ob_get_contents();
  			wp_reset_query();
  			ob_end_clean();			
  			return $output_string;

  		}//EOF
  			/*****************************************************************************************/
  			/*
  			END FUNCTION :
  			do_quotes_listing_alpha_order_author
  			*/
  			/*****************************************************************************************/
  
  
        /*****************************************************************************************/
    		/*
    		USAGE : Listing of all the quotes by alphabetic order based on flavor
    		[bf_quotes_manager_fulllist_alpha_flavor]
    		*/
    		/*****************************************************************************************/
  
          /*****************************************************************************************/
    		/*
    		FUNCTION :
    		do_quotes_listing_alpha_order_flavors
    		*/
    		/*****************************************************************************************/
    	function do_quotes_listing_alpha_order_flavors ($atts,$content) {

    		extract( shortcode_atts( array(
    									/*  USELESS */
    									),
    						$atts));
    		ob_start();				
        // print_r ($all_quotes);
    			?>

              <?php /*  INSERT */ ?>

              <?php
              $categories = get_terms('bf_quotes_manager_flavor', 'orderby=count&order=DESC&hide_empty=1');
               foreach( $categories as $category ): 
               ?>
               <?php 
                // Prints the cat/taxonomy group title 
                echo ('<h3>'.$category->name.'</h3>');
                ?>
               <?php
               $posts = get_posts(array(
               'post_type' => 'bf_quotes_manager',
               'taxonomy' => $category->taxonomy,
               'term' => $category->slug,
               'nopaging' => true,
               ));
               foreach($posts as $post): 
               setup_postdata($post); //enables the_title(), the_content(), etc. without specifying a post ID
               
               $bf_quote_main_text = get_post_meta($post->ID,'bf_quotes_manager_main_text', true);
                $bf_quote_main_author = get_post_meta($post->ID,'bf_quotes_manager_main_author', true);
                $quote_img = get_the_post_thumbnail($post->ID);
                $permalink = get_permalink($post->ID);
                
                
               ?>


                <div class="textwidget text">
        						<?php
        						/* DEBUG */
        						// print_r($post);
        						?>
        						<p class="quote-excerpt"><?php 
        						
        		// print (''.$quote_img.'');
            echo do_shortcode('[box title="'.$bf_quote_main_author.'" type="whitestroke" pb_margin_bottom="yes" width="1/1" el_position="first"] [blockquote3]'.$bf_quote_main_text.' '.$bf_quote_main_author.'[/blockquote3] [/box]');


        		?></p>


        						<?php 

        $bf_quote_author = get_the_term_list($post->ID, 'bf_quotes_manager_author', 'Auteur(s) : ', ', ', '' );
        $bf_quote_flavor = get_the_term_list($post->ID, 'bf_quotes_manager_flavor', 'Saveur(s) : ', ', ', '' );


        						/* AUTHORS */
        						if ( !empty( $bf_quote_author)) {
        								echo (''.$bf_quote_author.'');
        								echo ('<br>');
        						} 

        						/* FLAVORS */
        						if ( !empty( $bf_quote_flavor)) {
        								echo (''.$bf_quote_flavor.'');
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


               <?php endforeach; ?>

              <?php endforeach; ?>

              <?php /*  INSERT */ ?>

    		<?php
    			$output_string = ob_get_contents();
    			wp_reset_query();
    			ob_end_clean();			
    			return $output_string;

    		}//EOF		
  		  /*****************************************************************************************/
  			/*
  			END FUNCTION :
  			do_quotes_listing_alpha_order_flavors
  			*/
  			/*****************************************************************************************/
  
      	
  			
  }//EOC
  
  ?>