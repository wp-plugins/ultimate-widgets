<?php
/**
 * Ads Widget
*/
class uw_ads extends WP_Widget {
	
	function uw_ads() {
		
		// define widget title and description
		$widget_ops = array(
			'classname'		=> 'ads_widget',
			'description'	=> __( 'A widget that displays ads in sidebar.', 'khositeweb' )
		);
		// register the widget
		$this->WP_Widget('uw_ads', __( 'Widget - Ads', 'khositeweb' ), $widget_ops);
	
	}

	// display the widget in the theme
	function widget( $args, $instance ) {
		extract( $args );
			
		$title = apply_filters('widget_title', $instance['title'] );

		/* Variables from settings. */
		$ad1 = $instance['ad1'];
		$adlink1 = $instance['adlink1'];
		$ad2 = $instance['ad2'];
		$adlink2 = $instance['adlink2'];
		$ad3 = $instance['ad3'];
		$adlink3 = $instance['adlink3'];
		$ad4 = $instance['ad4'];
		$adlink4 = $instance['adlink4'];
		$ad5 = $instance['ad5'];
		$adlink5 = $instance['adlink5'];
		$ad6 = $instance['ad6'];
		$adlink6 = $instance['adlink6'];

		$allads = array();

		echo $before_widget;
			 if ( $title )
				 echo $before_title . $title . $after_title; ?>
				<div class="ads_widget clr">

					<?php if ( $adlink1 && $ad1 )
						$ads[] = '<a href="' . esc_url( $adlink1 ) . '" target="_blank" class="ad-320"><img src="'. esc_url( $ad1 ) .'" width="320" height="155" alt="" /></a>';
					
					// Display Ad 2
					if ( $adlink2 && $ad2 )
						$ads[] = '<a href="' . esc_url( $adlink2 ) . '" target="_blank"><img src="'. esc_url( $ad2 ) .'" width="320" height="155" alt="" /></a>';
						
					// Display Ad 3
					if ( $adlink3 && $ad3 )
						$ads[] = '<a href="' . esc_url( $adlink3 ) . '" target="_blank" class="ad-155"><img src="' . esc_url( $ad3 ) . '" width="155" height="155" alt="" /></a>';
						
					// Display Ad 4
					if ( $adlink4 && $ad4)
						$ads[] = '<a href="' . esc_url( $adlink4 ) . '" target="_blank" class="righter ad-155"><img src="' . esc_url( $ad4 ) . '" width="155" height="155" alt="" /></a>';
						
					// Display Ad 5
					if ( $adlink5 && $ad5)
						$ads[] = '<a href="' . esc_url( $adlink5 ) . '" target="_blank" class="ad-155"><img src="' . esc_url( $ad5 ) . '" width="155" height="155" alt="" /></a>';
						
					// Display Ad 6
					if ( $adlink6 && $ad6)
						$ads[] = '<a href="' . esc_url( $adlink6 ) . '" target="_blank" class="righter ad-155"><img src="' . esc_url( $ad6 ) . '" width="155" height="155" alt="" /></a>';
					
					//Display ads
					foreach($ads as $ad){
						echo $ad;
					} ?>
			</div>
			<?php
		echo $after_widget;

	}

/*----------------------------------------------------------*/
/*	Update the Widget
/*----------------------------------------------------------*/
	
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		/* Remove HTML: */
		$instance['title'] = strip_tags( $new_instance['title'] );

		/* Variables from settings. */
		$instance['ad1'] = $new_instance['ad1'] ;
		$instance['adlink1'] = $new_instance['adlink1'];
		$instance['ad2'] = $new_instance['ad2'];
		$instance['adlink2'] = $new_instance['adlink2'];
		$instance['ad3'] = $new_instance['ad3'] ;
		$instance['adlink3'] = $new_instance['adlink3'];
		$instance['ad4'] = $new_instance['ad4'] ;
		$instance['adlink4'] = $new_instance['adlink4'];
		$instance['ad5'] = $new_instance['ad5'] ;
		$instance['adlink5'] = $new_instance['adlink5'];
		$instance['ad6'] = $new_instance['ad6'] ;
		$instance['adlink6'] = $new_instance['adlink6'];				
	
		return $instance;
	}
	

