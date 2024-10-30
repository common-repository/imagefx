<?php 
/* 
Plugin Name: ImageFX
Plugin URI: http://ottopress.com/wordpress-plugins/imagefx/
Description: Add filtering to your WordPress images. Black and white, sepia tones, colorization, and more. Expandable with custom filters too!
Author: Otto, wpsmith
Version: 0.5
Author URI: http://ottodestruct.com
License: GPL2

    Copyright 2011-  Samuel Wood  (email : otto@ottodestruct.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html

*/


/**
 * ImageFX Plugin
 *
 * @package      ImageFX
 * @author       Samuel Wood  <otto@ottodestruct.com>
 * @author       Travis Smith <travis@wpsmith.net>
 * @copyright    Copyright (c) 2012, Travis Smith
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0.0
 *
 */
include 'filters.php';

add_action( 'admin_menu', 'imagefx_admin_add_page' );
/**
 * Adds ImageFX Menu Page
 *
 * @uses add_media_page() Add sub menu page to the Media menu.
 */
function imagefx_admin_add_page() {
	add_media_page( 'ImageFX', 'ImageFX', 'manage_options', 'imagefx', 'imagefx_options_page' );
}

/**
 * ImageFX Options Page HTML Markup
 *
 * @uses settings_fields() Output nonce, action, and option_page fields for a settings page.
 * @uses do_settings_sections() Prints out all settings sections added to a particular settings page.
 * @uses submit_button() Echos a submit button, with provided text and appropriate class.
 */
function imagefx_options_page() {
?>
<div>
<h2>ImageFX</h2>
<p>Here you can define what filter to use on each image size, as well as define a default "slug" to be added to the end of the filename for that size.</p>
<p>The "slugs" should <strong>only</strong> be used when you have two images of the <em>exact</em> same size, but with different filter types. Using a slug when not needed will result in extra files being left in the uploads directory which will be inaccessible to WordPress. Slugs should be left blank if you don't understand what they do.</p>
<form action="options.php" method="post">
<?php 
settings_fields( 'imagefx_options' );
do_settings_sections( 'imagefx' );
submit_button();
?>
</form>
</div>
<?php
}

add_action( 'admin_init', 'imagefx_admin_init' );
/**
 * Registers Settings, settings sections, and settings fields
 *
 * @uses register_setting() Register a setting and its sanitization callback.
 * @uses add_settings_section() Groups of settings with a shared heading.
 * @uses add_settings_field() Register a settings field to a settings page and section.
 * @global array $_wp_additional_image_sizes Additionally registered image sizes.
 */
function imagefx_admin_init(){
	global $_wp_additional_image_sizes;
	
	register_setting( 'imagefx_options', 'imagefx_options', 'imagefx_options_validate' );
	
	// default sizes
	add_settings_section( 'imagefx_default_sizes', __( 'Default Image Sizes', 'imagefx' ), 'imagefx_section_default_sizes_text', 'imagefx' );	
	foreach ( array( 'thumbnail', 'medium', 'large' ) as $field ) {
		add_settings_field( 'imagefx_size' . $field, $field, 'imagefx_size_input', 'imagefx', 'imagefx_default_sizes', array( $field, true ) );
	}

	// theme or plugin added sizes
	if ( ! empty( $_wp_additional_image_sizes ) ) {
		add_settings_section( 'imagefx_additional_sizes', __( 'Additional Image Sizes', 'imagefx' ), 'imagefx_section_additional_sizes_text', 'imagefx' );
		foreach ( $_wp_additional_image_sizes as $field => $info ) {
			add_settings_field( 'imagefx_size' . $field, $field, 'imagefx_size_input', 'imagefx', 'imagefx_additional_sizes', array( $field, false ) );
		}
	}
}

/**
 * imagefx_default_sizes callback function.
 * Echos section text.
 *
 * @see imagefx_admin_init()
 */
function imagefx_section_default_sizes_text() {
	echo '<p>' . __( 'These are the default WordPress sizes. Note that the filenames may change depending on what sizes you have set in the Media Settings.', 'imagefx' ) . '</p>';
}

