<?php
/**
 * Video Widget
*/
class uw_video extends WP_Widget {
	
	function uw_video() {
		
		// define widget title and description
		$widget_ops = array(
			'classname'		=> 'video_widget',
			'description'	=> __( 'Add a video in your sidebar.', 'khositeweb' )
		);
		// register the widget
		$this->WP_Widget('uw_video', __( 'Widget - Video', 'khositeweb' ), $widget_ops);
	
	}



	function widget( $args, $instance ) {
		extract( $args );
		$title = $instance['title'];
		$type= $instance['type'];
		$clip_id= $instance['clip_id'];
		$width= $instance['width'];


		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;



		if ( !empty( $clip_id ) ) {

			$height = intval( $width * 9 / 16 );

			// Vimeo Video post type
			if ( $type =='vimeo' ) {
				echo '<div class="ks-video-container"><iframe src="http'.((is_ssl())? 's' : '').'://player.vimeo.com/video/'.esc_attr( $clip_id ).'?title=0&amp;byline=0&amp;portrait=0&amp;color=3fc387" width="'.esc_attr( $width ).'" height="'.esc_attr( $height ).'"></iframe></div>';
			}

			// Youtube Video post type
			if ( $type =='youtube' ) {
				$height = intval( $width * 9 / 16 ) + 25;
				echo '<div class="ks-video-container"><iframe src="http'.((is_ssl())? 's' : '').'://www.youtube.com/embed/'.esc_attr( $clip_id ).'?showinfo=0&amp;theme=dark&amp;color=white&amp;autohide=1" width="'.esc_attr( $width ).'" height="'.esc_attr( $height ).'"></iframe></div>';
			}

			// Dailymotion Video post type
			if ( $type =='dailymotion' ) {

				echo '<div class="ks-video-container"><iframe width="'.esc_attr( $width ).'" height="'.esc_attr( $height ).'" src="http'.((is_ssl())? 's' : '').'://www.dailymotion.com/embed/video/'.esc_attr( $clip_id ).'?foreground=%2300c65d&amp;highlight=%23ffffff&amp;background=%23000000&amp;logo=0"></iframe></div>';
			}

			// bliptv Video post type
			if ( $type =='bliptv' ) {
				echo '<div class="ks-video-container"><iframe src="http'.((is_ssl())? 's' : '').'://blip.tv/play/'.esc_attr( $clip_id ).'.x?p=1" width="'.esc_attr( $width ).'" height="'.esc_attr( $height ).'" allowfullscreen></iframe><embed type="application/x-shockwave-flash" src="http://a.blip.tv/api.swf#'.esc_attr( $clip_id ).'" style="display:none"></embed></div>';
			}


			// Viddler Video post type
			if ( $type =='viddler' ) {
				echo '<div class="ks-video-container"><iframe id="viddler-bdce8c7" src="//www.viddler.com/embed/'.esc_attr( $clip_id ).'/?f=1&amp;offset=0&amp;autoplay=0&amp;secret=18897048&amp;disablebranding=0&amp;view_secret=18897048" width="'.esc_attr( $width ).'" height="'.esc_attr( $height ).'" mozallowfullscreen="true" webkitallowfullscreen="true" scrolling="no" style="overflow:hidden !important;"></iframe></div>';
			}
		}




		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['type'] = strip_tags( $new_instance['type'] );
		$instance['clip_id'] = $new_instance['clip_id'];
		$instance['width'] = (int) $new_instance['width'];

		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$type = isset( $instance['type'] ) ? $instance['type'] : 'youtube';
		$clip_id = isset( $instance['clip_id'] ) ? $instance['clip_id'] : '';
		$width = isset( $instance['width'] ) ? absint( $instance['width'] ) : 320;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'khositeweb'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

     	<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e('Type:', 'khositeweb'); ?></label>
			<select name="<?php echo $this->get_field_name( 'type' ); ?>" id="<?php echo $this->get_field_id( 'type' ); ?>" class="widefat">
            	<option value="youtube"<?php selected( $type, 'youtube' );?>><?php _e('Youtube', 'khositeweb'); ?></option>
				<option value="vimeo"<?php selected( $type, 'vimeo' );?>><?php _e('Vimeo', 'khositeweb'); ?></option>
				<option value="dailymotion"<?php selected( $type, 'dailymotion' );?>><?php _e('Dailymotion', 'khositeweb'); ?></option>
				<option value="bliptv"<?php selected( $type, 'bliptv' );?>><?php _e('bliptv', 'khositeweb'); ?></option>
				<option value="viddler"<?php selected( $type, 'viddler' );?>><?php _e('viddler', 'khositeweb'); ?></option>

			</select>
		</p>

		<p><label for="<?php echo $this->get_field_id( 'clip_id' ); ?>"><?php _e('Clip Id:', 'khositeweb'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'clip_id' ); ?>" name="<?php echo $this->get_field_name( 'clip_id' ); ?>" type="text" value="<?php echo $clip_id; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e('Width', 'khositeweb'); ?></label>
		<input id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo $width; ?>" size="3" /></p>

<?php

	}
}
// register Video widget
add_action('widgets_init', create_function('', 'return register_widget("uw_video");'));