/*----------------------------------------------------------*/
/*	Widget Settings
/*----------------------------------------------------------*/
	 
	function form( $instance ) {

		/* Default widget settings */
		$defaults = array(
			'title' => 'Sponsors',
			'random' => false,
			'ad1' => plugins_url( 'images/320x155.jpg', dirname(__FILE__) ),
			'adlink1' => 'http://themeforest.net/user/khositeweb/portfolio?ref=khositeweb',
			'ad2' => '',
			'adlink2' => '',
			'ad3' => plugins_url( 'images/155x155.jpg', dirname(__FILE__) ),
			'adlink3' => 'http://themeforest.net/user/khositeweb/portfolio?ref=khositeweb',
			'ad4' => plugins_url( 'images/155x155.jpg', dirname(__FILE__) ),
			'adlink4' => 'http://themeforest.net/user/khositeweb/portfolio?ref=khositeweb',
			'ad5' => '',
			'adlink5' => '',
			'ad6' => '',
			'adlink6' => ''
	
		);

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Ads Title (Optional):', 'khositeweb') ?></label>
		    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
		    <label for="<?php echo $this->get_field_id( 'ad1' ); ?>"><?php _e('Ad 1 Image URL: 320x155', 'khositeweb') ?></label>
		    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'ad1' ); ?>" name="<?php echo $this->get_field_name( 'ad1' ); ?>" value="<?php echo $instance['ad1']; ?>" />
		</p>

		<p>
		    <label for="<?php echo $this->get_field_id( 'adlink1' ); ?>"><?php _e('Ad 1 Link:', 'khositeweb') ?></label>
		    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'adlink1' ); ?>" name="<?php echo $this->get_field_name( 'adlink1' ); ?>" value="<?php echo $instance['adlink1']; ?>" />
		</p>

		<p>
		    <label for="<?php echo $this->get_field_id( 'ad2' ); ?>"><?php _e('Ad 2 Image URL: 320x155', 'khositeweb') ?></label>
		    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'ad2' ); ?>" name="<?php echo $this->get_field_name( 'ad2' ); ?>" value="<?php echo $instance['ad2']; ?>" />
		</p>

		<p>
		    <label for="<?php echo $this->get_field_id( 'adlink2' ); ?>"><?php _e('Ad 2 Link:', 'khositeweb') ?></label>
		    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'adlink2' ); ?>" name="<?php echo $this->get_field_name( 'adlink2' ); ?>" value="<?php echo $instance['adlink2']; ?>" />
		</p>

		<p>
		    <label for="<?php echo $this->get_field_id( 'ad3' ); ?>"><?php _e('Ad 3 Image URL: 155x155', 'khositeweb') ?></label>
		    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'ad3' ); ?>" name="<?php echo $this->get_field_name( 'ad3' ); ?>" value="<?php echo $instance['ad3']; ?>" />
		</p>

		<p>
		    <label for="<?php echo $this->get_field_id( 'adlink3' ); ?>"><?php _e('Ad 3 Link:', 'khositeweb') ?></label>
		    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'adlink3' ); ?>" name="<?php echo $this->get_field_name( 'adlink3' ); ?>" value="<?php echo $instance['adlink3']; ?>" />
		</p>

		<p>
		    <label for="<?php echo $this->get_field_id( 'ad4' ); ?>"><?php _e('Ad 4 Image URL: 155x155', 'khositeweb') ?></label>
		    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'ad4' ); ?>" name="<?php echo $this->get_field_name( 'ad4' ); ?>" value="<?php echo $instance['ad4']; ?>" />
		</p>

		<p>
		    <label for="<?php echo $this->get_field_id( 'adlink4' ); ?>"><?php _e('Ad 4 Link:', 'khositeweb') ?></label>
		    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'adlink4' ); ?>" name="<?php echo $this->get_field_name( 'adlink4' ); ?>" value="<?php echo $instance['adlink4']; ?>" />
		</p>

		<p>
		    <label for="<?php echo $this->get_field_id( 'ad5' ); ?>"><?php _e('Ad 5 Image URL: 155x155', 'khositeweb') ?></label>
		    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'ad5' ); ?>" name="<?php echo $this->get_field_name( 'ad5' ); ?>" value="<?php echo $instance['ad5']; ?>" />
		</p>

		<p>
		    <label for="<?php echo $this->get_field_id( 'adlink5' ); ?>"><?php _e('Ad 5 Link:', 'khositeweb') ?></label>
		    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'adlink5' ); ?>" name="<?php echo $this->get_field_name( 'adlink5' ); ?>" value="<?php echo $instance['adlink5']; ?>" />
		</p>

		<p>
		    <label for="<?php echo $this->get_field_id( 'ad6' ); ?>"><?php _e('Ad 6 Image URL: 155x155', 'khositeweb') ?></label>
		    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'ad6' ); ?>" name="<?php echo $this->get_field_name( 'ad6' ); ?>" value="<?php echo $instance['ad6']; ?>" />
		</p>

		<p>
		    <label for="<?php echo $this->get_field_id( 'adlink6' ); ?>"><?php _e('Ad 6 Link:', 'khositeweb') ?></label>
		    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'adlink6' ); ?>" name="<?php echo $this->get_field_name( 'adlink6' ); ?>" value="<?php echo $instance['adlink6']; ?>" />
		</p>
	<?php
	}
}
// register Ads widget
add_action('widgets_init', create_function('', 'return register_widget("uw_ads");'));