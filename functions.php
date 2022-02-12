<?php

function theme_enqueue_scripts() {
    wp_enqueue_style('theme_style', get_theme_file_uri('assets/css/main.min.css'));
    wp_dequeue_style( 'wp-block-library' );
  //  wp_dequeue_style( 'wp-block-navigation-view' );
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

/**
 * Remove the default ?ver that is put at the end of
 * scripts. This will help caching and performance
 * per Google
 **/
function _remove_script_version( $src ) {
        return remove_query_arg( 'ver', $src );
}
//add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
//add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );

// Remove admin color scheme picker
remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

/*
 * Disable emojis. 
 *
 * There have been security issues, plus it simply provides better
 * performance not to load unecessary core crap all the time.
 */
function grd_remove_emoji() {
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

        // Remove from TinyMCE
        add_filter( 'tiny_mce_plugins', 'grd_remove_tinymce_emoji' );
}
add_action( 'init', 'grd_remove_emoji' );

/**
 * Filter out the tinymce emoji plugin.
 */
function grd_remove_tinymce_emoji( $plugins ) {

        if ( ! is_array( $plugins ) ) {
                return array();
        }

        return array_diff( $plugins, array( 'wpemoji' ) );
}

// Remove the REST API lines from the HTML Header
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

// Remove the REST API endpoint.
remove_action( 'rest_api_init', 'wp_oembed_register_route' );

// Don't filter oEmbed results.
remove_action( 'template_redirect', 'rest_output_link_header', 11 );

// Remove oEmbed discovery links.
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

// Remove oEmbed-specific JavaScript from the front-end and back-end.
remove_action( 'wp_head', 'wp_oembed_add_host_js' );

// Remove xmlrpc
remove_action ('wp_head', 'rsd_link');

// Remove Live Writer config manifest
remove_action( 'wp_head', 'wlwmanifest_link');

// Change the SERVER var holding the REAL visitor ip
add_filter( 'option_limit_login_trusted_ip_origins', function( $origins ) {
        return [ 'HTTP_X_REAL_IP', 'REMOTE_ADDR' ];
} );

