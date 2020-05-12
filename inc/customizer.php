<?php
/**
 * minimal-portfolio Theme Customizer
 *
 * @package minimal-portfolio
 */
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function minimal_portfolio_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
	$wp_customize->get_setting( 'header_image'  )->transport    = 'postMessage';
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector'        => '.site-title a',
		'render_callback' => 'minimal_portfolio_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector'        => '.site-description',
		'render_callback' => 'minimal_portfolio_customize_partial_blogdescription',
	) );
	
	$default = minimal_portfolio_default_theme_options();
	
	//theme option panel
	$wp_customize->add_panel( 'theme_option_panel', array( 'title' => esc_html__( 'Theme Options', 'minimal-portfolio' ), 'priority' => 200, 'capability' => 'edit_theme_options' ) );
	
	
	// header section
	$wp_customize->add_section( 'minimal_portfolio_header_section', 
		array( 'title' => esc_html__( 'Header Option', 'minimal-portfolio' ),
			   'priority' => 100, 
			   'capability' => 'edit_theme_options', 
			   'panel' => 'theme_option_panel' 
		)
	);
	
	// sticky header setting.
	$wp_customize->add_setting( 'minimal_portfolio_sticky_header_status',
		array(
			'default'           => $default['minimal_portfolio_sticky_header_status'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'minimal_portfolio_sanitize_checkbox',
		)
	);
	// sticky header control
	$wp_customize->add_control( 'minimal_portfolio_sticky_header_status',
		array(
			'label'       => esc_html__( 'Enable Sticky Header', 'minimal-portfolio' ),
			'section'     => 'minimal_portfolio_header_section',
			'type'        => 'checkbox',
			'priority'    => 100		
		)
	);
	
	

	// header section
	$wp_customize->add_section( 'minimal_single_template_section', 
		array( 'title' => esc_html__( 'Single Template', 'minimal-temlate-section' ),
			   'priority' => 100, 
			   'capability' => 'edit_theme_options', 
			   'panel' => 'theme_option_panel' 
		)
	);


	
	// breadcrumb header setting.
	$wp_customize->add_setting( 'minimal_portfolio_breadcrumb_status',
		array(
			'default'           => $default['minimal_portfolio_breadcrumb_status'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'minimal_portfolio_sanitize_checkbox',
		)
	);
	// breadcrumb header control
	$wp_customize->add_control( 'minimal_portfolio_breadcrumb_status',
		array(
			'label'       => esc_html__( 'Enable Breadcrumb', 'minimal-portfolio' ),
			'section'     => 'minimal_portfolio_header_section',
			'type'        => 'checkbox',
			'priority'    => 100		
		)
	);
	
	// page title section
	$wp_customize->add_section( 'minimal_portfolio_page_title_section', 
		array( 'title' => esc_html__( 'Post/Page Title Options', 'minimal-portfolio' ),
			   'priority' => 100, 
			   'capability' => 'edit_theme_options', 
			   'panel' => 'theme_option_panel' 
		)
	);
	
	// page title bg-image setting.
	$wp_customize->add_setting( 'minimal_portfolio_page_title_bgimage',
		array( 
		'default' => get_stylesheet_directory_uri().'/assets/images/header.jpg',
		'sanitize_callback'	=> 'esc_url_raw',	
		'transport'		=> 'refresh',
		'capability' => 'edit_theme_options',
		)
	);
	// page title bg-image control
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,'minimal_portfolio_page_title_bgimage',array(
				'label' => 'Post/Page Title Background Image',
				'section' => 'minimal_portfolio_page_title_section',
				'settings' => 'minimal_portfolio_page_title_bgimage',
				'priority' => 2
			)
		)
	);
	
	// page title bg-image color.
	$wp_customize->add_setting( 'minimal_portfolio_page_title_bgcolor',
		array( 
		'default' => '',		
		'transport'		=> 'refresh',
		'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	// page title bg-color control
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,'minimal_portfolio_page_title_bgcolor',array(
				'label' => 'Post/Page Title Background Color',
				'section' => 'minimal_portfolio_page_title_section',
				'settings' => 'minimal_portfolio_page_title_bgcolor',				
			)
		)
	);
	
	
	
	//footer section
	$wp_customize->add_section( 'minimal_portfolio_footer_section', 
		array( 'title' => esc_html__( 'Footer Option', 'minimal-portfolio' ),
			   'priority' => 200, 
			   'capability' => 'edit_theme_options', 
			   'panel' => 'theme_option_panel' 
		)
	);
	
	//footer facebook setting.
	$wp_customize->add_setting( 'minimal_portfolio_footer_facebook_link', array( 'sanitize_callback' => 'esc_url_raw' ) );
	
	//footer facebook control
	$wp_customize->add_control( 'minimal_portfolio_footer_facebook_link', 
		array( 'label' => esc_html__( 'facebook', 'minimal-portfolio' ),
			   'description' =>  __( 'e.g: http://example.com', 'minimal-portfolio' ), 
			   'section' => 'minimal_portfolio_footer_section', 
			   'type' => 'url',
			   'priority' => 100 
		) 
	);
	
	//footer twitter setting.
	$wp_customize->add_setting( 'minimal_portfolio_footer_twitter_link', array( 'sanitize_callback' => 'esc_url_raw' ) );
	
	//footer twitter control
	$wp_customize->add_control( 'minimal_portfolio_footer_twitter_link', 
		array( 'label' => esc_html__( 'Twitter', 'minimal-portfolio' ),
			   'description' =>  __( 'e.g: http://example.com', 'minimal-portfolio' ), 
			   'section' => 'minimal_portfolio_footer_section', 
			   'type' => 'url',
			   'priority' => 100 
		) 
	);
	
	
	
	//footer youtube setting.
	$wp_customize->add_setting( 'minimal_portfolio_footer_youtube_link', array( 'sanitize_callback' => 'esc_url_raw' ) );
	
	//footer youtube control
	$wp_customize->add_control( 'minimal_portfolio_footer_youtube_link', 
		array( 'label' => esc_html__( 'Youtube', 'minimal-portfolio' ),
			   'description' =>  __( 'e.g: http://example.com', 'minimal-portfolio' ), 
			   'section' => 'minimal_portfolio_footer_section', 
			   'type' => 'url',
			   'priority' => 100 
		) 
	);
	
	//footer instagram setting.
	$wp_customize->add_setting( 'minimal_portfolio_footer_instagram_link', array( 'sanitize_callback' => 'esc_url_raw' ) );
	
	//footer instagram control
	$wp_customize->add_control( 'minimal_portfolio_footer_instagram_link', 
		array( 'label' => esc_html__( 'Instagram', 'minimal-portfolio' ),
			   'description' =>  __( 'e.g: http://example.com', 'minimal-portfolio' ), 
			   'section' => 'minimal_portfolio_footer_section', 
			   'type' => 'url',
			   'priority' => 100 
		) 
	);
	
	//post slider section
	$wp_customize->add_section( 'minimal_portfolio_post_slider_section', 
		array( 'title' => esc_html__( 'Post Slider Option', 'minimal-portfolio' ),
			   'priority' => 300, 
			   'capability' => 'edit_theme_options', 
			   'panel' => 'theme_option_panel' 
		)
	);
	
	// post slider setting.
	$wp_customize->add_setting( 'minimal_portfolio_post_slider_status',
		array(
			'default'           => $default['minimal_portfolio_post_slider_status'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'minimal_portfolio_sanitize_checkbox',
		)
	);
	//post slider control
	$wp_customize->add_control( 'minimal_portfolio_post_slider_status',
		array(
			'label'       => esc_html__( 'Enable Post Slider', 'minimal-portfolio' ),
			'section'     => 'minimal_portfolio_post_slider_section',
			'type'        => 'checkbox',
			'priority'    => 100		
		)
	);
	
	//sidebar sticky section
	$wp_customize->add_section( 'minimal_portfolio_sticky_sidebar_section', 
		array( 'title' => esc_html__( 'Sidebar Sticky Option', 'minimal-portfolio' ),
			   'priority' => 300, 
			   'capability' => 'edit_theme_options', 
			   'panel' => 'theme_option_panel' 
		)
	);
	
	// blog sidebar sticky setting.
	$wp_customize->add_setting( 'minimal_portfolio_blog_sidebar_sticky',
		array(
			'default'           => $default['minimal_portfolio_blog_sidebar_sticky'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'minimal_portfolio_sanitize_checkbox',
		)
	);
	
	//blog post sidebar sticky control
	$wp_customize->add_control( 'minimal_portfolio_blog_sidebar_sticky',
		array(
			'label'       => esc_html__( 'Blog Sidebar Sticky', 'minimal-portfolio' ),
			'section'     => 'minimal_portfolio_sticky_sidebar_section',
			'type'        => 'checkbox',
			'priority'    => 100		
		)
	);
	
	// archive post sidebar sticky setting.
	$wp_customize->add_setting( 'minimal_portfolio_archive_blog_sidebar_sticky',
		array(
			'default'           => $default['minimal_portfolio_archive_blog_sidebar_sticky'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'minimal_portfolio_sanitize_checkbox',
		)
	);
	//archive post sidebar sticky control
	$wp_customize->add_control( 'minimal_portfolio_archive_blog_sidebar_sticky',
		array(
			'label'       => esc_html__( 'Archive Blog Sidebar Sticky', 'minimal-portfolio' ),
			'section'     => 'minimal_portfolio_sticky_sidebar_section',
			'type'        => 'checkbox',
			'priority'    => 100		
		)
	);
		
	// single post sidebar sticky setting.
	$wp_customize->add_setting( 'minimal_portfolio_single_blog_sidebar_sticky',
		array(
			'default'           => $default['minimal_portfolio_single_blog_sidebar_sticky'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'minimal_portfolio_sanitize_checkbox',
		)
	);
	//single post sidebar sticky control
	$wp_customize->add_control( 'minimal_portfolio_single_blog_sidebar_sticky',
		array(
			'label'       => esc_html__( 'Single Blog Sidebar Sticky', 'minimal-portfolio' ),
			'section'     => 'minimal_portfolio_sticky_sidebar_section',
			'type'        => 'checkbox',
			'priority'    => 100		
		)
	);
	
	// portfolio section
	$wp_customize->add_section( 'minimal_portfolio_portfolio_section', 
		array( 'title'       => esc_html__( 'Portfolio Option', 'minimal-portfolio' ),
			   'priority'    => 400, 
			   'capability'  => 'edit_theme_options', 
			   'panel'       => 'theme_option_panel' 
		)
	);
	
	$wp_customize->add_setting( 'minimal_portfolio_portfolio_content_title', 
		array(	'capability'        => 'edit_theme_options',
  				'default'           => $default['minimal_portfolio_portfolio_content_title'],
  				'sanitize_callback' => 'wp_kses_post',
		) 
	);
	$wp_customize->add_control( 'minimal_portfolio_portfolio_content_title', 
		array(	'type'         => 'textarea',
	  			'section'      => 'minimal_portfolio_portfolio_section', // // Add a default or your own section
	  			'label'        => esc_html__( 'Portfolio Content Title', 'minimal-portfolio' ),
	  			'description'  => __( 'This field allows html.', 'minimal-portfolio' ),
		) 
	);
	
	//blog option panel
	$wp_customize->add_panel( 'blog_option_panel', array( 'title' => esc_html__( 'Blog Options', 'minimal-portfolio' ), 'priority' => 200, 'capability' => 'edit_theme_options' ) );
	
	// blog post section
	$wp_customize->add_section( 'minimal_portfolio_blog_meta_section', 
		array( 'title'       => esc_html__( 'List Post Meta Items', 'minimal-portfolio' ),
			   'priority'    => 500, 
			   'capability'  => 'edit_theme_options', 
			   'panel'       => 'blog_option_panel' 
		)
	);
	
	$wp_customize->add_setting( 'minimal_portfolio_blog_post_align', 
		array(	'capability'        => 'edit_theme_options',
  				'default'           => $default['minimal_portfolio_blog_post_align'],  	
				'sanitize_callback' => 'minimal_portfolio_sanitize_radio',
		) 
	);
	$wp_customize->add_control( 'minimal_portfolio_blog_post_align', 
		array(
			'label'       => esc_html__( 'Default List Post Alignment', 'minimal-portfolio' ),
			'section'     => 'minimal_portfolio_blog_meta_section',
			'type'        => 'radio',
			'choices' => array(
				'left' => esc_html__( 'Left', 'minimal-portfolio' ),		
				'center' => esc_html__( 'Center', 'minimal-portfolio' ), 
				'right' => esc_html__( 'Right', 'minimal-portfolio' ),
			),
			'priority'    => 100		
		)
	);
	
	$wp_customize->add_setting( 'minimal_portfolio_blog_meta_date', 
		array(	'capability'        => 'edit_theme_options',
  				'default'           => $default['minimal_portfolio_blog_meta_date'],
  				'sanitize_callback' => 'minimal_portfolio_sanitize_checkbox',
		) 
	);
	$wp_customize->add_control( 'minimal_portfolio_blog_meta_date', 
		array(
			'label'       => esc_html__( 'Enable Date in Blog List', 'minimal-portfolio' ),
			'section'     => 'minimal_portfolio_blog_meta_section',
			'type'        => 'checkbox',
			'priority'    => 100		
		)
	);
	
	$wp_customize->add_setting( 'minimal_portfolio_blog_meta_author', 
		array(	'capability'        => 'edit_theme_options',
  				'default'           => $default['minimal_portfolio_blog_meta_author'],
  				'sanitize_callback' => 'minimal_portfolio_sanitize_checkbox',
		) 
	);
	$wp_customize->add_control( 'minimal_portfolio_blog_meta_author', 
		array(
			'label'       => esc_html__( 'Enable Author in Blog List', 'minimal-portfolio' ),
			'section'     => 'minimal_portfolio_blog_meta_section',
			'type'        => 'checkbox',
			'priority'    => 100		
		)
	);
	
	$wp_customize->add_setting( 'minimal_portfolio_blog_meta_category', 
		array(	'capability'        => 'edit_theme_options',
  				'default'           => $default['minimal_portfolio_blog_meta_category'],
  				'sanitize_callback' => 'minimal_portfolio_sanitize_checkbox',
		) 
	);
	$wp_customize->add_control( 'minimal_portfolio_blog_meta_category', 
		array(
			'label'       => esc_html__( 'Enable Category in Blog List', 'minimal-portfolio' ),
			'section'     => 'minimal_portfolio_blog_meta_section',
			'type'        => 'checkbox',
			'priority'    => 100		
		)
	);
	
	$wp_customize->add_setting( 'minimal_portfolio_blog_meta_comments', 
		array(	'capability'        => 'edit_theme_options',
  				'default'           => $default['minimal_portfolio_blog_meta_comments'],
  				'sanitize_callback' => 'minimal_portfolio_sanitize_checkbox',
		) 
	);
	$wp_customize->add_control( 'minimal_portfolio_blog_meta_comments', 
		array(
			'label'       => esc_html__( 'Enable Comments Count in Blog List', 'minimal-portfolio' ),
			'section'     => 'minimal_portfolio_blog_meta_section',
			'type'        => 'checkbox',
			'priority'    => 100		
		)
	);
	
	//Single Blog Meta Settings
	
	// blog post section
	$wp_customize->add_section( 'minimal_portfolio_single_blog_meta_section', 
		array( 'title'       => esc_html__( 'Single Post Meta Items', 'minimal-portfolio' ),
			   'priority'    => 500, 
			   'capability'  => 'edit_theme_options', 
			   'panel'       => 'blog_option_panel' 
		)
	);
	
	$wp_customize->add_setting( 'minimal_portfolio_single_blog_meta_date', 
		array(	'capability'        => 'edit_theme_options',
  				'default'           => $default['minimal_portfolio_single_blog_meta_date'],
  				'sanitize_callback' => 'minimal_portfolio_sanitize_checkbox',
		) 
	);
	$wp_customize->add_control( 'minimal_portfolio_single_blog_meta_date', 
		array(
			'label'       => esc_html__( 'Enable Date in Single Post', 'minimal-portfolio' ),
			'section'     => 'minimal_portfolio_single_blog_meta_section',
			'type'        => 'checkbox',
			'priority'    => 100		
		)
	);
	
	$wp_customize->add_setting( 'minimal_portfolio_single_blog_meta_author', 
		array(	'capability'        => 'edit_theme_options',
  				'default'           => $default['minimal_portfolio_single_blog_meta_author'],
  				'sanitize_callback' => 'minimal_portfolio_sanitize_checkbox',
		) 
	);
	$wp_customize->add_control( 'minimal_portfolio_single_blog_meta_author', 
		array(
			'label'       => esc_html__( 'Enable Author in Single Post', 'minimal-portfolio' ),
			'section'     => 'minimal_portfolio_single_blog_meta_section',
			'type'        => 'checkbox',
			'priority'    => 100		
		)
	);
	
	$wp_customize->add_setting( 'minimal_portfolio_single_blog_meta_category', 
		array(	'capability'        => 'edit_theme_options',
  				'default'           => $default['minimal_portfolio_single_blog_meta_category'],
  				'sanitize_callback' => 'minimal_portfolio_sanitize_checkbox',
		) 
	);
	$wp_customize->add_control( 'minimal_portfolio_single_blog_meta_category', 
		array(
			'label'       => esc_html__( 'Enable Category in Single Post', 'minimal-portfolio' ),
			'section'     => 'minimal_portfolio_single_blog_meta_section',
			'type'        => 'checkbox',
			'priority'    => 100		
		)
	);
	
	$wp_customize->add_setting( 'minimal_portfolio_single_blog_meta_comments', 
		array(	'capability'        => 'edit_theme_options',
  				'default'           => $default['minimal_portfolio_single_blog_meta_comments'],
  				'sanitize_callback' => 'minimal_portfolio_sanitize_checkbox',
		) 
	);
	$wp_customize->add_control( 'minimal_portfolio_single_blog_meta_comments', 
		array(
			'label'       => esc_html__( 'Enable Comments Count in Single Post', 'minimal-portfolio' ),
			'section'     => 'minimal_portfolio_single_blog_meta_section',
			'type'        => 'checkbox',
			'priority'    => 100		
		)
	);
	
	$wp_customize->add_setting( 'minimal_portfolio_single_blog_meta_tags', 
		array(	'capability'        => 'edit_theme_options',
  				'default'           => $default['minimal_portfolio_single_blog_meta_tags'],
  				'sanitize_callback' => 'minimal_portfolio_sanitize_checkbox',
		) 
	);
	$wp_customize->add_control( 'minimal_portfolio_single_blog_meta_tags', 
		array(
			'label'       => esc_html__( 'Enable Tags in Single Post', 'minimal-portfolio' ),
			'section'     => 'minimal_portfolio_single_blog_meta_section',
			'type'        => 'checkbox',
			'priority'    => 100		
		)
	);
	
	$wp_customize->add_setting( 'minimal_portfolio_single_blog_meta_share', 
		array(	'capability'        => 'edit_theme_options',
  				'default'           => $default['minimal_portfolio_single_blog_meta_share'],
  				'sanitize_callback' => 'minimal_portfolio_sanitize_checkbox',
		) 
	);
	$wp_customize->add_control( 'minimal_portfolio_single_blog_meta_share', 
		array(
			'label'       => esc_html__( 'Enable Share Option in Single Post', 'minimal-portfolio' ),
			'section'     => 'minimal_portfolio_single_blog_meta_section',
			'type'        => 'checkbox',
			'priority'    => 100		
		)
	);
	
	//back to top section
	$wp_customize->add_section( 'minimal_portfolio_backto_top_section', 
		array( 'title' => esc_html__( 'Back To Top Option', 'minimal-portfolio' ),
			   'priority' => 600, 
			   'capability' => 'edit_theme_options', 
			   'panel' => 'theme_option_panel' 
		)
	);
	
	// back to top setting.
	$wp_customize->add_setting( 'minimal_portfolio_backto_top_status',
		array(
			'default'           => $default['minimal_portfolio_backto_top_status'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'minimal_portfolio_sanitize_checkbox',
		)
	);
	// back to top control
	$wp_customize->add_control( 'minimal_portfolio_backto_top_status',
		array(
			'label'       => esc_html__( 'Enable Back To Top Button', 'minimal-portfolio' ),
			'section'     => 'minimal_portfolio_backto_top_section',
			'type'        => 'checkbox',
			'priority'    => 100		
		)
	);
	
	// copyright section
	$wp_customize->add_section( 'minimal_portfolio_copyright_section', 
		array( 'title'       => esc_html__( 'Copyright Option', 'minimal-portfolio' ),
			   'priority'    => 700, 
			   'capability'  => 'edit_theme_options', 
			   'panel'       => 'theme_option_panel' 
		)
	);
	
	$wp_customize->add_setting( 'minimal_portfolio_copyright_author', 
		array(	'capability'        => 'edit_theme_options',
  				'default'           => $default['minimal_portfolio_copyright_author'],
  				'sanitize_callback' => 'sanitize_text_field',
		) 
	);
	$wp_customize->add_control( 'minimal_portfolio_copyright_author', 
		array(	'type'         => 'text',
	  			'section'      => 'minimal_portfolio_copyright_section', // // Add a default or your own section
	  			'label'        => esc_html__( 'Copyright', 'minimal-portfolio' )
		) 
	);
	
}
add_action( 'customize_register', 'minimal_portfolio_customize_register' );
/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function minimal_portfolio_customize_partial_blogname() {
	bloginfo( 'name' );
}
/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function minimal_portfolio_customize_partial_blogdescription() {
	bloginfo( 'description' );
}
/**
 * @param bool $checked Whether the checkbox is checked.
 *
 * @return bool Whether the checkbox is checked.
 */
if( ! function_exists( 'minimal_portfolio_sanitize_checkbox' ) ):
	
	function minimal_portfolio_sanitize_checkbox( $checked ){
		return ( ( isset( $checked ) && true === $checked ) ? true : false );
	}
endif; 
if( ! function_exists( 'minimal_portfolio_sanitize_radio' ) ):
	function minimal_portfolio_sanitize_radio( $input ) {
		$valid = array(
			'left' => esc_html__( 'Left', 'minimal-portfolio' ),
			'center' => esc_html__( 'Center', 'minimal-portfolio' ), 
			'right' => esc_html__( 'Right', 'minimal-portfolio' ),
		);
	 
		if ( array_key_exists( $input, $valid ) ) {
			return $input;
		} else {
			return '';
		}
	}
endif;
if( ! function_exists( 'minimal_portfolio_default_theme_options' ) ):
	
	function minimal_portfolio_default_theme_options(){
		
		$defaults = array();
		
		$defaults['minimal_portfolio_post_slider_status'] = false;
		
		$defaults['minimal_portfolio_sticky_header_status'] = false;
		
		$defaults['minimal_portfolio_breadcrumb_status'] = false;
		
		$defaults['minimal_portfolio_blog_sidebar_sticky'] = false;
		
		$defaults['minimal_portfolio_single_blog_sidebar_sticky'] = false;
		
		$defaults['minimal_portfolio_archive_blog_sidebar_sticky'] = false;
		
		$defaults['minimal_portfolio_blog_post_align'] = 'left';
		
		$defaults['minimal_portfolio_blog_meta_date'] = true;
		
		$defaults['minimal_portfolio_blog_meta_author'] = true;
		
		$defaults['minimal_portfolio_blog_meta_category'] = true;
		
		$defaults['minimal_portfolio_blog_meta_comments'] = false;
		
		$defaults['minimal_portfolio_single_blog_meta_date'] = true;
		
		$defaults['minimal_portfolio_single_blog_meta_author'] = true;
		
		$defaults['minimal_portfolio_single_blog_meta_category'] = true;
		
		$defaults['minimal_portfolio_single_blog_meta_comments'] = false;
		
		$defaults['minimal_portfolio_single_blog_meta_tags'] = true;
		
		$defaults['minimal_portfolio_single_blog_meta_share'] = false;	
		
		
		$defaults['minimal_portfolio_backto_top_status'] = false;
		
		$defaults['minimal_portfolio_portfolio_content_title'] = wp_kses_post( '<h6>We Are </h6><h2>Minimal <span>Portfolio</span> Designers</h2>' );
		
		$defaults['minimal_portfolio_copyright_author'] = esc_html__( 'Copyright &copy; All rights reserved.', 'minimal-portfolio' );
		
		return $defaults;
	}
endif;
/**
 * Get theme option.
 * @param string $key Option key.
 * @return mixed Option value.
 */
	 
if ( ! function_exists( 'minimal_portfolio_get_option' ) ) :
	function minimal_portfolio_get_option( $key ) {
		if ( empty( $key ) ) {
			return;
		}
		$value 			= '';
		$default 		= minimal_portfolio_default_theme_options();
		$default_value 	= null;
		if ( is_array( $default ) && isset( $default[ $key ] ) ) {
			$default_value = $default[ $key ];
		}
		if ( null !== $default_value ) {
			$value = get_theme_mod( $key, $default_value );
		}else {
			$value = get_theme_mod( $key );
		}
		return $value;
	}
endif;
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function minimal_portfolio_customize_preview_js() {
	wp_enqueue_script( 'minimal-portfolio-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'minimal_portfolio_customize_preview_js' );