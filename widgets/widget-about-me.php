<?php
/**
 * About Me Widget
*/
class uw_about_me extends WP_Widget {
	
	function uw_about_me() {
		
		// define widget title and description
		$widget_ops = array(
			'classname'		=> 'about_me_widget',
			'description'	=> __( 'Adds About Me widget.', 'khositeweb' )
		);
		// register the widget
		$this->WP_Widget('uw_about_me', __( 'Widget - About Me', 'khositeweb' ), $widget_ops);
	
	}

	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);

		/* Variables from settings. */
		$background 	= $instance['background'];
		$color 			= $instance['color'];
		$border_color 	= $instance['border_color'];
		$img_header 	= $instance['img_header'];
		$img_avatar 	= $instance['img_avatar'];
		$name 			= $instance['name'];
		$text 			= $instance['text'];
		$social_style 	= $instance['social_style'];
		$target 		= $instance['target'];
		$social_services = $instance['social_services'];

		echo $before_widget;

		if($title) {
			echo $before_title.$title.$after_title;
			// ADD Style
			if ( '' != $background ) {
				$background = 'style=background:'. $background .';';
			}
			if ( '' != $color ) {
				$color = 'style=color:'. $color .';';
			}
			if ( '' != $border_color ) {
				$border_color = 'style=border-color:'. $border_color .';';
			}
		}
		?>
		<div class="about-me" <?php echo esc_attr( $background ); ?>>
			<?php if ( $img_header ) { ?>
				<img src="<?php echo esc_url( $img_header ); ?>" class="about-me-banner" alt="">
			<?php } ?>
			<div class="about-me-header clr">
				<?php if ( $img_avatar ) { ?>
					<img src="<?php echo esc_url( $img_avatar ); ?>" class="about-me-avatar" alt="" <?php echo esc_attr( $border_color ); ?>>
				<?php } ?>
				<?php if ( $name ) { ?>
					<h3 class="about-me-name" <?php echo esc_attr( $color ); ?>><?php echo esc_attr( $name ); ?></h3>
				<?php } ?>
			</div>
			<?php if ( $text ) { ?>
				<div class="about-me-text clr" <?php echo esc_attr( $color ); ?>><?php echo esc_attr( $text ); ?></div>
			<?php } ?>
			<?php if ( $social_services ) { ?>
				<ul class="uw-ul about-me-social style-<?php echo esc_attr( $social_style ); ?>">
					<?php
					// Loop through each social service and display font icon
					foreach( $social_services as $key => $service ) {
						$link = !empty( $service['url'] ) ? $service['url'] : null;
						$social_name = $service['name'];
						if ( $link ) {
							if ( 'youtube' == $key ) {
								$key = 'youtube-play';
							}
							echo '<li class="'. esc_attr( $key ) .'"><a href="'. esc_url( $link ) .'" title="'. esc_attr( $social_name ) .'" target="_'.esc_attr( $target ).'"><i class="fa fa-'. esc_attr( $key ) .'"></i></a></li>';
						}
					} ?>
				</ul>
			<?php } ?>
		</div>
		<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['title'] 			= $new_instance['title'];
		$instance['background'] 	= $new_instance['background'];
		$instance['color'] 			= $new_instance['color'];
		$instance['border_color'] 	= $new_instance['border_color'];
		$instance['img_header'] 	= $new_instance['img_header'];
		$instance['img_avatar'] 	= $new_instance['img_avatar'];
		$instance['name'] 			= $new_instance['name'];
		$instance['text'] 			= $new_instance['text'];
		$instance['social_style'] 	= $new_instance['social_style'];
		$instance['target'] 		= $new_instance['target'];
		$instance['social_services'] = $new_instance['social_services'];

		return $instance;
	}

	function form($instance) {
		$defaults =  array(
			'title'				=> __('About Me','khositeweb'),
			'background'		=> '',
			'color'				=> '',
			'border_color'		=> '',
			'img_header'		=> plugins_url( 'images/about-header.jpg', dirname(__FILE__) ),
			'img_avatar'		=> plugins_url( 'images/about-avatar.jpg', dirname(__FILE__) ),
			'name'				=> '',
			'text'				=> '',
			'social_style' 		=> 'color',
			'target' 			=> 'blank',
			'social_services'	=> array(
				'facebook'		=> array(
					'name'		=> 'Facebook',
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
				'twitter' 		=> array(
					'name'		=> 'Twitter',
					'url'		=> ''
				),
				'youtube' 		=> array(
					'name'		=> 'Youtube',
					'url'		=> ''
				),	
			),
		);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'khositeweb'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('background'); ?>"><?php _e('Background Color:', 'khositeweb'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('background'); ?>" name="<?php echo $this->get_field_name('background'); ?>" value="<?php echo $instance['background']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('color'); ?>"><?php _e('Text Color:', 'khositeweb'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('color'); ?>" name="<?php echo $this->get_field_name('color'); ?>" value="<?php echo $instance['color']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('border_color'); ?>"><?php _e('Avatar Border Color:', 'khositeweb'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('border_color'); ?>" name="<?php echo $this->get_field_name('border_color'); ?>" value="<?php echo $instance['border_color']; ?>" />
		</p>
		<p>
		    <label for="<?php echo $this->get_field_id( 'img_header' ); ?>"><?php _e('Image Header:', 'khositeweb') ?></label>
		    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'img_header' ); ?>" name="<?php echo $this->get_field_name( 'img_header' ); ?>" value="<?php echo $instance['img_header']; ?>" />
		</p>
		<p>
		    <label for="<?php echo $this->get_field_id( 'img_avatar' ); ?>"><?php _e('Avatar:', 'khositeweb') ?></label>
		    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'img_avatar' ); ?>" name="<?php echo $this->get_field_name( 'img_avatar' ); ?>" value="<?php echo $instance['img_avatar']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('name'); ?>"><?php _e('Name:', 'khositeweb'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('name'); ?>" name="<?php echo $this->get_field_name('name'); ?>" value="<?php echo $instance['name']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:', 'khositeweb'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" value="<?php echo $instance['text']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('social_style'); ?>"><?php _e('Social Style:', 'khositeweb'); ?></label>
			<br />
			<select class='ks-widget-select' name="<?php echo $this->get_field_name('social_style'); ?>" id="<?php echo $this->get_field_id('social_style'); ?>">
				<option value="color" <?php if($instance['social_style'] == 'color') { ?>selected="selected"<?php } ?>><?php _e( 'Color', 'khositeweb' ); ?></option>				
				<option value="light" <?php if($instance['social_style'] == 'light') { ?>selected="selected"<?php } ?>><?php _e( 'Light', 'khositeweb' ); ?></option>
				<option value="dark" <?php if($instance['social_style'] == 'dark') { ?>selected="selected"<?php } ?>><?php _e( 'Dark', 'khositeweb' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('target'); ?>"><?php _e( 'Social Link Target:', 'khositeweb' ); ?></label>
			<br />
			<select class='ks-widget-select' name="<?php echo $this->get_field_name('target'); ?>" id="<?php echo $this->get_field_id('target'); ?>">
				<option value="blank" <?php if($instance['target'] == 'blank') { ?>selected="selected"<?php } ?>><?php _e( 'Blank', 'khositeweb' ); ?></option>
				<option value="self" <?php if($instance['target'] == 'self') { ?>selected="selected"<?php } ?>><?php _e( 'Self', 'khositeweb'); ?></option>
			</select>
		</p>
		<h3 style="margin-top:20px;margin-bottom:0;"><?php _e( 'Social Links','khositeweb' ); ?></h3>  
		<small style="display:block;margin-bottom:10px;"><?php _e('Enter the full URL to your social profile','khositeweb'); ?></small>
		<ul id="<?php echo $this->get_field_id( 'social_services' ); ?>" class="ks-services-list">
			<input type="hidden" id="<?php echo $this->get_field_name( 'social_services' ); ?>" value="<?php echo $this->get_field_name( 'social_services' ); ?>">
			<input type="hidden" id="<?php echo wp_create_nonce('uw_about_me_nonce'); ?>">
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
// register Contact Info widget
add_action('widgets_init', create_function('', 'return register_widget("uw_about_me");'));




/* Widget Ajax Function
/*-----------------------------------------------------------------------------------*/
add_action('admin_init','uw_about_social_widget_scripts');
function uw_about_social_widget_scripts() {
	global $pagenow;
	if ( is_admin() && $pagenow == "widgets.php" ) {

		add_action('admin_head', 'add_new_uw_about_social_ajax_trigger');
		add_action('admin_footer', 'add_new_uw_about_social_ajax_trigger');
	
		function add_new_uw_about_social_ajax_trigger() { ?>
		<script type="text/javascript" >
			jQuery(document).ready(function($) {
				jQuery(document).ajaxSuccess(function(e, xhr, settings) {
					var widget_id_base = 'uw_about_me';
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
	
	function add_new_uw_about_social_style() { ?>
		<style>.ks-services-list li {cursor:move;background:#fcfcfc;padding:10px;border:1px solid #e3e3e3;margin-bottom:10px;}.ks-sw-container label{color: #666;font-weight:bold;}.ks-sw-container input{margin-top:5px;}
		.ks-services-list .placeholder {border:1px dashed #e3e3e3; }</style>
	<?php
	}
	
} //end check pagenow