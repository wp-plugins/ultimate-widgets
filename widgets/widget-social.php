<?php
/**
 * Social Widget
*/
class uw_social_widget extends WP_Widget {
	
	function uw_social_widget() {
		
		// define widget title and description
		$widget_ops = array(
			'classname'		=> 'social_widget',
			'description'	=> __( 'Displays icons with links to your social profiles.', 'khositeweb' )
		);
		// register the widget
		$this->WP_Widget('uw_social_widget', __( 'Widget - Social Widget', 'khositeweb' ), $widget_ops);
	
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$style = $instance['style'];
		$transition = $instance['transition'];
		$target = $instance['target'];
		$size = intval($instance['size']);
		$font_size = intval($instance['font_size']);
		$border_radius = intval($instance['border_radius']);
		$social_services = $instance['social_services']; ?>
		<?php echo $before_widget; ?>
			<?php if ( $title )
				echo $before_title . $title . $after_title;
					// ADD Style
					$add_style = array();
					if ( '' != $size ) {
						$add_style[] = 'height: '. $size .'px;width: '. $size .'px;line-height: '. $size .'px;';
					}
					if ( '' != $font_size ) {
						$add_style[] = 'font-size: '. $font_size .'px;';
					}
					if ( '' != $border_radius ) {
						$add_style[] = 'border-radius: '. $border_radius .'px;';
					}
					$add_style = implode('', $add_style);
					if ( $add_style ) {
						$add_style = wp_kses( $add_style, array() );
					} ?>
					<ul class="uw-ul ks-social-widget social-style-<?php echo esc_attr( $style ); ?> <?php echo esc_attr( $transition ); ?>">
						<?php
						// Loop through each social service and display font icon
						foreach( $social_services as $key => $service ) {
							$link = !empty( $service['url'] ) ? $service['url'] : null;
							$name = $service['name'];
							if ( $link ) {
								if ( 'youtube' == $key ) {
									$key = 'youtube-play';
								}
								echo '<li class="social-widget-'. esc_attr( $key ) .'"><a href="'. esc_url( $link ) .'" title="'. esc_attr( $name ) .'" target="_'.esc_attr( $target ).'" style="'. esc_attr( $add_style ) .'"><i class="fa fa-'. esc_attr( $key ) .'"></i></a></li>';
							}
						} ?>
					</ul>
		<?php echo $after_widget; ?>
		<?php
	}