/**
 * imagefx_default_sizes callback function.
 * Echos section text.
 *
 * @see imagefx_admin_init()
 */
function imagefx_section_additional_sizes_text() {
	echo '<p>' . __( 'These sizes are added by the theme or another plugin. The values here may change if you change themes or plugins. Also note that these sizes may not be accessible through the normal image insertion tool in the Post Editing screen, but may be used by the theme in an automatic fashion. The changes made by the ImageFX filter will still apply to these images.', 'imagefx' ) . '</p>';
}

/**
 * imagefx_size callback function.
 * Function that fills the field with the desired inputs as part of the larger form.
 * Name and id of the input should match the $id given to this function. The function should echo its output.
 *
 * @see imagefx_admin_init()
 * @uses imagefx_get_filter_select() Filter Dropdown HTML
 * @uses imagefx_get_size_array() Retrieves Image Sizes in Array
 * @param array $args 
 */
function imagefx_size_input( $args ) {
	list( $size, $default ) = $args;
	
	$options = get_option( 'imagefx_options' );
	
	$selected = '';
	if ( ! empty( $options['filter'][$size] ) ) $selected = $options['filter'][$size];
	$filters = imagefx_get_filter_select( $size, $selected );
	echo "<td>{$filters}</td>";
	
	$value = '';
	if ( ! empty( $options['slug'][$size] ) ) $value = $options['slug'][$size];
	echo "<td>Slug <input type='text' name='imagefx_options[slug][{$size}]' value='{$value}' /></td>";
	
	$sizes = imagefx_get_size_array();
	echo "<td>Size: {$sizes[$size]['width']}x{$sizes[$size]['height']}</td>";
	if ( isset( $sizes[$size]['crop'] ) && $sizes[$size]['crop'] == 1 ) $crop = 'true';
	else $crop = 'false';
	echo "<td>Hard Cropped: {$crop}</td>";
}

/**
 * Creates Filters Select Dropdown
 *
 * @see imagefx_size_input()
 * @param array $name Image Size
 * @param array $selected Image Size selected
 * @return string HTML Markup
 */
function imagefx_get_filter_select( $name, $selected ) {
	$filters = imagefx_get_filters();

	$value = __( 'Filter: ', 'imagefx' ) . "<select name='imagefx_options[filter][{$name}]'>";
	$value .= '<option value="">none</option>';
	foreach ( $filters as $filter ) {
		$value .= "<option value='{$filter}'".selected( $selected, $filter, false ).">{$filter}</option>";
	}
	$value .= '</select>';
	
	return $value;
}

/**
 * Returns ImageFX Registered Filters
 *
 * @return array ImageFX Registered Filters
 */
function imagefx_get_filters() {
	global $imagefx_filters;
	return array_keys( $imagefx_filters );
}

/**
 * Registers ImageFX Filter(s)
 *
 * @param string/array $name Filter name or array: array( 'filter' => 'callback', 'filter' => 'callback', )
 * @param string $name Callback function name
 */
function imagefx_register_filter( $name, $callback = '' ) {
	global $imagefx_filters;
	
	// Check to see if $name is an non-associative array
	if ( is_array( $name ) && array_values( $name ) === $name ) {
		
		foreach ( $name as $filter ) {
			//if ( empty( $callback ) ) 
			$callback = "imagefx_filter_{$filter}";
			$imagefx_filters[$filter] = $callback;
		}
	} 
	// Check to see if $name is an associative array
	elseif ( is_array( $name ) ) {
		foreach ( $name as $filter => $callback ) {
			//Fallback just in case
			if ( is_int( $filter ) ) {
				$filter = $callback;
				$callback = "imagefx_filter_{$callback}";
			}
			if ( empty( $callback ) )
				$callback = "imagefx_filter_{$filter}";
			
			$imagefx_filters[$filter] = $callback;
		}
	}
	// $name is not an array
	else {
		if ( empty( $callback ) ) $callback = "imagefx_filter_{$name}";
		$imagefx_filters[$name] = $callback;
	}
}

/**
 * Unregisters ImageFX Filter(s)
 *
 * @param string/array $name Filter name(s)
 */
