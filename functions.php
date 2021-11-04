<?php

function biketravel_add_theme_support(){

  // Add theme support for HTML5 search form.
  add_theme_support( 'html5', array( 'search-form' ) );

  // Add default posts and comments RSS feed links to head.
  add_theme_support( 'automatic-feed-links' );

  //Adds dynamic title tag
  add_theme_support('title-tag');

  add_theme_support('post_thumbnails');

  // Set up the WordPress core custom background feature.
  add_theme_support(
    'custom-background',
    apply_filters(
      'biketravel_custom_background_args',
      array(
        'default-color' => 'ffffff',
        'default-image' => '',
      )
    )
  );

  // Add theme support for selective refresh for widgets.
  add_theme_support( 'customize-selective-refresh-widgets' );
  /**
   * Add support for core custom logo.
   *
   * @link https://codex.wordpress.org/Theme_Logo
   */

  add_theme_support(
    'custom-logo',
    array(
      'height'      => 250,
      'width'       => 250,
      'flex-width'  => true,
      'flex-height' => true,
      'header-text' => array( 'site-title', 'site-description' )
    )
  );
}

add_action('after_setup_theme','biketravel_add_theme_support');
/*
function biketravel_custom_logo_setup() {
  $defaults = array(
  //'height'      => 100,
  //'width'       => 400,
  'flex-height' => true,
  'flex-width'  => true,
  'header-text' => array( 'site-title', 'site-description' ),
  );
  add_theme_support( 'custom-logo', $defaults );
 }
 add_action( 'after_setup_theme', 'biketravel_custom_logo_setup' );
*/

/**
 * Register Custom Navigation Walker
 */
function register_navwalker(){
	require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
}
add_action( 'after_setup_theme', 'register_navwalker' );

function biketravel_menus(){

  $locations = array(
    'main' => 'Main Menu',
    //'main' => "Main Navigation Menu",
    'footer' => "Footer Menus",
    'topmenu' => "Top Menu"
  );

  register_nav_menus($locations);

}