	/** @see WP_Widget::update */
	function update( $new, $old ) {
		$instance = $old;
		$instance['title'] = !empty( $new['title'] ) ? strip_tags( $new['title'] ) : null;
		$instance['style'] = !empty( $new['style'] ) ? strip_tags( $new['style'] ) : 'color';
		$instance['transition'] = !empty( $new['transition'] ) ? strip_tags( $new['transition'] ) : 'rotate';
		$instance['target'] = !empty( $new['target'] ) ? strip_tags( $new['target'] ) : 'blank';
		$instance['size'] = !empty( $new['size'] ) ? strip_tags( $new['size'] ) : '34px';
		$instance['border_radius'] = !empty( $new['border_radius'] ) ? strip_tags( $new['border_radius'] ) : '2px';
		$instance['font_size'] = !empty( $new['font_size'] ) ? strip_tags( $new['font_size'] ) : '16px';
		$instance['social_services'] = $new['social_services'];
		return $instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {
		$defaults =  array(
			'title'				=> __('Follow Us','khositeweb'),
			'style'				=> 'color',
			'transition'		=> 'rotate',
			'font_size'			=> '16px',
			'border_radius'		=> '2px',
			'target' 			=> 'blank',
			'size'				=> '34px',
			'social_services'	=> array(
				'behance' 		=> array(
					'name'		=> 'Behance',
					'url'		=> ''
				),
				'codepen'		=> array(
					'name'		=> 'CodePen',
					'url'		=> ''
				),
				'deviantart'	=> array(
					'name'		=> 'deviantART',
					'url'		=> ''
				),	
				'dribbble'		=> array(
					'name'		=> 'Dribbble',
					'url'		=> ''
				),
				'facebook'		=> array(
					'name'		=> 'Facebook',
					'url'		=> ''
				),
				'flickr'			=> array(
					'name'		=> 'Flickr',
					'url'		=> ''
				),
				'github'		=> array(
					'name'		=> 'GitHub',
					'url'		=> ''
				),
				'google-plus'	=> array(
					'name'		=> 'GooglePlus',
					'url'		=> ''
				),
				'instagram'		=> array(
					'name'		=> 'Instagram',
					'url'		=> ''
				),
				'linkedin' 		=> array(
					'name'		=> 'LinkedIn',
					'url'		=> ''
				),
				'pinterest' 	=> array(
					'name'		=> 'Pinterest',
					'url'		=> ''
				),
				'tumblr' 		=> array(
					'name'		=> 'Tumblr',
					'url'		=> ''
				),
				'twitter' 		=> array(
					'name'		=> 'Twitter',
					'url'		=> ''
				),
				'skype' 		=> array(
					'name'		=> 'Skype',
					'url'		=> ''
				),
				'stack-overflow'=> array(
					'name'		=> 'Stack Overflow',
					'url'		=> ''
				),
				'soundcloud'	=> array(
					'name'		=> 'SoundCloud',
					'url'		=> ''
				),
				'youtube' 		=> array(
					'name'		=> 'Youtube',
					'url'		=> ''
				),
				'reddit' 		=> array(
					'name'		=> 'Reddit',
					'url'		=> ''
				),
				'rss' 			=> array(
					'name'		=> 'RSS',
					'url'		=> ''
				),
				'vimeo-square'	=> array(
					'name'		=> 'Vimeo',
					'url'		=> ''
				),
				'vine'			=> array(
					'name'		=> 'Vine',
					'url'		=> ''
				),	
			),
		);
		
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','khositeweb'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Style', 'khositeweb'); ?></label>
			<br />
			<select class='ks-widget-select ks-style-select' name="<?php echo $this->get_field_name('style'); ?>" id="<?php echo $this->get_field_id('style'); ?>">
				<option value="black" <?php if($instance['style'] == 'black') { ?>selected="selected"<?php } ?>><?php _e( 'Black', 'khositeweb' ); ?></option>
				<option value="black-color-hover" <?php if($instance['style'] == 'black-color-hover') { ?>selected="selected"<?php } ?>><?php _e( 'Black With Color Hover', 'khositeweb' ); ?></option>
				<option value="light" <?php if($instance['style'] == 'light') { ?>selected="selected"<?php } ?>><?php _e( 'Light', 'khositeweb' ); ?></option>
				<option value="light-color-hover" <?php if($instance['style'] == 'light-color-hover') { ?>selected="selected"<?php } ?>><?php _e( 'Light With Color Hover', 'khositeweb' ); ?></option>
				<option value="color" <?php if($instance['style'] == 'color') { ?>selected="selected"<?php } ?>><?php _e( 'Color', 'khositeweb' ); ?></option>
				<option value="just-icons" <?php if($instance['style'] == 'just-icons') { ?>selected="selected"<?php } ?>><?php _e( 'Just Icons', 'khositeweb' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('transition'); ?>"><?php _e('Transition', 'khositeweb'); ?></label>
			<br />
			<select class='ks-widget-select' name="<?php echo $this->get_field_name('transition'); ?>" id="<?php echo $this->get_field_id('transition'); ?>">
				<option value="float" <?php if($instance['transition'] == 'float') { ?>selected="selected"<?php } ?>><?php _e( 'Float', 'khositeweb' ); ?></option>
				<option value="rotate" <?php if($instance['transition'] == 'rotate') { ?>selected="selected"<?php } ?>><?php _e( 'Rotate', 'khositeweb' ); ?></option>
				<option value="zoomout" <?php if($instance['transition'] == 'zoomout') { ?>selected="selected"<?php } ?>><?php _e( 'Zoom Out', 'khositeweb' ); ?></option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('target'); ?>"><?php _e( 'Link Target:', 'khositeweb' ); ?></label>
			<br />
			<select class='ks-widget-select' name="<?php echo $this->get_field_name('target'); ?>" id="<?php echo $this->get_field_id('target'); ?>">
				<option value="blank" <?php if($instance['target'] == 'blank') { ?>selected="selected"<?php } ?>><?php _e( 'Blank', 'khositeweb' ); ?></option>
				<option value="self" <?php if($instance['target'] == 'self') { ?>selected="selected"<?php } ?>><?php _e( 'Self', 'khositeweb'); ?></option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('size'); ?>"><?php _e( 'Icon Size', 'khositeweb' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>" type="text" value="<?php echo $instance['size']; ?>" />
			<small><?php _e('Enter a size to be used for the height/width for the icon.', 'khositeweb'); ?></small>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('font_size'); ?>"><?php _e( 'Icon Font Size', 'khositeweb' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('font_size'); ?>" name="<?php echo $this->get_field_name('font_size'); ?>" type="text" value="<?php echo $instance['font_size']; ?>" />
			<small><?php _e('Enter a custom font size for the icons.', 'khositeweb'); ?></small>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('border_radius'); ?>"><?php _e( 'Border Radius', 'khositeweb' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('border_radius'); ?>" name="<?php echo $this->get_field_name('border_radius'); ?>" type="text" value="<?php echo $instance['border_radius']; ?>" />
			<small><?php _e('Enter a custom border radius. For circular icons enter a number equal or greater to the Icon Size field above.', 'khositeweb'); ?></small>
		</p>

		<h3 style="margin-top:20px;margin-bottom:0;"><?php _e( 'Social Links','khositeweb' ); ?></h3>  
		<small style="display:block;margin-bottom:10px;"><?php _e('Enter the full URL to your social profile','khositeweb'); ?></small>
		<ul id="<?php echo $this->get_field_id( 'social_services' ); ?>" class="ks-services-list">
			<input type="hidden" id="<?php echo $this->get_field_name( 'social_services' ); ?>" value="<?php echo $this->get_field_name( 'social_services' ); ?>">
			<input type="hidden" id="<?php echo wp_create_nonce('uw_social_widget_nonce'); ?>">
			<?php
			$social_services = $instance['social_services'];
			foreach( $social_services as $key => $service ) {
				$url=0;
				if(isset($service['url'])) $url = $service['url'];
				if(isset($service['name'])) $name = $service['name']; ?>
				<li id="<?php echo $this->get_field_id( $service ); ?>_0<?php echo $key ?>">
					<p>
						<label for="<?php echo $this->get_field_id( 'social_services' ); ?>-<?php echo $key ?>-name"><?php echo $name; ?>:</label>
						<input type="hidden" id="<?php echo $this->get_field_id( 'social_services' ); ?>-<?php echo $key ?>-url" name="<?php echo $this->get_field_name( 'social_services' ).'['.$key.'][name]'; ?>" value="<?php echo $name; ?>">
						<input type="url" class="widefat" id="<?php echo $this->get_field_id( 'social_services' ); ?>-<?php echo $key ?>-url" name="<?php echo $this->get_field_name( 'social_services' ).'['.$key.'][url]'; ?>" value="<?php echo $url; ?>" />
					</p>
				</li>
			<?php } ?>
		</ul>
		
	<?php
	}

}
// end class Social Widget
add_action('widgets_init', create_function('', 'return register_widget("uw_social_widget");'));




/* Widget Ajax Function
/*-----------------------------------------------------------------------------------*/
add_action('admin_init','load_uw_social_widget_scripts');
function load_uw_social_widget_scripts() {
	global $pagenow;
	if ( is_admin() && $pagenow == "widgets.php" ) {

		add_action('admin_head', 'add_new_uw_custom_social_style');
		add_action('admin_footer', 'add_new_uw_custom_social_ajax_trigger');
	
		function add_new_uw_custom_social_ajax_trigger() { ?>
		<script type="text/javascript" >
			jQuery(document).ready(function($) {
				jQuery(document).ajaxSuccess(function(e, xhr, settings) {
					var widget_id_base = 'uw_social_widget';
					if(settings.data.search('action=save-widget') != -1 && settings.data.search('id_base=' + widget_id_base) != -1) {
						ksSortServices();
					}
				});
				function ksSortServices() {
					jQuery('.ks-services-list').each( function() {
						var id = jQuery(this).attr('id');
						$('#'+ id).sortable({
							placeholder: "placeholder",
							opacity: 0.6
						});
					});
				}
				ksSortServices();
			});
		</script>
	<?php
	}
}
	
	function add_new_uw_custom_social_style() { ?>
		<style>.ks-services-list li {cursor:move;background:#fcfcfc;padding:10px;border:1px solid #e3e3e3;margin-bottom:10px;}.ks-sw-container label{color: #666;font-weight:bold;}.ks-sw-container input{margin-top:5px;}
		.ks-services-list .placeholder {border:1px dashed #e3e3e3; }</style>
	<?php
	}
	
} //end check pagenow