<?php
/**
 * Posts Slider Widget
*/
class uw_posts_slider extends WP_Widget {
	
	function uw_posts_slider() {
		
		// define widget title and description
		$widget_ops = array(
			'classname'		=> 'slider_widget',
			'description'	=> __( 'Displays a posts slider.', 'khositeweb' )
		);
		// register the widget
		$this->WP_Widget('uw_posts_slider', __( 'Widget - Posts Slider', 'khositeweb' ), $widget_ops);
	
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		extract( $args );
		$title = $instance['title'];
		$number = $instance['number'];
		$order = $instance['order'];
		$random = rand( 0, 999999 );
		$img_height = ( !empty( $instance['img_height'] ) ) ? intval( $instance['img_height'] ) : '200';
		$img_width = ( !empty( $instance['img_width'] ) ) ? intval( $instance['img_width'] ) : '320';
		$infowrap = isset( $instance['infowrap'] ) ? $instance['infowrap'] : '';
		$post_type = $instance['post_type'];
			  echo $before_widget;
				  if ( $title )
						echo $before_title . $title . $after_title; ?>
							<div class="posts-slider ks-flexslider" id="posts_slider_<?php echo esc_attr( $random ); ?>">
								<ul class="uw-ul ks-widget-recent-posts clr style-fullinfoinside ks-flex-slides">
								<?php
									global $post;
									$args = array(
										'post_type'			=> $post_type,
										'numberposts'		=> $number,
										'orderby'			=> $order,
										'no_found_rows'		=> true,
										'suppress_filters'	=> false,
										'meta_key'			=> '_thumbnail_id',
									);
									$myposts = get_posts( $args );
									foreach( $myposts as $post ) : setup_postdata($post);
									if( has_post_thumbnail() ) {
										if ( '9999' == $img_height ){
											$img_crop = false;
										} else {
											$img_crop = true;
										}
										$featured_image = uw_image_resize( wp_get_attachment_url( get_post_thumbnail_id() ), $img_width, $img_height, $img_crop ); ?>
										<li class="clearfix ks-widget-recent-posts-li">
											<?php if ( $infowrap !== '1' ) { ?>
												<div class="ks-widget-info-wrap">
													<div class="ks-widget-recent-posts-date"><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></div>
													<div class="ks-widget-recent-posts-comments"><i class="fa fa-comment-o"></i><?php comments_popup_link( __( '0', 'khositeweb' ), __( '1',  'khositeweb' ), __( '%', 'khositeweb' ), 'comments-link' ); ?></div>
												</div>
											<?php } ?>
											<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="ks-widget-recent-posts-thumbnail">
												<img src="<?php echo esc_url( $featured_image ); ?>" alt="<?php the_title(); ?>" />
											</a>
											<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="ks-widget-recent-posts-title"><?php the_title(); ?></a>
											<ul class="ks-posts-slider-nav">
												<li><a href="#" class="ks-posts-prev"><i class="fa fa-angle-left"></i></a></li>
												<li><a href="#" class="ks-posts-next"><i class="fa fa-angle-right"></i></a></li>
											</ul>
										</li>
								<?php
								} endforeach; wp_reset_postdata(); ?>
								</ul>
							</div>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#posts_slider_<?php echo esc_attr( $random ); ?>').flexslider({
			selector: ".ks-flex-slides > li",
			animation: "fade",
			smoothHeight: false,
			slideshowSpeed: 7000,
			animationSpeed: 400,
			pauseOnHover: true,
			directionNav: false,
			controlNav: false,
		});
		jQuery('.ks-posts-prev').on('click', function(){
		    jQuery('#posts_slider_<?php echo esc_attr( $random ); ?>').flexslider('prev')
		    return false;
		});
		jQuery('.ks-posts-next').on('click', function(){
		    jQuery('#posts_slider_<?php echo esc_attr( $random ); ?>').flexslider('next')
		    return false;
		});
	});
