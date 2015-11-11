<?php
/*
Plugin Name: OCWS Image Widget
Plugin URI: http://www.oldcastleweb.com/pws/plugins/
Description: This plugin adds a new widget to your Wordpress installation, called 'OCWS Image Widget'. This widget is a very basic widget that allows an image to be added. Currently, it requires the URL for the image to be added to the widget form, and then the image is just displayed at 100% of the width of the widget. Further refinements are necessary: 1. A means to upload a new image to assign to the widget. 2. The ability to resize the image so that it is about the right width for the widget.
Version: 0.6
Author: Paul Taylor
Author URI: http://www.oldcastleweb.com/pws/about/
License: GPL2
GitHub Plugin URI: https://github.com/pftaylor61/ocws-image-widget
GitHub Branch:     master

*/
/*  Copyright 2012  Paul Taylor  (email : info@oldcastleweb.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
// test

/**
 * Adds OCWS_Image_Widget widget.
 * Much of the code for this widget plugin was found on the Wordpress.org site at:
 * http://codex.wordpress.org/Widgets_API
 */
 
// New version test
 
class OCWS_Image_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'ocws_image_widget', // Base ID
			'OCWS Image Widget', // Name
			array( 'description' => __( 'OCWS Image Widget', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$im_title = $instance['im_title'];
		$im_alt = $instance['im_alt'];
		$im_url = $instance['im_url'];
		
		// $im_url = "http://localhost/samplesite/wp-content/uploads/2013/02/sixdaysdvd_ad.png";
		// $im_alt = "Hi there";
		// $im_title = "Hi there";
		$htmlcode = "";
		$htmlcode .= "<img src=\"".$im_url."\" alt=\"".$im_alt."\" title=\"".$im_title."\" style=\"width:100%;\" />";

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		echo __( $htmlcode, 'text_domain' );
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['im_title'] = strip_tags( $new_instance['im_title'] );
		$instance['im_alt'] = strip_tags( $new_instance['im_alt'] );
		$instance['im_url'] = strip_tags( $new_instance['im_url'] );
		

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) && isset( $instance[ 'im_title' ]) && isset( $instance[ 'im_alt' ]) && isset( $instance[ 'im_url' ]) ) {
			$title = $instance[ 'title' ];
			$im_title = $instance[ 'im_title' ];
			$im_alt = $instance[ 'im_alt' ];
			$im_url = $instance[ 'im_url' ];
		}
		else {
			$title = "";
			$im_title = __( 'Image title', 'text_domain' );
			$im_alt = __( 'Alternative text', 'text_domain' );
			$im_url = "";
		}
		?>
		<p>
		
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget Title: (Leave blank if not required)' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		
		<div id="im_wg_instr" style="border:1px black dotted; background-color:cornsilk; font-size:8pt; color:black; padding:5px;-moz-border-radius: 15px;
border-radius: 15px;">
			<p>
				Before completing this widget form, use your media library to upload the image that you require. Make sure its width is between 200 and 500 pixels wide. Then copy the location url of the image and paste it into the field below.
			</p>
		</div>
		
		<label for="<?php echo $this->get_field_id( 'im_url' ); ?>"><?php _e( 'URL:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'im_url' ); ?>" name="<?php echo $this->get_field_name( 'im_url' ); ?>" type="text" value="<?php echo esc_attr( $im_url ); ?>" />
		
		<label for="<?php echo $this->get_field_id( 'im_title' ); ?>"><?php _e( 'Image Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'im_title' ); ?>" name="<?php echo $this->get_field_name( 'im_title' ); ?>" type="text" value="<?php echo esc_attr( $im_title ); ?>" />
		
		<label for="<?php echo $this->get_field_id( 'im_alt' ); ?>"><?php _e( 'Alt Text:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'im_alt' ); ?>" name="<?php echo $this->get_field_name( 'im_alt' ); ?>" type="text" value="<?php echo esc_attr( $im_alt ); ?>" />

		<table><tr>
		<td><img src="http://www.oldcastleweb.com/pws/wp-content/uploads/2012/08/castlelogo16x16.png" width="16" height="16" alt="OCWS Logo" title="" /></td>
		<td style="font-size:8pt;"><a style="text-decoration:none" href="http://www.oldcastleweb.com/pws/plugins/" target="_blank">Old Castle Web Services</a></td>
		</tr></table>
		
		</p>
		<?php 
	}

} // class OCWS_Image_Widget

// register OCWS_Image_Widget widget
add_action( 'widgets_init', create_function( '', 'register_widget( "ocws_image_widget" );' ) );








?>