function imagefx_unregister_filter( $filters ) {
	global $imagefx_filters;
	
	if ( is_array( $filters ) ) {
		foreach ( $filters as $filter )
			unset( $imagefx_filters[$filter] );
	}
	else
		unset( $imagefx_filters[$filters] );
}


/**
 * Unregisters all ImageFX Colorize Filters
 *
 * @uses imagefx_unregister_filter() Unregisters filter
 * @param string $name Filter name
 */
function imagefx_unregister_colorize_filters() {
	$filters = array( 'colorize_red', 'colorize_yellow', 'colorize_green', 'colorize_blue', 'colorize_purple' );
	imagefx_unregister_filter( $filters );
}

/**
 * Unregisters all ImageFX Greyscale Filters
 *
 * @uses imagefx_unregister_filter() Unregisters filter
 * @param string $name Filter name
 */
function imagefx_unregister_greyscale_filters() {
	$filters = array( 'grayscale', 'greyscale_except_red', 'greyscale_except_green', 'greyscale_except_blue' );
	imagefx_unregister_filter( $filters );
}

/**
 * Unregisters all ImageFX Sepia Filters
 *
 * @uses imagefx_unregister_filter() Unregisters filter
 * @param string $name Filter name
 */
function imagefx_unregister_sepia_filters() {
	$filters = array( 'sepia', 'sepia_100_50_0', 'sepia_100_70_50', 'sepia_90_60_30', 'sepia_90_90_0', 'sepia_60_60_0', 'sepia_45_45_0' );
	imagefx_unregister_filter( $filters );
}

/**
 * Unregisters all ImageFX Rounded Filters
 *
 * @uses imagefx_unregister_filter() Unregisters filter
 * @param string $name Filter name
 */
function imagefx_unregister_rounded_filters() {
	$filters = array( 'rounded_corners_5', 'rounded_corners_10', 'rounded_corners_15', 'rounded_corners_20', );
	imagefx_unregister_filter( $filters );
}

/**
 * Helper function to create rounded images
 *
 * @param resource $image An image resource
 * @param int $radius Radius
 * @param string $color Hex color (no #)
 */
function imagefx_rounded_corners( &$image, $radius = 5, $color = 'ffffff' ) {
	// Validate inputs
	$color  = ( '#' == substr( $color, 0, 1 ) ) ? substr( $color, 1 ) : $color;
	switch( strlen( $color ) ) {
		case 6:
			break;
		case 3:
			$color .= $color;
			break;
		default:
			$color = 'ffffff';
			break;
	}
	$radius = ( is_int( $radius ) ) ? $radius : intval( $radius );
	
	// Calculate properties
	$source_width  = imagesx ( $image );
	$source_height = imagesy ( $image );

	// Create mask for top-left corner in memory
	$corner_image = imagecreatetruecolor( $radius, $radius );
	$clear_color  = imagecolorallocate( $corner_image, 0, 0, 0 );
	$solid_color  = imagecolorallocate(
		$corner_image,
		hexdec( substr( $color, 0, 2 ) ),
		hexdec( substr( $color, 2, 2 ) ),
		hexdec( substr( $color, 4, 2 ) )
	);
	
	imagecolortransparent( $corner_image, $clear_color );
	imagefill( $corner_image, 0, 0, $solid_color );
	imagefilledellipse( $corner_image, $radius, $radius, $radius * 2, $radius * 2, $clear_color );

	// Render the top-left, bottom-left, bottom-right, top-right corners by rotating and copying the mask
	imagecopymerge( $image, $corner_image, 0, 0, 0, 0, $radius, $radius, 100 );
	$corner_image = imagerotate( $corner_image, 90, 0 );
	
	imagecopymerge( $image, $corner_image, 0, $source_height - $radius, 0, 0, $radius, $radius, 100 );
	$corner_image = imagerotate( $corner_image, 90, 0 );

	imagecopymerge( $image, $corner_image, $source_width - $radius, $source_height - $radius, 0, 0, $radius, $radius, 100 );
	$corner_image = imagerotate( $corner_image, 90, 0 );

	imagecopymerge( $image, $corner_image, $source_width - $radius, 0, 0, 0, $radius, $radius, 100 );
	
	// done!
}

