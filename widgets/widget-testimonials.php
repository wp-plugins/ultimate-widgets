<?php
/**
 * Testimonial Widget
*/
class uw_testimonial extends WP_Widget {
	
	function uw_testimonial() {
		
		// define widget title and description
		$widget_ops = array(
			'classname'		=> 'testimonials_widget',
			'description'	=> __( 'Displays a testimonial slider.', 'khositeweb' )
		);
		// register the widget
		$this->WP_Widget('uw_testimonials', __( 'Widget - Testimonial', 'khositeweb' ), $widget_ops);
	
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? 'Testimonial' : $instance['title'], $instance, $this->id_base );
		$count = (int)$instance["count"];
		$random = rand( 0, 999999 );
		$output = '<div class="uw-testimonial-slider ks-flexslider" id="uw-testimonial_slider_' . esc_attr( $random ) . '"><ul class="uw-ul ks-flex-slides">';
		if ( $count > 0 ) {

			for ( $i=1; $i<=$count; $i++ ) {
				$image_src = '';
				$quote =  isset( $instance["quote_".$i] ) ? $instance["quote_".$i] : '';
				$author_name =  isset( $instance["author_name_".$i] ) ? $instance["author_name_".$i]:'';
				$company =  isset( $instance["company_".$i] ) ? $instance["company_".$i]:'';
				$url =  isset( $instance["url_".$i] ) ? $instance["url_".$i]:'';
				$src =  isset( $instance["src_".$i] ) ? $instance["src_".$i]:'';
				if(!empty($src)) {
					$image_src = uw_image_resize( $src, array('width' => 80, 'height' => 80));
				}
				
				$output .= '<li>';
				$output .= '<div class="uw-testimonial-entry-content"><span class="uw-testimonial-caret"></span><span>' . esc_attr( $quote ) . '</span></div>';
				if(!empty($image_src)) {
					$output .= '<div class="uw-testimonial-entry-thumb"><img class="uw-testimonial-author-image" width="80" height="80" src="'.esc_url( $image_src ).'" alt="' . esc_attr( $company )  . '" /></div>';
				}
				$output .= '<div class="uw-testimonial-entry-meta"><span class="uw-testimonial-entry-author">'.esc_attr( $author_name ).'</span>';
				$output .= '<a class="uw-testimonial-author" href="' . esc_url( $url ) .'">' . esc_attr( $company )  . '</a></div></li>';

			}
		}

		$output .= "</ul></div>";

		if ( !empty( $output ) ) {
			echo $before_widget;
?>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#uw-testimonial_slider_<?php echo esc_attr( $random ); ?>').flexslider({
			selector: ".ks-flex-slides > li",
			animation: "fade",
			smoothHeight: false,
			slideshowSpeed: 7000,
			animationSpeed: 400,
			pauseOnHover: true,
			controlNav: false,
			prevText: "",
			nextText: ""
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
		for ( $i=1;$i<=$instance['count'];$i++ ) {
			$instance["quote_".$i] = isset( $new_instance['quote_'.$i] ) ? strip_tags( $new_instance['quote_'.$i] ) : ' ';
			$instance["author_name_".$i] =  isset( $new_instance['author_name_'.$i] ) ? strip_tags( $new_instance['author_name_'.$i] ) : '';
			$instance["company_".$i] =  isset( $new_instance['company_'.$i] ) ? strip_tags( $new_instance['company_'.$i] ) : '';
			$instance["url_".$i] = isset( $new_instance['url_'.$i] ) ? strip_tags( $new_instance['url_'.$i] ) : '';
			$instance["src_".$i] = isset( $new_instance['src_'.$i] ) ? strip_tags( $new_instance['src_'.$i] ) : '';
		}
		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$count = isset( $instance['count'] ) ? absint( $instance['count'] ) : 3;
		for ( $i=1;$i<=10;$i++ ) {
			$quote = 'quote_'.$i;
			$$quote = isset( $instance[$quote] ) ? $instance[$quote] : '';
			$src = 'src_'.$i;
			$$src = isset( $instance[$src] ) ? $instance[$src] : '';
			$author_name = 'author_name_'.$i;
			$$author_name = isset( $instance[$author_name] ) ? $instance[$author_name] : '';
			$company = 'company_'.$i;
			$$company = isset( $instance[$company] ) ? $instance[$company] : '';
			$url = 'url_'.$i;
			$$url = isset( $instance[$url] ) ? $instance[$url] : '';
		}
?>

<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'khositeweb'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Number of Testimonials:', 'khositeweb'); ?></label>
	<input id="<?php echo $this->get_field_id( 'count' ); ?>" class="social_icon_custom_count widefat" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo $count; ?>" size="3" />
</p>

<div class="testimonial_custom_wrap">
	<?php for ( $i=1;$i<=10;$i++ ): $quote = 'quote_'.$i; $author_name = 'author_name_'.$i; $company = 'company_'.$i; $url = 'url_'.$i; $src = 'src_'.$i; ?>
	<div class="testimonial_custom_<?php echo $i;?>" <?php if ( $i>$count ):?>style="display:none;"<?php endif;?> style="padding-bottom:30px">
		<p>
			<label for="<?php echo $this->get_field_id( $quote ); ?>"><?php printf( '#%s Quote:', $i );?></label>
			<textarea style="width:98%" rows="6" id="<?php echo $this->get_field_id( $quote ); ?>" name="<?php echo $this->get_field_name( $quote ); ?>" ><?php echo $$quote; ?></textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( $author_name ); ?>"><?php printf( '#%s Author Name:', $i );?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( $author_name ); ?>" name="<?php echo $this->get_field_name( $author_name ); ?>" type="text" value="<?php echo $$author_name; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( $company ); ?>"><?php printf( '#%s Company:', $i );?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( $company ); ?>" name="<?php echo $this->get_field_name( $company ); ?>" type="text" value="<?php echo $$company; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( $src ); ?>"><?php printf( '#%s Author Image URL:', $i );?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( $src ); ?>" name="<?php echo $this->get_field_name( $src ); ?>" type="text" value="<?php echo $$src; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( $url ); ?>"><?php printf( '#%s Author Website URL:', $i );?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( $url ); ?>" name="<?php echo $this->get_field_name( $url ); ?>" type="text" value="<?php echo $$url; ?>" />
		</p>
	</div>
	<?php endfor;?>
</div>
	<?php
	}
}
// register Testimonial widget
add_action('widgets_init', create_function('', 'return register_widget("uw_testimonial");'));