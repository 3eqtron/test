<?php
/*This file is part of store-commerce, shopstore child theme.

All functions of this file will be loaded before of parent theme functions.
Learn more at https://codex.wordpress.org/Child_Themes.

Note: this function loads the parent stylesheet before, then child theme stylesheet
(leave it in place unless you know what you are doing.)
*/


function store_commerce_enqueue_child_styles() {
	
	$parent_style = 'shopstore'; 
	wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 
		'store-commerce-style', 
		get_stylesheet_directory_uri() . '/style.css',
		array( $parent_style ),
		wp_get_theme()->get('Version') );
		
	}
add_action( 'wp_enqueue_scripts', 'store_commerce_enqueue_child_styles',999 );

function store_commerce_textdomain() {
    load_child_theme_textdomain( 'store-commerce', get_stylesheet_directory_uri() . '/languages' );
}
add_action( 'after_setup_theme', 'store_commerce_textdomain' );

/**
 * Disable things from parent
 */
if( !function_exists('store_commerce_disable_from_parent') ): 

	add_action('init','store_commerce_disable_from_parent',50);
	function store_commerce_disable_from_parent(){
		
		remove_action( 'shopstore_header_container', 'shopstore_header_container_middle',20 );
		
	}

endif;



/*Write here your own functions */

if ( ! function_exists( 'store_commerce_posted_meta' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function store_commerce_posted_meta() {
	
	$author_email   = get_the_author_meta( 'user_email' );
	$avatar_url     = get_avatar_url( $author_email );
	$avatar_markup  = '<img class="photo" alt="' . get_the_author() . '" src="' . esc_url( $avatar_url ) . '" />&nbsp;';
	$display_avatar = apply_filters( 'neve_display_author_avatar', true );
	
	echo '<li class="meta author vcard">';
	if ( $display_avatar ) {
		echo $avatar_markup;
	}
	echo '<span class="author-name fn">' .esc_html__( 'By ','store-commerce' ). wp_kses_post( get_the_author_posts_link() ) . '</span>';
	echo'</li>';	
	
	$time_string = sprintf(  '<time class="entry-date published updated" datetime="%1$s">%2$s</time>',
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
	$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'store-commerce' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);
	echo '<li>' . $posted_on . '</li>';
	
	/* translators: used between list items, there is a space after the comma */
	$categories_list = get_the_category_list( esc_html__( ', ', 'store-commerce' ) );
	if ( $categories_list ) {
		printf( '<li class="cat-links">%1$s</li>', $categories_list ); // WPCS: XSS OK.echo 'test';
	}


	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'store-commerce' ),
			the_title( '<li class="screen-reader-text">"', '"</li>', false )
		),
		'<li class="edit-link">',
		'</li>'
	);
	

	}
endif; 




if( !function_exists('store_commerce_header_container_middle') ):
	function store_commerce_header_container_middle(){
	?>
    
    <div class="header-middle">
    <div class="container">
    <div class="row justify-content-md-center store-commerce-header">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
            <div id="logo" class="logo store-commerce">
            
            <?php
            if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
                the_custom_logo();
            }else{
            ?>
                <h1 class="logo site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-title">
                <?php bloginfo( 'name' ); ?>
                </a></h1>
            <?php $description = get_bloginfo( 'description', 'display' );
             if ( $description || is_customize_preview() ) : ?>
                <div class="site-description"><?php echo esc_html($description); ?></div>
            <?php endif; ?>
            
            <?php }?>
            
            </div>
        <!-- /#logo --> 
        	<div class="row">
				<?php
                /**
                * Hook - shopstore_top_product_search 		- 10
                * @hooked shopstore_top_product_search
                */
                do_action( 'shopstore_top_product_search' );
                ?> 
            </div>
        </div>
        
        <div class="col-md-3 align-self-center">
            <div class="box-icon-cart">
            
            <?php if ( class_exists( 'WooCommerce' ) ) :?>
           	   <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="icon-cart cart-icon">
           		 <img src="<?php echo esc_url( get_template_directory_uri() );?>/assets/img/cart.png" alt="">
                <span class="count"><?php echo esc_html( WC()->cart->get_cart_contents_count());?></span>
                    <span class="price">
                        <?php echo esc_html( wp_strip_all_tags( WC()->cart->get_cart_total() ) );?>
                    </span> 
                </a>
            <?php endif;?>
            
            
            
            </div><!-- /.box-cart -->
        </div><!-- /.col-md-3 -->
    
    
    </div><!-- /.row -->
    
    </div><!-- /.container -->
    </div><!-- /.header-middle -->
	
	<?php	
	
	}
	endif;
add_action( 'shopstore_header_container', 'store_commerce_header_container_middle',20 );