/**
 * A callback function that sanitizes the option's value.
 *
 * @uses imagefx_unregister_filter() Unregisters filter
 * @see imagefx_admin_init()
 * @param array $input
 * @return array $options
 */
function imagefx_options_validate( $input ) {
	$options = array();
	foreach ( get_intermediate_image_sizes() as $s ) {
		if ( ! empty( $input['filter'][$s] ) ) {
			$options['filter'][$s] = $input['filter'][$s];
			$options['slug'][$s] = $input['slug'][$s];
		}
	}

	return apply_filters( 'imagefx_options_validate', $options );
}

/**
 * Returns image sizes in array with width, height, crop information.
 *
 * @uses imagefx_unregister_filter() Unregisters filter
 * @see imagefx_size_input()
 * @return array $imagefx_sizes
 */
function imagefx_get_size_array() {
	global $_wp_additional_image_sizes;
	static $imagefx_sizes;
	
	if ( empty( $imagefx_sizes ) ) {
		foreach ( get_intermediate_image_sizes() as $s ) {
			$imagefx_sizes[$s] = array( 'width' => '', 'height' => '', 'crop' => FALSE );
			if ( isset( $_wp_additional_image_sizes[$s]['width'] ) )
				$imagefx_sizes[$s]['width'] = intval( $_wp_additional_image_sizes[$s]['width'] ); // For theme-added sizes
			else
				$imagefx_sizes[$s]['width'] = get_option( "{$s}_size_w" ); // For default sizes set in options
			if ( isset( $_wp_additional_image_sizes[$s]['height'] ) )
				$imagefx_sizes[$s]['height'] = intval( $_wp_additional_image_sizes[$s]['height'] ); // For theme-added sizes
			else
				$imagefx_sizes[$s]['height'] = get_option( "{$s}_size_h" ); // For default sizes set in options
			if ( isset( $_wp_additional_image_sizes[$s]['crop'] ) )
				$imagefx_sizes[$s]['crop'] = intval( $_wp_additional_image_sizes[$s]['crop'] ); // For theme-added sizes
			else
				$imagefx_sizes[$s]['crop'] = get_option( "{$s}_crop" ); // For default sizes set in options
		}
	}
	return $imagefx_sizes;
}

add_filter( 'wp_generate_attachment_metadata', 'imagefx_filter' );
/**
 * Creates all ImageFX intermediate sizes of the image based on imagefx_options
 *
 * @param mixed $meta Metadata for attachment.
 * @return mixed $meta Modified metadata for attachment.
 */
function imagefx_filter( $meta ) {
	global $imagefx_filters;
	
	$options = get_option( 'imagefx_options' );

	foreach ( $meta['sizes'] as $size => $info ) {
	
		if ( empty( $options['filter'][$size] ) ) continue;
		$filter = $options['filter'][$size];
		
		if ( empty( $imagefx_filters[$filter] ) ) continue;
		$callback = $imagefx_filters[$filter];
		
		$file = wp_upload_dir();
		$file = trailingslashit( $file['path'] ) . $info['file'];
		list( $orig_w, $orig_h, $orig_type ) = @getimagesize( $file );
		
		if ( IMAGETYPE_JPEG === $orig_type || apply_filters( 'imagefx_image_type', false, $orig_type ) ) {
			
			$image = wp_load_image( $file );
			
			$callback( $image );
			
			$slug = $options['slug'][$size];
			if ( ! empty( $slug ) ) {
				$newfile = substr( $file, 0, -4 ) . '-' . $slug . substr( $file, -4 );
				$info['file'] = substr( $info['file'], 0, -4 ) . '-' . $slug . substr( $info['file'], -4 );
			} else {
				$newfile = $file;
			}
			
			if ( IMAGETYPE_JPEG == $orig_type )
				imagejpeg( $image, $newfile );
			
			do_action( 'imagefx_image_create', $image, $newfile, $orig_type );
			
			imagedestroy( $image );
			
			$meta['sizes'][$size]['file'] = $info['file'];
		}
		
	}

	return $meta;
}
