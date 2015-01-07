<?php
/*
Plugin Name: Ultimate Widgets
Plugin URI: http://khositeweb.com/
Description: Ultimate Widgets plugin allows you to add the most popular widgets like Ads, Contact Info, Facebook Like Box, Google Map, Testomonial, Twitter Widget, Social Widget, Soundclound, etc...
Author: Khositeweb
Author URI: http://khositeweb.com/
Text Domain: khositeweb
Domain Path: /languages/
Version: 1.0
*/

/*  Copyright 2007-2014 Khositeweb

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

define( 'UW_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'UW_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

class Ultimate_Widgets {
    public function __construct() {
        // load the plugin translation files
		load_theme_textdomain( 'khositeweb', UW_PLUGIN_PATH .'/languages' );

		// Enque Front-End scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'front_end_scripts' ) );
    }

	// Load CSS/JS required
	public function front_end_scripts() {
		$this->plugin_css();
		$this->plugin_js();
	}

	// CSS
	public function plugin_css() {
		// Style
	    wp_enqueue_style( 'ultimate-style', UW_PLUGIN_URL .'css/style.css', array(), '1.0', 'all' );

	    // RTL style
	    if ( is_rtl() ) {
			wp_enqueue_style( 'ultimate-style-rtl', UW_PLUGIN_URL .'css/styles-rtl.css', array(), '1.0', 'all' );
		}
	}

	// JS
	public function plugin_js() {

		// jQuery main script
		wp_enqueue_script( 'jquery' );

		// Flexslider.js
		wp_enqueue_script('flexslider', UW_PLUGIN_URL .'js/flexslider-min.js', array('jquery'), '2.2.2', true );

	}
}

new Ultimate_Widgets();

// Widget About Me
require_once( UW_PLUGIN_PATH .'/widgets/widget-about-me.php' );

// Widget Ads
require_once( UW_PLUGIN_PATH .'/widgets/widget-ads.php' );

// Widget Contact
require_once( UW_PLUGIN_PATH .'/widgets/widget-contact-info.php' );

// Widget Facebook
require_once( UW_PLUGIN_PATH .'/widgets/widget-facebook-like-box.php' );

// Widget Flickr
require_once( UW_PLUGIN_PATH .'/widgets/widget-flickr.php' );

// Widget Gmap
require_once( UW_PLUGIN_PATH .'/widgets/widget-gmap.php' );

// Widget Mailchimp
require_once( UW_PLUGIN_PATH .'/widgets/widget-mailchimp.php' );

// Widget Posts Slider
require_once( UW_PLUGIN_PATH .'/widgets/widget-posts-slider.php' );

// Widget Posts Thumbnails
require_once( UW_PLUGIN_PATH .'/widgets/widget-posts-thumbnails.php' );

// Widget Slider
require_once( UW_PLUGIN_PATH .'/widgets/widget-slideshow.php' );

// Widget Social
require_once( UW_PLUGIN_PATH .'/widgets/widget-social.php' );

// Widget Soundcloud
require_once( UW_PLUGIN_PATH .'/widgets/widget-soundcloud.php' );

// Widget Testimonials
require_once( UW_PLUGIN_PATH .'/widgets/widget-testimonials.php' );

// Widget Tweets
require_once( UW_PLUGIN_PATH .'/widgets/widget-tweets.php' );

// Widget Video
require_once( UW_PLUGIN_PATH .'/widgets/widget-video.php' );

// Widget Weather
require_once( UW_PLUGIN_PATH .'/widgets/widget-weather.php' );

// Image rezise
function uw_image_resize( $url, $width, $height = null, $crop = null, $return = 'url' ) {

	// Image cropping is disabled
	if ( 'array' == $return ) {
		return array(
			'url'		=> $url,
			'width'		=> '',
			'height'	=> ''
		);
	} else {
		return $url;
	}
	
	//validate inputs
	if(!$url OR !$width ) {
		false;
	}
	
	//set dimensions
	$aq_width = $width;
	$aq_height = $height;
	
	//define upload path & dir
	$upload_info = wp_upload_dir();
	$upload_dir = $upload_info['basedir'];
	$upload_url = $upload_info['baseurl'];
	
	//check if $img_url is local
	if( strpos( $url, $upload_url ) === false ) {
		return false;
	}
	
	//define path of image
	$rel_path = str_replace( $upload_url, '', $url);
	$img_path = $upload_dir . $rel_path;
	
	//check if img path exists, and is an image indeed
	if( !file_exists( $img_path) OR !getimagesize( $img_path ) ) {
		return false;
	}
	
	//get image info
	$info = pathinfo($img_path);
	$ext = $info['extension'];
	list($orig_w,$orig_h) = getimagesize($img_path);
			
	//get image size after cropping
	$dims = image_resize_dimensions($orig_w, $orig_h, $aq_width, $aq_height, $crop);
	$dst_w = $dims[4];
	$dst_h = $dims[5];
	
	//use this to check if cropped image already exists, so we can return that instead
	$suffix = "{$dst_w}x{$dst_h}";
	$dst_rel_path = str_replace( '.'.$ext, '', $rel_path);
	$destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";
	
	if(!$dst_h) {
		//can't resize, so return original url
		$img_url = $url;
		$dst_w = $orig_w;
		$dst_h = $orig_h;
	}
	
	//else check if cache exists
	elseif(file_exists($destfilename) && getimagesize($destfilename)) {
		$img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
	}
	
	//else, we resize the image and return the new resized image url
	else {
		
		$editor = wp_get_image_editor($img_path);
		
		if ( is_wp_error( $editor ) || is_wp_error( $editor->resize( $aq_width, $aq_height, $crop ) ) )
			return false;
		
		$editor->set_quality( 100 );
		$resized_file = $editor->save();

		if(!is_wp_error($resized_file)) {
			$resized_rel_path = str_replace( $upload_dir, '', $resized_file['path']);
			$img_url = $upload_url . $resized_rel_path;
		} else {
			return false;
		}
		
	}
	
	// retina Support
	$retina_w = $dst_w*2;
	$retina_h = $dst_h*2;
	
	//get image size after cropping
	$dims_x2 = image_resize_dimensions($orig_w, $orig_h, $retina_w, $retina_h, $crop);
	$dst_x2_w = $dims_x2[4];
	$dst_x2_h = $dims_x2[5];
	
	// If possible lets make the @2x image
	if($dst_x2_h) {
	
		//@2x image url
		$destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}@2x.{$ext}";
		
		//check if retina image exists
		if(file_exists($destfilename) && getimagesize($destfilename)) {	
			// already exists, do nothing
		} else {
			// doesnt exist, lets create it
			$editor = wp_get_image_editor($img_path);
			if ( ! is_wp_error( $editor ) ) {
				$editor->resize( $retina_w, $retina_h, $crop );
				$editor->set_quality( 100 );
				$filename = $editor->generate_filename( $dst_w . 'x' . $dst_h . '@2x'  );
				$editor = $editor->save($filename);	
			}
		}
	
	}
	
	// Return image --------------------------------------------------------------->
	$img_url = isset($img_url) ? $img_url : $url;
	$dst_w = isset($dst_w) ? $dst_w : '';
	$dst_h = isset($dst_h) ? $dst_h : '';
	if ( 'url' == $return ) {
		return $img_url;
	} elseif ( 'array' == $return ) {
		return array(
			'url'		=> $img_url,
			'width'		=> $dst_w,
			'height'	=> $dst_h
		);
	} else {
		return $img_url;
	}

}