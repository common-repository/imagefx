=== ImageFX ===
Contributors: Otto42, wpsmith
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=otto%40ottodestruct%2ecom
Tags: image, grayscale, filter, sepia, colorize, emboss, media, upload
Requires at least: 3.2
Tested up to: 3.4
Stable Tag: 0.4
License: GPLv2
License URI: http://www.opensource.org/licenses/GPL-2.0

Add filtering to your WordPress images. Black and white, sepia tones, colorization, and more. Expandable with custom filters too!

== Description ==
ImageFX allows you to add filters to your WordPress images uploaded through the normal media uploader.

For more information:
http://ottopress.com/2011/customizing-wordpress-images-with-a-plugin-imagefx/

Example:
http://demo.wpsmiththemes.com/minfolio/all-image-styles-example/

Default filters:

* Greyscale with except Blue, Red, Green
* Sepia tone with 6 alternatives
* Colorize with red, yellow, green, blue, purple
* Photonegative
* Emboss & Emboss Edge
* Brighten (50, 100)
* Gaussian Blur & Selective Blur
* Mean Removal
* Smooth
* Negative
* Contrast Negative and Positive
* Rounded Corners

ImageFX is expandable and retractable, so removing and adding other filters using your own customized image manipulation functions is easy.
Register new filters with: 

* Individually: imagefx_register_filter( 'filter_name', 'cb_function'); //Note: cb_function defaults to imagefx_filter_{filter_name}
* Bulk: imagefx_register_filters( array( 'filter_name', 'filter_name' ) );

Unregister existing filters with: 

* Individually: imagefx_unregister_filter( 'filter_name' );
* Collectively: imagefx_unregister_filters( array( 'filter_name', 'filter_name') );
* Specifically: imagefx_unregister_colorize_filters(); & imagefx_unregister_greyscale_filters(); & imagefx_unregister_sepia_filters(); imagefx_unregister_rounded_filters();

Want regular updates? Become a fan of my sites on Facebook!
http://www.facebook.com/ottopress
http://www.facebook.com/pages/Nothing-to-See-Here/241409175928000

Or follow us on Twitter!
http://twitter.com/otto42
http://twitter.com/ottodestruct
http://twitter.com/wp_smith

== Installation ==

1. Upload the files to the `/wp-content/plugins/imagefx/` directory
1. Activate the "ImageFX" plugin through the 'Plugins' menu in WordPress
1. Visit the Media->ImageFX settings page to configure the plugin

== Frequently Asked Questions ==

= Where's the settings menu? =

It's under the Media menu. Look for Media->ImageFX.

== Upgrade Notice ==
Added ability to unregister filters, bulk register/unregister filters, more builtin filters, and the ability to handle PNGs.

== Changelog ==

= 0.5 =
* Added imagedestroy for php memory (props griffinjt)

= 0.4 =
* Added rounded corners (wpsmith)

= 0.3 =
* Minor bugfixes (wpsmith)

= 0.2 =
* Added imagefx_unregister_filter(), imagefx_unregister_filters(), imagefx_unregister_colorize_filters(), imagefx_unregister_greyscale_filters(), imagefx_unregister_sepia_filters() (wpsmith)
* Fixed imagefx_filter_colorize_yellow typo, imagefx_filter_photonegative, imagefx_filter_emboss, imagefx_filter_brighten (wpsmith)
* Added the following filters: emboss_edge, brighten_50, brighten_100, gaussian_blur, selective_blur, mean_removal, filter_smooth, filter_negative, contrast_negative, contrast_positive, sepia_100_50_0, sepia_100_70_50, sepia_90_60_30, sepia_90_90_0, sepia_60_60_0, & sepia_45_45_0 (wpsmith)
* Added ability to handle PNGs, not just JPEGs (wpsmith)

= 0.1 =
* First version.
