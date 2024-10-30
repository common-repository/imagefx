<?php

/**
 * ImageFX Filters.
 * This file contains the ImageFX registered filters.
 *
 * @package      ImageFX
 * @author       Samuel Wood  <otto@ottodestruct.com>
 * @author       Travis Smith <travis@wpsmith.net>
 * @copyright    Copyright (c) 2012, Travis Smith
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0.0
 *
 */

imagefx_register_filter(
	apply_filters(
		'imagefx_default_filters',
		array(
			'brighten_100', 
			'brighten_50', 
			'colorize_blue', 
			'colorize_green', 
			'colorize_purple', 
			'colorize_red', 
			'colorize_yellow', 
			'contrast_negative', 
			'contrast_positive', 
			'emboss', 
			'emboss_edge', 
			'filter_negative', 
			'filter_smooth', 
			'gaussian_blur', 
			'grayscale', 
			'greyscale_except_blue', 
			'greyscale_except_green', 
			'greyscale_except_red',
			'mean_removal', 
			'photonegative', 
			'selective_blur', 
			'sepia', 
			'sepia_45_45_0', 
			'sepia_60_60_0', 
			'sepia_90_90_0', 
			'sepia_90_60_30', 
			'sepia_100_70_50', 
			'sepia_100_50_0', 
			'rounded_corners_5' => 'imagefx_filter_rounded_corners_5',
			'rounded_corners_10' => 'imagefx_filter_rounded_corners_10',
			'rounded_corners_15' => 'imagefx_filter_rounded_corners_15',
			'rounded_corners_20' => 'imagefx_filter_rounded_corners_20',
		)
	)
);

