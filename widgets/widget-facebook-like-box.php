<?php
/**
 * Facebook Like Box Widget
*/
class uw_facebook extends WP_Widget {
	
	function uw_facebook() {
		
		// define widget title and description
		$widget_ops = array(
			'classname'		=> 'facebook_widget',
			'description'	=> __( 'Adds support for Facebook Like Box.', 'khositeweb' )
		);
		// register the widget
		$this->WP_Widget('uw_facebook', __( 'Widget - Facebook Like Box', 'khositeweb' ), $widget_ops);
	
	}
	
	// display the widget in the theme
	function widget($args, $instance) {
		extract($args);

		$title = apply_filters('widget_title', $instance['title']);
		$page_url = $instance['page_url'];
		$width = $instance['width'];
		$color_scheme = $instance['color_scheme'];
		$show_faces = isset($instance['show_faces']) ? 'true' : 'false';
		$show_stream = isset($instance['show_stream']) ? 'true' : 'false';
		$show_header = isset($instance['show_header']) ? 'true' : 'false';
		$height = '65';

		if($show_faces == 'true') {
			$height = '240';
		}

		if($show_stream == 'true') {
			$height = '515';
		}

		if($show_stream == 'true' && $show_faces == 'true' && $show_header == 'true') {
			$height = '540';
		}

		if($show_stream == 'true' && $show_faces == 'true' && $show_header == 'false') {
			$height = '540';
		}

		if($show_header == 'true') {
			$height = $height + 30;
		}

		echo $before_widget;

		if($title) {
			echo $before_title.$title.$after_title;
		}

		if($page_url): ?>
			<iframe src="http<?php echo (is_ssl())? 's' : ''; ?>://www.facebook.com/plugins/likebox.php?href=<?php echo urlencode(esc_url( $page_url )); ?>&amp;width=<?php echo esc_attr( $width ); ?>&amp;colorscheme=<?php echo esc_attr( $color_scheme ); ?>&amp;show_faces=<?php echo esc_attr( $show_faces ); ?>&amp;stream=<?php echo esc_attr( $show_stream ); ?>&amp;header=<?php echo esc_attr( $show_header ); ?>&amp;height=<?php echo esc_attr( $height ); ?>&amp;force_wall=true<?php if($show_faces == 'true'): ?>&amp;connections=8<?php endif; ?>" style="border:none; overflow:hidden; width:<?php echo esc_attr( $width ); ?>px; height: <?php echo esc_attr( $height ); ?>px;"></iframe>
		<?php endif;

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['page_url'] = $new_instance['page_url'];
		$instance['width'] = $new_instance['width'];
		$instance['color_scheme'] = $new_instance['color_scheme'];
		$instance['show_faces'] = $new_instance['show_faces'];
		$instance['show_stream'] = $new_instance['show_stream'];
		$instance['show_header'] = $new_instance['show_header'];

		return $instance;
	}

	function form($instance) {
		$defaults = array('title' => 'Find us on Facebook', 'page_url' => '', 'width' => '320', 'color_scheme' => 'light', 'show_faces' => 'on', 'show_stream' => false, 'show_header' => false);
		$instance = wp_parse_args((array) $instance, $defaults); ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'khositeweb'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('page_url'); ?>"><?php _e('Facebook Page URL:', 'khositeweb'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('page_url'); ?>" name="<?php echo $this->get_field_name('page_url'); ?>" value="<?php echo $instance['page_url']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width:', 'khositeweb'); ?></label>
			<input class="widefat" type="text" style="width: 30px;" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo $instance['width']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('color_scheme'); ?>">Color Scheme:</label>
			<select id="<?php echo $this->get_field_id('color_scheme'); ?>" name="<?php echo $this->get_field_name('color_scheme'); ?>" class="widefat" style="width:100%;">
				<option <?php if ('light' == $instance['color_scheme']) echo 'selected="selected"'; ?>><?php _e('light', 'khositeweb'); ?></option>
				<option <?php if ('dark' == $instance['color_scheme']) echo 'selected="selected"'; ?>><?php _e('dark', 'khositeweb'); ?></option>
			</select>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_faces'], 'on'); ?> id="<?php echo $this->get_field_id('show_faces'); ?>" name="<?php echo $this->get_field_name('show_faces'); ?>" />
			<label for="<?php echo $this->get_field_id('show_faces'); ?>"><?php _e('Show faces', 'khositeweb'); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_stream'], 'on'); ?> id="<?php echo $this->get_field_id('show_stream'); ?>" name="<?php echo $this->get_field_name('show_stream'); ?>" />
			<label for="<?php echo $this->get_field_id('show_stream'); ?>"><?php _e('Show stream', 'khositeweb'); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_header'], 'on'); ?> id="<?php echo $this->get_field_id('show_header'); ?>" name="<?php echo $this->get_field_name('show_header'); ?>" />
			<label for="<?php echo $this->get_field_id('show_header'); ?>"><?php _e('Show facebook header', 'khositeweb'); ?></label>
		</p>
	<?php
	}
}
// register Facebook widget
add_action('widgets_init', create_function('', 'return register_widget("uw_facebook");'));