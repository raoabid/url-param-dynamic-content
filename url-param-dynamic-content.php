<?php
/*
Plugin Name: URL Param Dynamic Content
Plugin URI: https://github.com/raoabid/url-param-dynamic-content
Description: 
Author: BooSpot
Version: 1.0.0
Author URI: https://boospot.com/
*/


// Shortcode_display :  url_param_content    // like: show_post_list

function url_param_dynamic_content_cb( $atts = [], $content = null, $tag = '' ) {
	// normalize attribute keys, lowercase
	$atts = array_change_key_case( (array) $atts, CASE_LOWER );

	$atts = shortcode_atts( array(
		// Update the default Values
		'key'     => '',
		'value'   => '',
		'message' => ''

	), $atts );

	if ( empty( $atts['key'] ) ) {
		return esc_html__( 'Please add param key in shortcode.', 'url-param-dynamic-content' );
	}

	if ( empty( $atts['value'] ) ) {
		return esc_html__( 'Please add param value in shortcode to compare with.', 'url-param-dynamic-content' );
	}

	$url_key = isset( $_GET[ sanitize_key( $atts['key'] ) ] ) ? sanitize_key( $atts['key'] ) : '';

	if ( empty( $url_key ) ) {
		return esc_html( $atts['message'] );
	}

	$param_value = isset( $_GET[ $url_key ] ) ? sanitize_text_field( $_GET[ $url_key ] ) : '';

	if ( empty( $param_value ) || $param_value !== $atts['value'] ) {
		return esc_html__( 'Invalid Secret Token.', 'url-param-dynamic-content' );
	}

	// start output
	$output = '';


	// Update output
	$output .= '<div class="url-param-dynamic-content">';
	$output .= do_shortcode( $content );
	$output .= '</div>';

	// return output
	return $output;
}

add_shortcode( 'url_param_content', 'url_param_dynamic_content_cb' );