//imagefx_register_filter( 'grayscale' );
/**
 * Callback function for grayscale filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_grayscale( &$image ) {
	imagefilter( $image, IMG_FILTER_GRAYSCALE );
}

//imagefx_register_filter( 'sepia' );
/**
 * Callback function for sepia filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_sepia( &$image ) {
	$width  = imagesx( $image );
	$height = imagesy( $image );
	for ( $_x = 0; $_x < $width; $_x++ ){
		for ( $_y = 0; $_y < $height; $_y++ ){
			$rgb = imagecolorat( $image, $_x, $_y );
			$r   = ($rgb>>16)&0xFF;
			$g   = ($rgb>>8)&0xFF;
			$b   = $rgb&0xFF;

			$y   = $r * 0.299 + $g * 0.587 + $b * 0.114;
			$i   = 0.15 * 0xFF;
			$q   = - 0.001 * 0xFF;

			$r   = $y + 0.956 * $i + 0.621 * $q;
			$g   = $y - 0.272 * $i - 0.647 * $q;
			$b   = $y - 1.105 * $i + 1.702 * $q;

			if ( $r < 0 || $r > 0xFF ) { $r = ( $r < 0 ) ? 0 : 0xFF; }
			if ( $g < 0 || $g > 0xFF ) { $g = ( $g < 0 ) ? 0 : 0xFF; }
			if ( $b < 0 || $b > 0xFF ) { $b = ( $b < 0 ) ? 0 : 0xFF; }

			$color = imagecolorallocate( $image, $r, $g, $b );
			imagesetpixel( $image, $_x, $_y, $color );
		}
	}
}

//imagefx_register_filter( 'sepia_100_50_0' );
/**
 * Callback function for sepia_100_50_0 filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_sepia_100_50_0( &$image ) {
	imagefilter( $image, IMG_FILTER_GRAYSCALE );
	imagefilter( $image, IMG_FILTER_COLORIZE, 100, 50, 0 );
}

//imagefx_register_filter( 'sepia_100_70_50' );
/**
 * Callback function for sepia_100_50_0 filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_sepia_100_70_50( &$image ) {
	imagefilter( $image, IMG_FILTER_GRAYSCALE );
	imagefilter( $image, IMG_FILTER_COLORIZE, 100, 70, 50 );
}

//imagefx_register_filter( 'sepia_90_60_30' );
/**
 * Callback function for sepia_90_60_30 filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_sepia_90_60_30( &$image ) {
	imagefilter( $image, IMG_FILTER_GRAYSCALE );
	imagefilter( $image, IMG_FILTER_COLORIZE, 90, 60, 30 );
}

//imagefx_register_filter( 'sepia_90_90_0' );
/**
 * Callback function for sepia_90_90_0 filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_sepia_90_90_0( &$image ) {
	imagefilter( $image, IMG_FILTER_GRAYSCALE );
	imagefilter( $image, IMG_FILTER_COLORIZE, 90, 90, 0 );
}

//imagefx_register_filter( 'sepia_60_60_0' );
/**
 * Callback function for sepia_60_60_0 filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_sepia_60_60_0( &$image ) {
	imagefilter( $image, IMG_FILTER_GRAYSCALE );
	imagefilter( $image, IMG_FILTER_COLORIZE, 60, 60, 0 );
}

//imagefx_register_filter( 'sepia_45_45_0' );
/**
 * Callback function for sepia_45_45_0 filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_sepia_45_45_0( &$image ) {
	imagefilter( $image, IMG_FILTER_GRAYSCALE );
	imagefilter( $image, IMG_FILTER_COLORIZE, 45, 45, 0 );
}

//imagefx_register_filter( 'colorize_red' );
/**
 * Callback function for colorize_red filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_colorize_red( &$image ) {
	imagefilter( $image, IMG_FILTER_COLORIZE, 100, 0, 0 );
}

//imagefx_register_filter( 'colorize_yellow' );
/**
 * Callback function for colorize_yellow filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_colorize_yellow( &$image ) {
	imagefilter( $image, IMG_FILTER_COLORIZE, 100, 100, -100 );
}

//imagefx_register_filter( 'colorize_green' );
/**
 * Callback function for colorize_green filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_colorize_green( &$image ) {
	imagefilter( $image, IMG_FILTER_COLORIZE, 0, 100, 0 );
}

//imagefx_register_filter( 'colorize_blue' );
/**
 * Callback function for colorize_blue filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_colorize_blue( &$image ) {
	imagefilter( $image, IMG_FILTER_COLORIZE, 0, 0, 100 );
}

//imagefx_register_filter( 'colorize_purple' );
/**
 * Callback function for colorize_purple filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_colorize_purple( &$image ) {
	imagefilter( $image, IMG_FILTER_COLORIZE, 50, -50, 50 );
}

//imagefx_register_filter( 'photonegative' );
/**
 * Callback function for photonegative filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_photonegative( &$image ) {
	imagefilter( $image, IMG_FILTER_NEGATE );
}

//imagefx_register_filter( 'emboss' );
/**
 * Callback function for emboss filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_emboss( &$image ) {
	imagefilter( $image, IMG_FILTER_EMBOSS );
}

//imagefx_register_filter( 'emboss_edge' );
/**
 * Callback function for emboss_edge filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_emboss_edge( &$image ) {
	imagefilter( $image, IMG_FILTER_EDGEDETECT );
}

//imagefx_register_filter( 'brighten_50' );
/**
 * Callback function for brighten_50 filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_brighten_50( &$image ) {
	imagefilter( $image, IMG_FILTER_BRIGHTNESS, 50 );
}

//imagefx_register_filter( 'brighten_100' );
/**
 * Callback function for brighten_100 filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_brighten_100( &$image ) {
	imagefilter( $image, IMG_FILTER_BRIGHTNESS, 100 );
}

//imagefx_register_filter( 'greyscale_except_red' );
/**
 * Callback function for greyscale_except_red filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_greyscale_except_red( &$image ) {
    $width  = imagesx( $image );
    $height = imagesy( $image );
    for ( $x = 0; $x < $width; $x++ ) {
        for( $y = 0; $y < $height; $y++ ) {
            $rgb = imagecolorat( $image, $x, $y );
            $r   = ($rgb>>16)&0xFF;
            $g   = ($rgb>>8)&0xFF;
            $b   = $rgb&0xFF;
            $bw  = ( int )( ( $r + $g + $b ) / 3 );
            if ( ! ( $r > ( $g + $b ) * 2.2 ) ) { 
            	$color = imagecolorallocate( $image, $bw, $bw, $bw );
            	imagesetpixel( $image, $x, $y, $color );
            }
        }
    }
}

//imagefx_register_filter( 'greyscale_except_green' );
/**
 * Callback function for greyscale_except_green filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_greyscale_except_green( &$image ) {
    $width  = imagesx( $image );
    $height = imagesy( $image );
    for ( $x = 0; $x < $width; $x++ ) {
        for ( $y = 0; $y < $height; $y++ ) {
            $rgb = imagecolorat( $image, $x, $y );
            $r   = ($rgb>>16)&0xFF;
            $g   = ($rgb>>8)&0xFF;
            $b   = $rgb&0xFF;
            $bw  = ( int ) ( ( $r + $g + $b ) / 3 );
            if ( ! ( $g > ( $r + $b ) * 2 ) ) { 
            	$color = imagecolorallocate( $image, $bw, $bw, $bw );
            	imagesetpixel( $image, $x, $y, $color );
            }
        }
    }
}

//imagefx_register_filter( 'greyscale_except_blue' );
/**
 * Callback function for greyscale_except_blue filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_greyscale_except_blue( &$image ) {
    $width  = imagesx( $image );
    $height = imagesy( $image );
    for ( $x = 0; $x < $width; $x++ ) {
        for ( $y = 0; $y < $height; $y++ ) {
            $rgb = imagecolorat( $image, $x, $y );
            $r   = ($rgb>>16)&0xFF;
            $g   = ($rgb>>8)&0xFF;
            $b   = $rgb&0xFF;
            $bw  = ( int ) ( ( $r + $g + $b ) / 3 );
            if ( ! ( $b > ( $g + $r ) * .5 ) ) { 
            	$color = imagecolorallocate( $image, $bw, $bw, $bw );
            	imagesetpixel( $image, $x, $y, $color );
            }
        }
    }
}

//imagefx_register_filter( 'gaussian_blur' );
/**
 * Callback function for gaussian_blur filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_gaussian_blur( &$image ) {
	imagefilter( $image, IMG_FILTER_GAUSSIAN_BLUR );
}

//imagefx_register_filter( 'selective_blur' );
/**
 * Callback function for selective_blur filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_selective_blur( &$image ) {
	imagefilter( $image, IMG_FILTER_SELECTIVE_BLUR );
}

//imagefx_register_filter( 'mean_removal' );
/**
 * Callback function for mean_removal filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_mean_removal( &$image ) {
	imagefilter( $image, IMG_FILTER_MEAN_REMOVAL );
}

//imagefx_register_filter( 'filter_smooth' );
/**
 * Callback function for filter_smooth filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_filter_smooth( &$image ) {
	imagefilter( $image, IMG_FILTER_SMOOTH, 50 );
}

//imagefx_register_filter( 'filter_negative' );
/**
 * Callback function for filter_negative filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_filter_negative( &$image ) {
	imagefilter( $image, IMG_FILTER_NEGATE );
}

//imagefx_register_filter( 'contrast_negative' );
/**
 * Callback function for contrast_negative filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_contrast_negative( &$image ) {
	imagefilter( $image, IMG_FILTER_CONTRAST, -40 );
}

//imagefx_register_filter( 'contrast_positive' );
/**
 * Callback function for contrast_positive filter
 *
 * @param resource $image An image resource
 * @uses imagefilter() Applies a filter to an image
 */