</script>

			<?php echo $after_widget;
	}

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['number'] = strip_tags($new_instance['number']);
	$instance['order'] = strip_tags($new_instance['order']);
	$instance['img_height'] = strip_tags($new_instance['img_height']);
	$instance['img_width'] = strip_tags($new_instance['img_width']);
	$instance['infowrap'] = strip_tags($new_instance['infowrap']);
	$instance['post_type'] = strip_tags($new_instance['post_type']);
		return $instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'			=> __('Posts Slider','khositeweb' ),
			'post_type'		=> 'post',
			'number'		=> '5',
			'order'			=> 'ASC',
			'infowrap'		=> '',
			'img_height'	=> '200',
			'img_width'		=> '320',
		) );
		$title = esc_attr($instance['title']);
		$number = esc_attr($instance['number']);
		$order = esc_attr( $instance['order'] );
		$infowrap = esc_attr( $instance['infowrap'] );
		$img_height = esc_attr( $instance['img_height'] );
		$img_width = esc_attr( $instance['img_width'] );
		$post_type = esc_attr( $instance['post_type'] ); ?>
		
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'khositeweb' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title','khositeweb' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e( 'Post Type?', 'khositeweb' ); ?></label> 
			<br />
			<select class='ks-select' name="<?php echo $this->get_field_name('post_type'); ?>" id="<?php echo $this->get_field_id('post_type'); ?>">
				<option value="post" <?php if($post_type == 'post') { ?>selected="selected"<?php } ?>><?php _e( 'Post', 'khositeweb' ); ?></option>
				<?php
				//get post_typeonomies
				$args=array('public' => true,'_builtin' => false, 'exclude_from_search' => false); 
				$output = 'names'; // or objects
				$operator = 'and'; // 'and' or 'or'
				$get_post_types = get_post_types($args,$output,$operator);
				foreach ($get_post_types as $get_post_type ) {
					if( $get_post_type != 'post' && $get_post_type !== 'faq' ){ ?>
					<option value="<?php echo $get_post_type; ?>" id="<?php $get_post_type; ?>" <?php if($post_type == $get_post_type) { ?>selected="selected"<?php } ?>><?php echo ucfirst( $get_post_type ); ?></option>
				<?php } } ?>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e( 'Random or Recent?', 'khositeweb' ); ?></label>
			<br />
			<select class='ks-select' name="<?php echo $this->get_field_name('order'); ?>" id="<?php echo $this->get_field_id('order'); ?>">
				<option value="ASC" <?php if($order == 'ASC') { ?>selected="selected"<?php } ?>><?php _e( 'Recent', 'khositeweb' ); ?></option>
				<option value="rand" <?php if($order == 'rand') { ?>selected="selected"<?php } ?>><?php _e( 'Random', 'khositeweb' ); ?></option>
				<option value="comment_count" <?php if( $order == 'comment_count' ) { ?>selected="selected"<?php } ?>><?php _e( 'Most Comments', 'khositeweb' ); ?></option>
				<option value="modified" <?php if( $order == 'modified' ) { ?>selected="selected"<?php } ?>><?php _e( 'Last Modified', 'khositeweb' ); ?></option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number to Show', 'khositeweb' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('img_width'); ?>"><?php _e( 'Image Crop Width', 'khositeweb' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('img_width'); ?>" name="<?php echo $this->get_field_name('img_width'); ?>" type="text" value="<?php echo $img_width; ?>" />
			<em style="font-size: 11px;"><?php _e( 'Enter 9999 for dafault width', 'khositeweb' ); ?></em>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('img_height'); ?>"><?php _e( 'Image Crop Height', 'khositeweb' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('img_height'); ?>" name="<?php echo $this->get_field_name('img_height'); ?>" type="text" value="<?php echo $img_height; ?>" />
			<em style="font-size: 11px;"><?php _e( 'Enter 9999 for dafault height', 'khositeweb' ); ?></em>
		</p>

		<p>
			<input id="<?php echo $this->get_field_id('infowrap'); ?>" name="<?php echo $this->get_field_name('infowrap'); ?>" type="checkbox" value="1" <?php checked( '1', $infowrap ); ?> />
			<label for="<?php echo $this->get_field_id('infowrap'); ?>"><?php _e( 'Disable Date & Comments ?', 'khositeweb' ); ?></label>
		</p>
		
		<?php
	}


}
// register Posts Slider widget
add_action('widgets_init', create_function('', 'return register_widget("uw_posts_slider");')); ?>