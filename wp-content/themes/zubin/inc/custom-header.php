<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Zubin
 */

if ( ! function_exists( 'zubin_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see zubin_custom_header_setup().
	 */
	function zubin_header_style() {
		$header_image = zubin_featured_overall_image();

	    if ( 'disable' !== $header_image ) : ?>
	        <style type="text/css" rel="header-image">
	            .custom-header:before {
	                background-image: url( <?php echo esc_url( $header_image ); ?>);
					background-position: center top;
					background-repeat: no-repeat;
					background-size: cover;
	            }
	        </style>
	    <?php
	    endif;

	    $header_textcolor = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_textcolor ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
		?>
			.site-title a,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
			// If the user has set a custom color for the text use that.
			else :
		?>
			.absolute-header .site-title a,
			.absolute-header .site-description {
				color: #<?php echo esc_attr( $header_textcolor ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;

if ( ! function_exists( 'zubin_featured_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own zubin_featured_image(), and that function will be used instead.
	 *
	 * @since 1.0
	 */
	function zubin_featured_image() {
		if ( is_header_video_active() && has_header_video() ) {
			return get_header_image();
		}

		$thumbnail = array(1920,1080);

		if ( is_post_type_archive( 'jetpack-testimonial' ) ) {
			$jetpack_options = get_theme_mod( 'jetpack_testimonials' );

			if ( isset( $jetpack_options['featured-image'] ) && '' !== $jetpack_options['featured-image'] ) {
				$image = wp_get_attachment_image_src( (int) $jetpack_options['featured-image'], $thumbnail );
				return $image['0'];
			} else {
				return false;
			}
		} elseif ( is_post_type_archive( 'jetpack-portfolio' ) || is_post_type_archive( 'featured-content' ) || is_post_type_archive( 'ect-service' ) ) {
			$option = '';

			if ( is_post_type_archive( 'jetpack-portfolio' ) ) {
				$option = 'jetpack_portfolio_featured_image';
			} elseif ( is_post_type_archive( 'featured-content' ) ) {
				$option = 'featured_content_featured_image';
			} elseif ( is_post_type_archive( 'ect-service' ) ) {
				$option = 'ect_service_featured_image';
			}

			$featured_image = get_option( $option );

			if ( '' !== $featured_image ) {
				$image = wp_get_attachment_image_src( (int) $featured_image, $thumbnail );
				return $image[0];
			} else {
				return get_header_image();
			}
		} elseif ( is_header_video_active() && has_header_video() ) {
			return true;
		} else {
			return get_header_image();
		}
	} // zubin_featured_image
endif;

if ( ! function_exists( 'zubin_featured_page_post_image' ) ) :
	/**
	 * Template for Featured Header Image from Post and Page
	 *
	 * To override this in a child theme
	 * simply create your own zubin_featured_imaage_pagepost(), and that function will be used instead.
	 *
	 * @since 1.0
	 */
	function zubin_featured_page_post_image() {
		$thumbnail = array( 1920, 1080 );

		if ( is_home() && $blog_id = get_option('page_for_posts') ) {
			if ( has_post_thumbnail( $blog_id  ) ) {
		    	return get_the_post_thumbnail_url( $blog_id, $thumbnail );
			} else {
				return  zubin_featured_image();
			}
		} elseif ( ! has_post_thumbnail() ) {
			return  zubin_featured_image();
		} elseif ( is_home() && is_front_page() ) {
			return  zubin_featured_image();
		}

		return get_the_post_thumbnail_url( get_the_id(), $thumbnail );
	} // zubin_featured_page_post_image
endif;

if ( ! function_exists( 'zubin_featured_overall_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own zubin_featured_pagepost_image(), and that function will be used instead.
	 *
	 * @since 1.0
	 */
	function zubin_featured_overall_image() {
		global $post;
		$enable = get_theme_mod( 'zubin_header_media_option', 'homepage' );

		// Check Enable/Disable header image in Page/Post Meta box
		if ( is_singular() ) {
			$zubin_id = $post->ID;

			//Individual Page/Post Image Setting
			$individual_featured_image = get_post_meta( $zubin_id, 'zubin-header-image', true );

			if ( 'disable' === $individual_featured_image || ( 'default' === $individual_featured_image && 'disable' === $enable ) ) {
				return 'disable' ;
			} elseif ( 'enable' == $individual_featured_image ) {
				return zubin_featured_page_post_image();
			}
		}

		// Check Homepage
		if ( 'homepage' === $enable ) {
			if ( is_front_page() ) {
				return zubin_featured_image();
			}
		}  elseif ( 'entire-site' === $enable ) {
			// Check Entire Site
			return zubin_featured_image();
		}

		return 'disable';
	} // zubin_featured_overall_image
endif;

if ( ! function_exists( 'zubin_header_media_text' ) ):
	/**
	 * Display Header Media Text
	 *
	 * @since 1.0
	 */
	function zubin_header_media_text() {

		if ( ! zubin_has_header_media_text() ) {
			// Bail early if header media text is disabled on front page
			return false;
		}

		$classes[] = 'custom-header-content';

		if ( is_front_page() ) {
			$classes[] = 'content-position-right';
			$classes[] = 'text-align-right';
		} else {
			$classes[] = 'content-position-center';
			$classes[] = 'text-align-center';
		}

		$header_media_logo = get_theme_mod( 'zubin_header_media_logo' );

		$before_subtitle = get_theme_mod( 'zubin_header_media_before_subtitle' );

		$after_subtitle = get_theme_mod( 'zubin_header_media_after_subtitle');
		?>
		<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

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
endif;

if ( ! function_exists( 'zubin_has_header_media_text' ) ):
	/**
	 * Return Header Media Text fro front page
	 *
	 * @since 1.0
	 */
	function zubin_has_header_media_text() {
		$header_image = zubin_featured_overall_image();

		if ( is_front_page() ) {
			$header_media_logo     = get_theme_mod( 'zubin_header_media_logo' );
			$header_media_title    = get_theme_mod( 'zubin_header_media_title' );
			$header_media_text     = get_theme_mod( 'zubin_header_media_text' );
			$header_media_url      = get_theme_mod( 'zubin_header_media_url' );
			$header_media_url_text = get_theme_mod( 'zubin_header_media_url_text' );

			if ( ! $header_media_logo && ! $header_media_title && ! $header_media_text && ! $header_media_url && ! $header_media_url_text ) {
				// Bail early if header media text is disabled
				return false;
			}
		} elseif ( 'disable' === $header_image ) {
			return false;
		}

		return true;
	} // zubin_has_header_media_text.
endif;

if ( ! function_exists( 'zubin_header_title' ) ) :
	/**
	 * Display header media text
	 */
	function zubin_header_title( $before = '', $after = '' ) {
		if ( is_front_page() ) {
			$header_media_title = get_theme_mod( 'zubin_header_media_title' );
			if ( $header_media_title ) {
				echo $before . wp_kses_post( $header_media_title ) . $after;
			}
		} else if ( is_home() ) {
			if ( $header_media_title ) {
				echo $before . wp_kses_post( $header_media_title ) . $after;
			}
		} elseif ( is_singular() ) {
			if ( is_page() ) {
				the_title( $before, $after );
			} else {
				the_title( $before, $after );
			}
		} elseif ( is_404() ) {
			echo $before . esc_html__( 'Nothing Found', 'zubin' ) . $after;
		} elseif ( is_search() ) {
			/* translators: %s: search query. */
			echo $before . sprintf( esc_html__( 'Search Results for: %s', 'zubin' ), '<span>' . get_search_query() . '</span>' ) . $after;
		}
		else {
			the_archive_title( $before, $after );
		}
	}
endif;

if ( ! function_exists( 'zubin_header_description' ) ) :
	/**
	 * Display header media description
	 */
	function zubin_header_description( $before = '', $after = '' ) {
		if ( is_front_page() ) {
			$content = get_theme_mod( 'zubin_header_media_text' );

			if ( $header_media_url = get_theme_mod( 'zubin_header_media_url', esc_html__( '#', 'zubin' ) ) ) {
				$target = get_theme_mod( 'zubin_header_url_target' ) ? '_blank' : '_self';

				$content .= '<span class="more-button"><a href="'. esc_url( $header_media_url ) . '" target="' . $target . '" class="more-link">' .esc_html( get_theme_mod( 'zubin_header_media_url_text' ) ) . '<span class="screen-reader-text">' .wp_kses_post( get_theme_mod( 'zubin_header_media_title' ) ) . '</span></a></span>';
			}

			echo '<div class="entry-summary">' . wp_kses_post( $content ) . '</div>';
		} elseif ( is_404() ) {
			echo $before . '<p>' . esc_html__( 'Oops! That page can&rsquo;t be found', 'zubin' ) . '</p>' . $after;
		} else {
			the_archive_description( $before, $after );
		}
	}
endif;
