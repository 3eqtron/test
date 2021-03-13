<?php
/*
 * This is the child theme for Zubin theme.
 *
 * (Please see https://developer.wordpress.org/themes/advanced-topics/child-themes/#how-to-create-a-child-theme)
 */
function zubin_music_enqueue_styles() {
    // Include parent theme CSS.
    wp_enqueue_style( 'zubin-style', get_template_directory_uri() . '/style.css', null, date( 'Ymd-Gis', filemtime( get_template_directory() . '/style.css' ) ) );
    
    // Include child theme CSS.
    wp_enqueue_style( 'zubin-music-style', get_stylesheet_directory_uri() . '/style.css', array( 'zubin-style' ), date( 'Ymd-Gis', filemtime( get_stylesheet_directory() . '/style.css' ) ) );

	// Load the rtl.
	if ( is_rtl() ) {
		wp_enqueue_style( 'zubin-rtl', get_template_directory_uri() . '/rtl.css', array( 'zubin-style' ), $version );
	}

	// Enqueue child block styles after parent block style.
	wp_enqueue_style( 'zubin-music-block-style', get_stylesheet_directory_uri() . '/assets/css/child-blocks.css', array( 'zubin-block-style' ), date( 'Ymd-Gis', filemtime( get_stylesheet_directory() . '/assets/css/child-blocks.css' ) ) );
}
add_action( 'wp_enqueue_scripts', 'zubin_music_enqueue_styles' );

/**
 * Add languages and child theme editor styles
 */
function zubin_music_editor_style() {
	load_child_theme_textdomain( 'zubin-music', get_stylesheet_directory() . '/languages' );

	add_editor_style( array(
			'assets/css/child-editor-style.css',
			zubin_fonts_url(),
			get_theme_file_uri( 'assets/css/font-awesome/css/font-awesome.css' ),
		)
	);
}
add_action( 'after_setup_theme', 'zubin_music_editor_style', 11 );

/**
 * Enqueue editor styles for Gutenberg
 */
function zubin_music_block_editor_styles() {
	// Enqueue child block editor style after parent editor block css.
	wp_enqueue_style( 'zubin-music-block-editor-style', get_stylesheet_directory_uri() . '/assets/css/child-editor-blocks.css', array( 'zubin-block-editor-style' ), date( 'Ymd-Gis', filemtime( get_stylesheet_directory() . '/assets/css/child-editor-blocks.css' ) ) );
}
add_action( 'enqueue_block_editor_assets', 'zubin_music_block_editor_styles', 11 );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function zubin_music_body_classes( $classes ) {
	// Added color scheme to body class.
	$classes['theme_scheme']             = 'theme-scheme-music';
	$classes['color_scheme']             = 'color-scheme-dark';
	$classes['zubin_menu_type']          = 'navigation-default';
	$classes['zubin_modern_social_menu'] = 'modern-social';
	$classes['zubin_content_layout']     = 'excerpt-image-left';
	$classes['zubin_menu_layout']        = 'header-boxed';

	$enable_sticky_playlist = get_theme_mod( 'zubin_sticky_playlist_visibility', 'disabled' );

	if ( zubin_check_section( $enable_sticky_playlist ) ) {
		$classes[] = 'sticky-playlist-enabled';
	}

	return $classes;
}
add_filter( 'body_class', 'zubin_music_body_classes', 11 );

/**
 * Change default header text color
 */
function zubin_music_header_default_color( $args ) {
	$args['default-image'] =  get_theme_file_uri( 'assets/images/header-image.jpg' );

	return $args;
}
add_filter( 'zubin_custom_header_args', 'zubin_music_header_default_color' );

/**
 * Change default background color
 */
function zubin_music_default_background_color( $args ) {
	$args['default-color'] =  '#000000';

	return $args;
}
add_filter( 'zubin_custom_bg_args', 'zubin_music_default_background_color' );

/**
 * Override google font to source of parent
 */