function imagefx_filter_contrast_positive( &$image ) {
	imagefilter( $image, IMG_FILTER_CONTRAST, 5 );
}

/**
 * Callback function for white rounded 5px corner filter
 *
 * @param resource $image An image resource
 * @uses imagefx_rounded_corners() Applies the rounded filter to an image
 */
function imagefx_filter_rounded_corners_5( &$image ) {
	$color  = apply_filters( 'imagefx_rounded_filter_color', 'ffffff' );
	imagefx_rounded_corners( $image, 5, $color );
}

/**
 * Callback function for white rounded 10px corner filter
 *
 * @param resource $image An image resource
 * @uses imagefx_rounded_corners() Applies the rounded filter to an image
 */
function imagefx_filter_rounded_corners_10( &$image ) {
	$color  = apply_filters( 'imagefx_rounded_filter_color', 'ffffff' );
	imagefx_rounded_corners( $image, 10, $color );
}

/**
 * Callback function for white rounded 15px corner filter
 *
 * @param resource $image An image resource
 * @uses imagefx_rounded_corners() Applies the rounded filter to an image
 */
function imagefx_filter_rounded_corners_15( &$image ) {
	$color  = apply_filters( 'imagefx_rounded_filter_color', 'ffffff' );
	imagefx_rounded_corners( $image, 15, $color );
}

/**
 * Callback function for white rounded 20px corner filter
 *
 * @param resource $image An image resource
 * @uses imagefx_rounded_corners() Applies the rounded filter to an image
 */
function imagefx_filter_rounded_corners_20( &$image ) {
	$color  = apply_filters( 'imagefx_rounded_filter_color', 'ffffff' );
	imagefx_rounded_corners( $image, 20, $color );
}

