<?php
add_action( 'after_setup_theme', 'blankslate_setup' );
function blankslate_setup()
{
load_theme_textdomain( 'blankslate', get_template_directory() . '/languages' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' );
global $content_width;
if ( ! isset( $content_width ) ) $content_width = 640;
register_nav_menus(
array( 'main-menu' => __( 'Main Menu', 'blankslate' ) )
);
}
add_action( 'wp_enqueue_scripts', 'blankslate_load_scripts' );
function blankslate_load_scripts()
{
wp_enqueue_script( 'jquery' );
}
add_action( 'comment_form_before', 'blankslate_enqueue_comment_reply_script' );
function blankslate_enqueue_comment_reply_script()
{
if ( get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
}
add_filter( 'the_title', 'blankslate_title' );
function blankslate_title( $title ) {
if ( $title == '' ) {
return '&rarr;';
} else {
return $title;
}
}
add_filter( 'wp_title', 'blankslate_filter_wp_title' );
function blankslate_filter_wp_title( $title )
{
return $title . esc_attr( get_bloginfo( 'name' ) );
}
add_action( 'widgets_init', 'blankslate_widgets_init' );
function blankslate_widgets_init()
{
register_sidebar( array (
'name' => __( 'Sidebar Widget Area', 'blankslate' ),
'id' => 'primary-widget-area',
'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
'after_widget' => "</li>",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
}
function blankslate_custom_pings( $comment )
{
$GLOBALS['comment'] = $comment;
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
<?php 
}
add_filter( 'get_comments_number', 'blankslate_comments_number' );
function blankslate_comments_number( $count )
{
if ( !is_admin() ) {
global $id;
$comments_by_type = &separate_comments( get_comments( 'status=approve&post_id=' . $id ) );
return count( $comments_by_type['comment'] );
} else {
return $count;
}
}

/***************************************************************************************************/
function theme_settings_page(){
 ?>
        <div class="wrap">
        <h1>Theme Panel</h1>
        <form method="post" action="options.php" enctype="multipart/form-data">
            <?php
                settings_fields("section");
                do_settings_sections("theme-options");      
                submit_button(); 
            ?>          
        </form>
        </div>
    <?php
}
 
function add_theme_menu_item()
{
    add_menu_page("@emcode", "@emcode", "manage_options", "theme-panel", "theme_settings_page", null, 99);
}
 
add_action("admin_menu", "add_theme_menu_item");

add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'banner',
    array(
      'labels' => array(
        'name' => __( 'Banner' ),
        'singular_name' => __( 'Banner' )
      ),
      'public' => true,
      'has_archive' => true,
      'supports' => array('thumbnail','title'),
    )
  );
}


/****************************************************************************************************/
function display_twitter_element()
{
    ?>
        <input type="text" name="twitter_url" id="twitter_url" value="<?php echo get_option('twitter_url'); ?>" />
    <?php
}
 
function display_facebook_element()
{
    ?>
        <input type="text" name="facebook_url" id="facebook_url" value="<?php echo get_option('facebook_url'); ?>" />
    <?php
}
function display_youtube_element()
{
    ?>
        <input type="text" name="youtube_url" id="youtube_url" value="<?php echo get_option('youtube_url'); ?>" />
    <?php
}

function logo_display()
{
    if(get_option('logo')){
            echo '<img src="'.get_option('logo').'" width="200px">';
        }  
    ?>
        <br>
        <input type="file" id="logo" name="logo" value="<?php echo get_option('logo'); ?>"/> 
        <?php  
}
 
function handle_logo_upload()
{   
    if(!empty($_FILES["logo"]["tmp_name"]))
    {
        $urls = wp_handle_upload($_FILES["logo"], array('test_form' => FALSE));
        $temp = $urls["url"];
        return $temp;   
    }      
    return get_option('logo');

}

function display_theme_panel_fields()
{
    add_settings_section("section", "All Settings", null, "theme-options");
     
    add_settings_field("twitter_url", "Twitter", "display_twitter_element", "theme-options", "section");
    add_settings_field("facebook_url", "Facebook", "display_facebook_element", "theme-options", "section");
    add_settings_field("youtube_url", "Youtube", "display_youtube_element", "theme-options", "section");
    add_settings_field("logo", "Logo", "logo_display", "theme-options", "section"); 
    
    
    register_setting("section", "twitter_url");
    register_setting("section", "facebook_url");
    register_setting("section", "youtube_url");
    register_setting("section", "logo", "handle_logo_upload");    
}
 
add_action("admin_init", "display_theme_panel_fields");

/***************************************************************************************************************/


add_action( 'init', 'enable_category_taxonomy_for_pages', 500 );

function enable_category_taxonomy_for_pages() {
    register_taxonomy_for_object_type('category','page');
}


/**************************ThemeOptions*****************************************/

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_opciones-de-sitio',
		'title' => 'Opciones de sitio',
		'fields' => array (
			array (
				'key' => 'field_563d5b8f83291',
				'label' => 'Logo',
				'name' => 'logo',
				'type' => 'image',
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_563d5b9c83292',
				'label' => 'Dirección',
				'name' => 'direccion',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'html',
			),
			array (
				'key' => 'field_563d5bc883293',
				'label' => 'Teléfono',
				'name' => 'telefono',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_563d5f1cc106c',
				'label' => 'Correo',
				'name' => 'correo',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_563d5b1a755a4',
				'label' => 'Redes sociales',
				'name' => 'social',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_563d5b30755a5',
						'label' => 'imagen',
						'name' => 'imagen',
						'type' => 'image',
						'column_width' => '',
						'save_format' => 'url',
						'preview_size' => 'thumbnail',
						'library' => 'all',
					),
					array (
						'key' => 'field_563d5b47755a6',
						'label' => 'url',
						'name' => 'url',
						'type' => 'text',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'row',
				'button_label' => 'Agregar red',
			),
			array (
				'key' => 'field_563d6307a63a1',
				'label' => 'Banner',
				'name' => 'banner',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_563d6319a63a2',
						'label' => 'Imagen',
						'name' => 'imagen',
						'type' => 'image',
						'column_width' => '',
						'save_format' => 'url',
						'preview_size' => 'thumbnail',
						'library' => 'all',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Add Row',
			),
			array (
				'key' => 'field_563ef7e49b43a',
				'label' => 'Banner 2',
				'name' => 'banner_2',
				'type' => 'image',
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'acf-options',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}