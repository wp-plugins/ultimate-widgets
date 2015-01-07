<?php
/**
 * MailChimp Widget
*/
class uw_mailchimp extends WP_Widget {
	
	function uw_mailchimp() {
		
		// define widget title and description
		$widget_ops = array(
			'classname'		=> 'mailchimp_widget',
			'description'	=> __( 'Displays Mailchimp Subscription Form.', 'khositeweb' )
		);
		// register the widget
		$this->WP_Widget('uw_mailchimp', __( 'Widget - MailChimp', 'khositeweb' ), $widget_ops);
	
	}
	
	// display the widget in the theme
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		if ( empty($title) ) $title = false;
		$mailchimpaction = $instance['mailchimpaction'];	
		$mailchimpbtn = $instance['mailchimpbtn'];	
		$placeholder = $instance['placeholder'];	
		$subscribe_text = $instance['subscribe_text'];	

		echo $before_widget;
			 if ( $title )
				 echo $before_title . $title . $after_title; ?>
				<p class="mail-text"><?php echo esc_attr( $subscribe_text ); ?></p>
				<form action="<?php echo esc_url( $mailchimpaction ); ?>" method="post" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					<div class="mail-table">
						<div class="mail-field">
							<input type="email" value="" name="EMAIL" class="required email" placeholder="<?php echo esc_attr( $placeholder ) ?>">
						</div>
						<div class="mail-button">
							<input type="submit" value="<?php echo esc_attr( $mailchimpbtn ); ?>" name="subscribe">
						</div>
					</div>
				</form>
			<?php
			
		echo $after_widget;
	}
	
	// update the widget when new options have been entered
	function update( $new_instance, $old_instance ) {
		$instance=$old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['mailchimpaction'] = $new_instance['mailchimpaction'];
		$instance['mailchimpbtn'] = $new_instance['mailchimpbtn'];
		$instance['placeholder'] = $new_instance['placeholder'];
		$instance['subscribe_text'] = $new_instance['subscribe_text'];
		return $instance;
	}
	
	// print the widget option form on the widget management screen
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array('title' => 'Subscribe to our Newsletter', 'subscribe_text' => 'Get all latest content delivered to your email a few times a month. Updates and news about all categories will send to you.', 'mailchimpaction' => '', 'placeholder' => 'Your Email', 'mailchimpbtn' => 'Sign Up') );
		$title = esc_attr($instance['title']);
		$mailchimpaction = $instance['mailchimpaction'];
		$mailchimpbtn = $instance['mailchimpbtn'];
		$placeholder = $instance['placeholder'];
	

	// print the form fields ?>

	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>">
			<?php _e('Title', 'khositeweb'); ?>
		</label>			
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
		
	<p>
		<label for="<?php echo $this->get_field_id( 'subscribe_text' ); ?>"><?php _e('Text:', 'khositeweb'); ?></label>
		<textarea style="height:200px;" class="widefat" id="<?php echo $this->get_field_id( 'subscribe_text' ); ?>" name="<?php echo $this->get_field_name( 'subscribe_text' ); ?>"><?php echo stripslashes(htmlspecialchars(( $instance['subscribe_text'] ), ENT_QUOTES)); ?></textarea>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('mailchimpaction'); ?>"><?php _e('MailChimp Form Action:', 'khositeweb'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('mailchimpaction'); ?>" name="<?php echo $this->get_field_name('mailchimpaction'); ?>" type="text" value="<?php echo $mailchimpaction; ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('placeholder'); ?>"><?php _e('Placeholder:', 'khositeweb'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('placeholder'); ?>" name="<?php echo $this->get_field_name('placeholder'); ?>" type="text" value="<?php echo $placeholder; ?>" />
	</p>
		
	<p>
		<label for="<?php echo $this->get_field_id('mailchimpbtn'); ?>"><?php _e('Button title:', 'khositeweb'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('mailchimpbtn'); ?>" name="<?php echo $this->get_field_name('mailchimpbtn'); ?>" type="text" value="<?php echo $mailchimpbtn; ?>" />
	</p>

	<?php
	}
}
// register MailChimp widget
add_action('widgets_init', create_function('', 'return register_widget("uw_mailchimp");'));