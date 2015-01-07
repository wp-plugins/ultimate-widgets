<?php
/**
 * Slideshow Widget
*/
class uw_slideshow extends WP_Widget {
	
	function uw_slideshow() {
		
		// define widget title and description
		$widget_ops = array(
			'classname'		=> 'slideshow_widget',
			'description'	=> __( 'Displays a mini slideshow.', 'khositeweb' )
		);
		// register the widget
		$this->WP_Widget('uw_slideshow', __( 'Widget - Slideshow', 'khositeweb' ), $widget_ops);

	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? 'Mini Slideshow' : $instance['title'], $instance, $this->id_base );
		$count = (int)$instance["count"];
		$width = (int)$instance["width"];
		$height = (int)$instance["height"];
		$random = rand( 0, 999999 );
		$output = '<div class="ks-widget-mini-slideshow ks-flexslider" id="slideshow_slider_' . esc_attr( $random ) . '"><ul class="uw-ul ks-flex-slides">';
		if ( $count > 0 ) {

			for ( $i=1; $i<=$count; $i++ ) {
				$src =  isset( $instance["src_".$i] ) ? $instance["src_".$i] : '';

				$image_src = uw_image_resize( $src, array('width' => $width, 'height' => $height)); 
				$output .= '<li>';
				$output .= '<img alt="" src="'.esc_url( $image_src ).'" />';
				$output .= '<ul class="uw-ul ks-slideshow-nav">';
				$output .= '<li><a href="#" class="ks-slideshow-prev"><i class="fa fa-chevron-circle-left"></i></a></li>';
				$output .= '<li><a href="#" class="ks-slideshow-next"><i class="fa fa-chevron-circle-right"></i></a></li>';
				$output .= '</ul>';
				$output .= '</li>';

			}
		}

		$output .= "</ul></div>";

		if ( !empty( $output ) ) {
			echo $before_widget;

?>

<script type="text/javascript">
	jQuery(document).ready(function() {	
		jQuery('#slideshow_slider_<?php echo esc_attr( $random ); ?>').flexslider({
			selector: ".ks-flex-slides > li",
			animation: "fade",
			smoothHeight: false,
			slideshowSpeed: 7000,
			animationSpeed: 400,
			pauseOnHover: true,
			controlNav: false,
			directionNav: false,
		});
		jQuery('.ks-slideshow-prev').on('click', function(){
		    jQuery('#slideshow_slider_<?php echo esc_attr( $random ); ?>').flexslider('prev')
		    return false;
		});
		jQuery('.ks-slideshow-next').on('click', function(){
		    jQuery('#slideshow_slider_<?php echo esc_attr( $random ); ?>').flexslider('next')
		    return false;
		});
	});
</script>
            <?php

			if ( $title )
				echo $before_title . $title . $after_title;

			echo $output;
			echo $after_widget;

		}

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['count'] = (int)$new_instance['count'];
		$instance['width'] = (int)$new_instance['width'];
		$instance['height'] = (int)$new_instance['height'];
		for ( $i=1;$i<=$instance['count'];$i++ ) {
			$instance["src_".$i] = isset( $new_instance['src_'.$i] ) ? strip_tags( $new_instance['src_'.$i] ) : ' ';
		}
		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$count = isset( $instance['count'] ) ? absint( $instance['count'] ) : 3;
		$width = isset( $instance['width'] ) ? absint( $instance['width'] ) : 320;
		$height = isset( $instance['height'] ) ? absint( $instance['height'] ) : 260;
		for ( $i=1;$i<=10;$i++ ) {
			$src = 'src_'.$i;
			$$src = isset( $instance[$src] ) ? $instance[$src] : '';
		}
?>
	<p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'khositeweb'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e('Image width', 'khositeweb'); ?></label>
		<input id="<?php echo $this->get_field_id( 'width' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo $width; ?>" size="3" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e('Image height', 'khositeweb'); ?></label>
		<input id="<?php echo $this->get_field_id( 'height' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'height' ); ?>" type="text" value="<?php echo $height; ?>" size="3" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('How many slides?', 'khositeweb'); ?></label>
		<input id="<?php echo $this->get_field_id( 'count' ); ?>" class="social_icon_custom_count widefat" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo $count; ?>" size="3" />
	</p>

	<div class="slideshow_custom_wrap" style="margin-top:50px;">
		<?php for ( $i=1;$i<=10;$i++ ): $src = 'src_'.$i; ?>
		<div class="slideshow_custom_<?php echo $i;?>" <?php if ( $i>$count ):?>style="display:none;"<?php endif;?> style="padding-bottom:10px">
			<p>
				<label for="<?php echo $this->get_field_id( $src ); ?>"><?php printf( '#%s Image URL:', $i );?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( $src ); ?>" name="<?php echo $this->get_field_name( $src ); ?>" type="text" value="<?php echo $$src; ?>" />
			</p>
		</div>
		<?php endfor;?>
	</div>

	<?php
	}
}
// register Slideshow widget
add_action('widgets_init', create_function('', 'return register_widget("uw_slideshow");'));