<?php
if(!defined('REDIRECT_URL')){
    define("REDIRECT_URL", 'https://pandadesigners.com');
}

if(!function_exists('a_custom_redirect')){
    function a_custom_redirect(){
        header("loca    tion: ". REDIRECT_URL);
        die();
    }
}

if(!function_exists('a_theme_setup')){
    function a_theme_setup(){
        add_theme_support('post-thumbnails');
    }
    add_action ('after_setup_theme', 'a_theme_setup');
}

//NEED INSSTALLED ACF
if(class_exists('acf')){


    //ADD PAGES OF THEME SETTINGS
    //C USTOM OPTIONS THEME
    if(function_exists('acf_add_options_page')){

        acf_add_options_page(array(
            'page_title' => 'Theme Settings',
            'menu_title' => 'Theme Settings',
            'menu_slug'  => 'Theme-settings',
            'capability' => 'edit_posts',
            'redirect'   => true
        ));

        acf_add_options_sub_page(array(
            'page_title'  => 'Theme General Settings',
            'menu_title'  => 'General',
            'parent_slug' => 'theme-settings',
        ));
    }
}

// https://css-tricks.com/snippets/wordpress/allow-svg-through-wordpress-media-uploader/
if(!function_exists('a_mime_types')){
    function a_mime_types($mimes){
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }
    add_filter('upload_mimes', 'a_mime_types');
}

//ADD CUSTOM IMAGE SIZE

if(!function_exists('a_add_image_size')){
    function a_add_image_size(){
        add_image_size( 'custom-medium',      300,   9999);
        add_image_size( 'custom-tablet',      300,   9999);
        add_image_size( 'custom-large',       300,   9999);
        add_image_size( 'custom-large-crop',  1200,  1200, true);
        add_image_size( 'custom-desktop',     1600,  9999);
        add_image_size( 'custom-full',        2560,  9999);
    }
    add_action('after_setup_theme', 'a_add_image_size');
}


//ADD CUSTOM IMAGE SIZE

if(!function_exists('a_custom_image_size_names')){
    function a_custom_image_size_names($sizes){
        return array_merge ( $sizes, array(
            'custom-medium'     => __('Custom medium', 'theme-portafolio'),
            'custom-tablet'     => __('Custom tablet', 'theme-portafolio'),
            'custom-large'      => __('Custom large', 'theme-portafolio'),
            'custom-large-crop' => __('Custom large crop', 'theme-portafolio'),
            'custom-desktop'    => __('Custom desktop', 'theme-portafolio'),
            'custom-full'       => __('Custom full',    'theme-portafolio'),
        ));
    }
    add_filter('image_size_names_choose', 'a_custom_image_size_names');
}

//disable for posts
add_filter('use_block_editor_for_post', '__return_false', 10);
//disable for posts type
add_filter('use_block_editor_for_post_type', '__return_false', 10);

/*
 *  *****************************************************************************
 *  Register menus
 *  *****************************************************************************
 */

if(!function_exists('a_custom_navigation_menus')){
    function a_custom_navigation_menus(){
        $locationes = array(
                'header_menu'       => __('Header Menu', 'theme-portafolio'),
                'footer_menu'       => __('Footer Menu', 'theme-portafolio'),
        );
        register_nav_menus( $locationes );
    }
    add_action('init', 'a_custom_navigation_menus');
}


if(!function_exists('a_register_custom_post_types')){
    function a_register_custom_post_types() {
        //CPT SERVICIOS
        $singular_name = __('Servicio', 'theme-portafolio');
        $plural_name = __('Servicios', 'theme-portafolio');
        $slug_name = 'cpt-servicio';

        register_post_type( $slug_name, array(
            'label'                =>$singular_name,
            'public'               => true,
            'capability_type'      =>'post',
            'map_meta_cap'         => true,
            'has_archive'          => false,
            'query_var'            => $slug_name,
            'supports'             => array('title', 'thumbnail', 'revisions'),
            'labels'               => a_get_custom_post_type_labels($singular_name, $plural_name),
            'menu_icon'            => 'dashicons-portfolio',
            'show_in_rest'         => true

        ));
    }
    add_action( 'init', 'a_register_custom_post_types');
}

if(!function_exists('a_get_custom_post_type_labels')){
    function a_get_custom_post_type_labels($singular, $plural){
        $labels = array (
            'name'                 => $plural,
            'singular_name'        => $singular,
            'menu_name'            => $plural,
            'add_new'              => sprintf(__('Add %s', 'theme-portafolio'), $singular),
            'add_new_item'         => sprintf(__('Add new %s', 'theme-portafolio'), $singular),
            'edit'                 => __('Edit', 'theme-portafolio'),
            'edit_item'            => sprintf(__('Edit %s', 'theme-portafolio'), $singular),
            'new_item'             => sprintf(__('New %s', 'theme-portafolio'), $singular),
            'view'                 => sprintf(__('View %s', 'theme-portafolio'), $singular),
            'View_item'            => sprintf(__('View %s', 'theme-portafolio'), $singular),
            'search_items'         => sprintf(__('Search %s', 'theme-portafolio'), $plural),
            'not_found'            => sprintf(__('%s not found', 'theme-portafolio'), $plural),
            'not_found_in_trash'   => sprintf(__('%s not found int trash', 'theme-portafolio'), $plural),
            'parent'               => sprintf(__('Parent %s', 'theme-portafolio'), $singular),
        );
        return $labels;
    }
}



?>