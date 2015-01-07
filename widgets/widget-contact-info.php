<?php
/**
 * Contact Info Widget
*/
class uw_contact_info extends WP_Widget {
	
	function uw_contact_info() {
		
		// define widget title and description
		$widget_ops = array(
			'classname'		=> 'contact_info_widget',
			'description'	=> __( 'Adds support for Contact Info.', 'khositeweb' )
		);
		// register the widget
		$this->WP_Widget('uw_contact_info', __( 'Widget - Contact Info', 'khositeweb' ), $widget_ops);
	
	}

	function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);

		echo $before_widget;

		if($title) {
			echo $before_title.$title.$after_title;
		}
		?>
		<div class="contact-info-container">
		<?php if(isset($instance['text']) && $instance['text']): ?>
		<p class="text"><?php echo esc_attr( $instance['text'] ); ?></p>
		<?php endif; ?>

		<?php if(isset($instance['address']) && $instance['address']): ?>
		<p class="address"><i class="fa fa-home"></i><?php echo esc_attr( $instance['address'] ); ?></p>
		<?php endif; ?>

		<?php if(isset($instance['phone']) && $instance['phone']): ?>
		<p class="phone"><i class="fa fa-phone"></i><?php echo esc_attr( $instance['phone'] ); ?></p>
		<?php endif; ?>

		<?php if(isset($instance['mobile']) && $instance['mobile']): ?>
		<p class="mobile"><i class="fa fa-mobile"></i><?php echo esc_attr( $instance['mobile'] ); ?></p>
		<?php endif; ?>

		<?php if(isset($instance['fax']) && $instance['fax']): ?>
		<p class="fax"><i class="fa fa-print"></i><?php echo esc_attr( $instance['fax'] ); ?></p>
		<?php endif; ?>

		<?php if(isset($instance['email']) && $instance['email']): ?>
		<p class="email"><i class="fa fa-envelope"></i><a href="mailto:<?php echo esc_attr( $instance['email'] ); ?>"><?php if($instance['emailtxt']) { echo esc_attr( $instance['emailtxt'] ); } else { echo esc_attr( $instance['email'] ); } ?></a></p>
		<?php endif; ?>

		<?php if(isset($instance['web']) && $instance['web']): ?>
		<p class="web"><i class="fa fa-globe"></i><a href="<?php echo esc_url( $instance['web'] ); ?>"><?php if(isset($instance['webtxt']) && $instance['webtxt']) { echo esc_attr( $instance['webtxt'] ); } else { echo esc_attr( $instance['web'] ); } ?></a></p>
		<?php endif; ?>

		<?php if(isset($instance['skype']) && $instance['skype']): ?>
		<p class="fax"><i class="fa fa-skype"></i><?php echo esc_attr( $instance['skype'] ); ?></p>
		<?php endif; ?>
		</div>
		<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];
		$instance['text'] = $new_instance['text'];
		$instance['address'] = $new_instance['address'];
		$instance['phone'] = $new_instance['phone'];
		$instance['mobile'] = $new_instance['mobile'];
		$instance['fax'] = $new_instance['fax'];
		$instance['email'] = $new_instance['email'];
		$instance['emailtxt'] = $new_instance['emailtxt'];
		$instance['web'] = $new_instance['web'];
		$instance['webtxt'] = $new_instance['webtxt'];
		$instance['skype'] = $new_instance['skype'];

		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Contact Info', 'text' => '', 'address' => '', 'phone' => '', 'mobile' => '', 'fax' => '', 'email' => '', 'emailtxt' => '', 'web' => '', 'webtxt' => '', 'skype' => '');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'khositeweb'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:', 'khositeweb'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" value="<?php echo $instance['text']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('address'); ?>"><?php _e('Address:', 'khositeweb'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" value="<?php echo $instance['address']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('phone'); ?>"><?php _e('Phone:', 'khositeweb'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" value="<?php echo $instance['phone']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('mobile'); ?>"><?php _e('Mobile:', 'khositeweb'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('mobile'); ?>" name="<?php echo $this->get_field_name('mobile'); ?>" value="<?php echo $instance['mobile']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('fax'); ?>"><?php _e('Fax:', 'khositeweb'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('fax'); ?>" name="<?php echo $this->get_field_name('fax'); ?>" value="<?php echo $instance['fax']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Email:', 'khositeweb'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" value="<?php echo $instance['email']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('emailtxt'); ?>"><?php _e('Email Link Text:', 'khositeweb'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('emailtxt'); ?>" name="<?php echo $this->get_field_name('emailtxt'); ?>" value="<?php echo $instance['emailtxt']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('web'); ?>"><?php _e('Website URL (with HTTP):', 'khositeweb'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('web'); ?>" name="<?php echo $this->get_field_name('web'); ?>" value="<?php echo $instance['web']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('webtxt'); ?>"><?php _e('Website URL Text:', 'khositeweb'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('webtxt'); ?>" name="<?php echo $this->get_field_name('webtxt'); ?>" value="<?php echo $instance['webtxt']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('skype'); ?>"><?php _e('Skype:', 'khositeweb'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('skype'); ?>" name="<?php echo $this->get_field_name('skype'); ?>" value="<?php echo $instance['skype']; ?>" />
		</p>
	<?php
	}
}
// register Contact Info widget
add_action('widgets_init', create_function('', 'return register_widget("uw_contact_info");'));