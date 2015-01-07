<?php
/**
 * Soundcloud Widget
*/
class uw_soundcloud extends WP_Widget {
	
	function uw_soundcloud() {
		
		// define widget title and description
		$widget_ops = array(
			'classname'		=> 'soundcloud_widget',
			'description'	=> ''
		);
		// register the widget
		$this->WP_Widget('uw_soundcloud', __( 'Widget - Soundcloud', 'khositeweb' ), $widget_ops);
	
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title'] );
		$url = isset( $instance['url'] ) ? esc_attr( $instance['url'] ) : '';
		$height = isset( $instance['height'] ) ? esc_attr( $instance['height'] ) : '300';
		$autoplay = $instance['autoplay'];
		$play = 'false';
		if( !empty( $autoplay )) $play = 'true';

		echo $before_widget;
		if($title) {
			echo $before_title.$title.$after_title;
		} ?>
		<iframe width="100%" height="<?php echo esc_attr( $height ); ?>" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=<?php echo esc_url( $url ); ?>&amp;auto_play=<?php echo esc_attr( $play ); ?>&amp;show_artwork=true&amp;show_user=true&amp;visual=true"></iframe>
	<?php
		echo $after_widget;
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['url'] = $new_instance['url'];
		$instance['height'] = $new_instance['height'] ;
		$instance['autoplay'] = strip_tags( $new_instance['autoplay'] );
		return $instance;
	}
	function form( $instance ) {
		$defaults = array( 
			'title' => 'SoundCloud', 
			'url' => '',
			'height' => '300',
			'play' => '',
			'autoplay' => ''  
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title :', 'khositeweb'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e('URL :', 'khositeweb'); ?></label>
			<input id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" value="<?php echo $instance['url']; ?>" type="text" class="widefat" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e('Height :', 'khositeweb'); ?></label>
			<input id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo $instance['height']; ?>" type="text" class="widefat" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'autoplay' ); ?>"><?php _e('Autoplay :', 'khositeweb'); ?></label>
			<input id="<?php echo $this->get_field_id( 'autoplay' ); ?>" name="<?php echo $this->get_field_name( 'autoplay' ); ?>" value="true" <?php if( $instance['autoplay'] ) echo 'checked="checked"'; ?> type="checkbox" />
		</p>
	<?php
	}

}
// register Soundcloud widget
add_action('widgets_init', create_function('', 'return register_widget("uw_soundcloud");')); ?>