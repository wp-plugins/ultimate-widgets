<?php
/**
 * Recent Post Widget
*/
class uw_recent_posts_thumb extends WP_Widget {
	
	function uw_recent_posts_thumb() {
		
		// define widget title and description
		$widget_ops = array(
			'classname'		=> 'thumb_widget',
			'description'	=> __( 'Shows a listing of your recent or random posts.', 'khositeweb' )
		);
		// register the widget
		$this->WP_Widget('uw_recent_posts_thumb', __( 'Widget - Posts Thumbnails', 'khositeweb' ), $widget_ops);
	
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		extract( $args );
		$title = $instance['title'];
		$number = $instance['number'];
		$style = $instance['style'];
		$order = $instance['order'];
		$img_height = ( !empty( $instance['img_height'] ) ) ? intval( $instance['img_height'] ) : '65';
		$img_width = ( !empty( $instance['img_width'] ) ) ? intval( $instance['img_width'] ) : '65';
		$image = isset( $instance['image'] ) ? $instance['image'] : '';
		$infowrap = isset( $instance['infowrap'] ) ? $instance['infowrap'] : '';
		$post_type = $instance['post_type'];
			  echo $before_widget;
				  if ( $title )
						echo $before_title . $title . $after_title;
						if($style == 'fullimg'||$style == 'fullinfoinside') {
							$class = ' full';
						} ?>
							<ul class="uw-ul ks-widget-recent-posts clr style-<?php echo esc_attr( $style ); ?><?php echo esc_attr( $class ); ?>">
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
										<?php if ( $infowrap !== '1' && $style == 'fullinfoinside' ) { ?>
											<div class="ks-widget-info-wrap">
												<div class="ks-widget-recent-posts-date"><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></div>
												<div class="ks-widget-recent-posts-comments"><i class="fa fa-comment-o"></i><?php comments_popup_link( __( '0', 'khositeweb' ), __( '1',  'khositeweb' ), __( '%', 'khositeweb' ), 'comments-link' ); ?></div>
											</div>
										<?php } ?>
										<?php if ( $image !== '1' ) { ?>
											<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="ks-widget-recent-posts-thumbnail">
												<img src="<?php echo esc_url( $featured_image ); ?>" alt="<?php the_title(); ?>" />
											</a>
										<?php } ?>
										<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="ks-widget-recent-posts-title"><?php the_title(); ?></a>
										<?php if ( $infowrap !== '1' && $style !== 'fullinfoinside' ) { ?>
											<div class="ks-widget-info-wrap">
												<div class="ks-widget-recent-posts-date"><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></div>
												<div class="ks-widget-recent-posts-comments"><i class="fa fa-comment-o"></i><?php comments_popup_link( __( '0', 'khositeweb' ), __( '1',  'khositeweb' ), __( '%', 'khositeweb' ), 'comments-link' ); ?></div>
											</div>
										<?php } ?>
									</li>
							<?php
							} endforeach; wp_reset_postdata(); ?>
							</ul>
			<?php echo $after_widget;
	}

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['number'] = strip_tags($new_instance['number']);
	$instance['style'] = strip_tags($new_instance['style']);
	$instance['order'] = strip_tags($new_instance['order']);
	$instance['img_height'] = strip_tags($new_instance['img_height']);
	$instance['img_width'] = strip_tags($new_instance['img_width']);
	$instance['image'] = strip_tags($new_instance['image']);
	$instance['infowrap'] = strip_tags($new_instance['infowrap']);
	$instance['post_type'] = strip_tags($new_instance['post_type']);
		return $instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'			=> __('Recent Posts','khositeweb' ),
			'style'			=> 'default',
			'post_type'		=> 'post',
			'number'		=> '3',
			'order'			=> 'ASC',
			'image'			=> '',
			'infowrap'		=> '',
			'img_height'	=> '65',
			'img_width'		=> '65',
		) );
		$title = esc_attr($instance['title']);
		$number = esc_attr($instance['number']);
		$style = esc_attr($instance['style']);
		$order = esc_attr( $instance['order'] );
		$image = esc_attr( $instance['image'] );
		$infowrap = esc_attr( $instance['infowrap'] );
		$img_height = esc_attr( $instance['img_height'] );
		$img_width = esc_attr( $instance['img_width'] );
		$post_type = esc_attr( $instance['post_type'] ); ?>
		
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'khositeweb' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title','khositeweb' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('style'); ?>"><?php _e( 'Style', 'khositeweb' ); ?></label>
			<br />
			<select class='ks-select' name="<?php echo $this->get_field_name('style'); ?>" id="<?php echo $this->get_field_id('style'); ?>">
				<option value="default" <?php if($style == 'default') { ?>selected="selected"<?php } ?>><?php _e( 'Small Image', 'khositeweb' ); ?></option>
				<option value="fullimg" <?php if($style == 'fullimg') { ?>selected="selected"<?php } ?>><?php _e( 'Full Image', 'khositeweb' ); ?></option>
				<option value="fullinfoinside" <?php if($style == 'fullinfoinside') { ?>selected="selected"<?php } ?>><?php _e( 'Full & Info Inside', 'khositeweb' ); ?></option>
			</select>
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
			<input id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" type="checkbox" value="1" <?php checked( '1', $image ); ?> />
			<label for="<?php echo $this->get_field_id('image'); ?>"><?php _e( 'Disable Featured Image?', 'khositeweb' ); ?></label>
		</p>

		<p>
			<input id="<?php echo $this->get_field_id('infowrap'); ?>" name="<?php echo $this->get_field_name('infowrap'); ?>" type="checkbox" value="1" <?php checked( '1', $infowrap ); ?> />
			<label for="<?php echo $this->get_field_id('infowrap'); ?>"><?php _e( 'Disable Date & Comments ?', 'khositeweb' ); ?></label>
		</p>
		
		<?php
	}


} // class uw_recent_posts_thumb
// register Recent Posts widget
add_action('widgets_init', create_function('', 'return register_widget("uw_recent_posts_thumb");')); ?>