add_action('init','biketravel_menus');

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function biketravel_widgets_init() {

  register_sidebar(
		array(
			'name'          => esc_html__( 'Home Page Banner', 'biketravel' ),
			'id'            => 'hompage-banner',
			'description'   => esc_html__( 'Add widgets here.', 'biketravel' ),
			'before_widget' => '<div id="%1$s" class="jumbotron jumbotron-fluid bt-jumbo-header widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="bt-display-heading">',
			'after_title'   => '</h2>',
		)
  );

  register_sidebar(
		array(
			'name'          => esc_html__( 'Home Page Above Content', 'biketravel' ),
			'id'            => 'hompage-content-above',
			'description'   => esc_html__( 'Add widgets here.', 'biketravel' ),
			'before_widget' => '<div id="%1$s" class="col-12 bt-homepage-widget widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="bt-display-heading bt-fontprimary">',
			'after_title'   => '</h2>',
		)
  );

  register_sidebar(
		array(
			'name'          => esc_html__( 'Home Page below Content', 'biketravel' ),
			'id'            => 'hompage-content-below',
			'description'   => esc_html__( 'Add widgets here.', 'biketravel' ),
			'before_widget' => '<div id="%1$s" class="col-12 bt-homepage-widget widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="bt-display-heading bt-fontprimary">',
			'after_title'   => '</h2>',
		)
  );

	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'biketravel' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'biketravel' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="bt-display-heading bt-fontprimary">',
			'after_title'   => '</h2>',
		)
  );
  
  register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Area 1', 'biketravel' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here.', 'biketravel' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="bt-display-heading">',
			'after_title'   => '</h2>',
		)
  );
  
  register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Area 2', 'biketravel' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Add widgets here.', 'biketravel' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="bt-display-heading bt-fontprimary">',
			'after_title'   => '</h2>',
		)
  );
  
  register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Area 3', 'biketravel' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Add widgets here.', 'biketravel' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="bt-display-heading">',
			'after_title'   => '</h2>',
		)
  );
  
  register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Area 4', 'biketravel' ),
			'id'            => 'footer-4',
			'description'   => esc_html__( 'Add widgets here.', 'biketravel' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="bt-display-heading">',
			'after_title'   => '</h2>',
		)
  );
  
  register_sidebar(
		array(
			'name'          => esc_html__( 'Tour Page Area 1', 'biketravel' ),
			'id'            => 'tourpage-widget-1',
			'description'   => esc_html__( 'Add Widgets to the Tour Pages, which will be displayed below the Tour Detail block.', 'biketravel' ),
			'before_widget' => '<div id="%1$s" class="container widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="bt-display-heading">',
			'after_title'   => '</h2>',
		)
  );
  
  // Filters Fullscreen Overlay Menu area
  register_sidebar(
		array(
			'name'          => esc_html__( 'Tour Archive Page "More Filters" Overlay', 'biketravel' ),
			'id'            => 'tour-archive-filters-1',
			'description'   => esc_html__( 'Add widgets to the fullscreen popup menu on the Tours Archive pages. This menu displays when the "More Filters" button is clicked.', 'biketravel' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="bt-display-heading">',
			'after_title'   => '</h2>',
		)
  );
  
    // General Widget Area for Search, Archive, Blog Posts and other general pages
    register_sidebar(
      array(
        'name'          => esc_html__( 'General Footer Widget Area 1', 'biketravel' ),
        'id'            => 'general-footer-area-1',
        'description'   => esc_html__( 'Add widgets to the footer of General Pages such as Search, Archives, Blog Posts etc.', 'biketravel' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="bt-display-heading">',
        'after_title'   => '</h2>',
      )
    );
}
add_action( 'widgets_init', 'biketravel_widgets_init' );


// Register Scripts & Styles

function biketravel_register_styles(){

  $version = wp_get_theme()->get( 'Version' );

  wp_enqueue_style('biketravel-stylesheet', get_template_directory_uri() . "/style.css", array('biketravel-bootstrap'), $version, 'all');
  wp_enqueue_style('biketravel-bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css", array(), '4.5.0', 'all');
  //wp_enqueue_style('biketravel-bootstrap', get_template_directory_uri() . "/bootstrap/css/bootstrap.min.css", array(), '4.5.0', 'all');
  wp_enqueue_style('biketravel-fontawesome', "https://kit.fontawesome.com/817f4c55e1.js", array(), '1.0.0', 'all');
  wp_enqueue_style('biketravel_fonts', "https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&family=Teko:wght@300;400;500;600;700&display=swap", array(), $version, 'all');
}

add_action( 'wp_enqueue_scripts', 'biketravel_register_styles' );
/*
//Update the jQuery version that Wordpress Loads
function biketravel_update_wp_jquery() {
  wp_deregister_script( 'jquery' );
  wp_register_script( 'jquery', 'https://code.jquery.com/jquery-3.5.1.slim.min.js', array(), '3.5.1', false);
}

add_action( 'wp_enqueue_scripts', 'biketravel_update_wp_jquery' );

*/
function biketravel_dequeue_scripts() {
  // Remove WP Travel's Verion of collapse.js is being loaded by the theme to avoid conflict with Bootstrap JS.
  wp_deregister_script( 'collapse-js' );
  wp_dequeue_script( 'collapse-js' );
}
add_action( 'wp_print_scripts', 'biketravel_dequeue_scripts', 100 );

function biketravel_register_scripts() {

  $version = wp_get_theme()->get( 'Version' );
  
  //Add theme scripts below.
  wp_enqueue_script('biketravel-popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array(), '1.16.0', true);
  //wp_enqueue_script( 'biketravel-popper', get_template_directory_uri() . '/popperjs/popper-1.14.6.min.js', array(), '1.14.6', true);
  wp_enqueue_script('biketravel-bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js', array(), '4.5.0', true);
  //wp_enqueue_script('biketravel-bootstrap-scripts-local', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array(), '4.5.0', true);
  wp_enqueue_script('biketravel-scripts', get_template_directory_uri() . "/assets/js/main.js", array(), $version, true);

}

add_action( 'wp_enqueue_scripts', 'biketravel_register_scripts');

/**
 * Remove the Taxonomy Name that preceeds the Title
 */
function biketravel_archive_title( $title ) {
  if ( is_category() ) {
      $title = single_cat_title( '', false );
  } elseif ( is_tag() ) {
      $title = single_tag_title( '', false );
  } elseif ( is_author() ) {
      $title = '<span class="vcard">' . get_the_author() . '</span>';
  } elseif ( is_post_type_archive() ) {
      $title = post_type_archive_title( '', false );
  } elseif ( is_tax() ) {
      $title = single_term_title( '', false );
  }

  return $title;
}

add_filter( 'get_the_archive_title', 'biketravel_archive_title' );

/**
 * Add Custom User Roles
 */

function re__update_custom_roles() {
    if ( get_option( 'custom_roles_version' ) < 1 ) {
        add_role( 'copywriter', 'Copywriter', array( 
            'read' => true,
            'edit_pages' => true,
            'edit_published_pages' => true,
            'upload_files' => true
            ) );
        update_option( 'custom_roles_version', 1 );
    }
}

add_action( 'init', 're__update_custom_roles' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

?>