function zubin_fonts_url() {
	/** 
	 * Translators: If there are characters in your language that are not
	 * supported by Source Sans Pro, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$source_sans_pro = _x( 'on', 'Source Sans Pro: on or off', 'zubin-music' );

	if ( 'on' === $source_sans_pro ) {
		return esc_url( '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,400italic,700italic' );
	}
}

/**
 * Override Parent Header Media Text
 */
function zubin_header_media_text() {

	if ( ! zubin_has_header_media_text() ) {
		// Bail early if header media text is disabled on front page
		return false;
	}

	$header_media_logo = get_theme_mod( 'zubin_header_media_logo' );

	$before_subtitle = get_theme_mod( 'zubin_header_media_before_subtitle' );

	$after_subtitle = get_theme_mod( 'zubin_header_media_after_subtitle');
	?>
	<div class="custom-header-content content-position-center text-align-center">

		<div class="entry-container-wrapper">
			<div class="entry-container">
			<?php
			$enable_homepage_logo = get_theme_mod( 'zubin_header_media_logo_option', 'homepage' );
			?>

			<div class="entry-header">
				<?php if( is_front_page() && $before_subtitle ) : ?>
					<div class="sub-title">
						<span>
							<?php echo esc_html( $before_subtitle ); ?>
						</span>
					</div>
				<?php endif; ?>

				<?php
				if ( zubin_check_section( $enable_homepage_logo ) && $header_media_logo ) {  ?>
					<div class="site-header-logo">
						<img src="<?php echo esc_url( $header_media_logo ); ?>" title="<?php echo esc_attr( home_url( '/' ) ); ?>" />
					</div><!-- .site-header-logo -->
				<?php } ?>

				<?php
				if ( is_singular() && ! is_page() ) {
					zubin_header_title( '<h1 class="entry-title">', '</h1>' );
				} else {
					zubin_header_title( '<h2 class="entry-title">', '</h2>' );
				}
				?>

				<?php if( is_front_page() && $after_subtitle ) : ?>
					<div class="sub-title">
						<span>
							<?php echo esc_html( $after_subtitle ); ?>
						</span>
					</div>
				<?php endif; ?>
			</div>

			<?php zubin_header_description(); ?>

			</div> <!-- .entry-container -->
		</div> <!-- .entry-container-wrapper -->
	</div><!-- .custom-header-content -->
	<?php
} // zubin_header_media_text.

/**
 * Add an HTML class to MediaElement.js container elements to aid styling.
 *
 * Extends the core _wpmejsSettings object to add a new feature via the
 * MediaElement.js plugin API.
 */
function zubin_music_mejs_add_container_class() {
	if ( ! wp_script_is( 'mediaelement', 'done' ) ) {
		return;
	}
	?>
	<script>
	(function() {
		var settings = window._wpmejsSettings || {};

		settings.features = settings.features || mejs.MepDefaults.features;

		settings.features.push( 'zubin_class' );

		MediaElementPlayer.prototype.buildzubin_class = function(player, controls, layers, media) {
			if ( ! player.isVideo ) {
				var container = player.container[0] || player.container;

				container.style.height = '';
				container.style.width = '';
				player.options.setDimensions = false;
			}

			if ( jQuery( '#' + player.id ).parents('#sticky-playlist-section').length ) {
				player.container.addClass( 'zubin-mejs-container zubin-mejs-sticky-playlist-container' );

				jQuery( '#' + player.id ).parent().children('.wp-playlist-tracks').addClass('displaynone');

				var volume_slider = controls[0].children[5];

				if ( jQuery( '#' + player.id ).parent().children('.wp-playlist-tracks').length > 0) {
					var playlist_button =
					jQuery('<div class="mejs-button mejs-playlist-button mejs-toggle-playlist">' +
						'<button type="button" aria-controls="mep_0" title="Toggle Playlist"></button>' +
					'</div>')

					// append it to the toolbar
					.appendTo( jQuery( '#' + player.id ) )

					// add a click toggle event
					.click(function() {
						jQuery( '#' + player.id ).parent().children('.wp-playlist-tracks').slideToggle();
						jQuery( this ).toggleClass('is-open')
					});

					var play_button = controls[0].children[0];

					// Add next button after volume slider
					var next_button =
					jQuery('<div class="mejs-button mejs-next-button mejs-next">' +
						'<button type="button" aria-controls="' + player.id
						+ '" title="<?php esc_attr_e( 'Next Track', 'zubin-music' ); ?>"></button>' +
					'</div>')

					// insert after volume slider
					.insertAfter(play_button)

					// add a click toggle event
					.click(function() {
						jQuery( '#' + player.id ).parent().find( '.wp-playlist-next').trigger('click');
					});

					// Add prev button after volume slider
					var previous_button =
					jQuery('<div class="mejs-button mejs-previous-button mejs-previous">' +
						'<button type="button" aria-controls="' + player.id
						+ '" title="<?php esc_attr_e( 'Previous Track', 'zubin-music' ); ?>"></button>' +
					'</div>')

					// insert after volume slider
					.insertBefore( play_button )

					// add a click toggle event
					.click(function() {
						jQuery( '#' + player.id ).parent().find( '.wp-playlist-prev').trigger('click');
					});
				}
			} else {
				player.container.addClass( 'zubin-mejs-container' );
				if ( jQuery( '#' + player.id ).parent().children('.wp-playlist-tracks').length > 0) {
					var play_button = controls[0].children[0];

					// Add next button after volume slider
					var next_button =
					jQuery('<div class="mejs-button mejs-next-button mejs-next">' +
						'<button type="button" aria-controls="' + player.id
						+ '" title="<?php esc_attr_e( 'Next Track', 'zubin-music' ); ?>"></button>' +
					'</div>')

					// insert after volume slider
					.insertAfter(play_button)

					// add a click toggle event
					.click(function() {
						jQuery( '#' + player.id ).parent().find( '.wp-playlist-next').trigger('click');
					});

					// Add prev button after volume slider
					var previous_button =
					jQuery('<div class="mejs-button mejs-previous-button mejs-previous">' +
						'<button type="button" aria-controls="' + player.id
						+ '" title="<?php esc_attr_e( 'Previous Track', 'zubin-music' ); ?>"></button>' +
					'</div>')

					// insert after volume slider
					.insertBefore( play_button )

					// add a click toggle event
					.click(function() {
						jQuery( '#' + player.id ).parent().find( '.wp-playlist-prev').trigger('click');
					});
				}
			}
		}
	})();
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'zubin_music_mejs_add_container_class' );

/**
 * Load Customizer Options
 */
require trailingslashit( get_stylesheet_directory() ) . 'inc/customizer/sticky-playlist.php';
