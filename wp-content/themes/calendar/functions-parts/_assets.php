<?php 
/*
 * Подключение стилей и скриптов
 * */

function my_assets()
{
    wp_deregister_script('jquery-core');
    wp_register_script('jquery-core', get_stylesheet_directory_uri() . '/build/js/jquery.min.js');
    wp_enqueue_script('jquery');

    wp_enqueue_style('main-style', get_template_directory_uri() . '/build/css/main.css');


    
    if (is_front_page()) {
      wp_enqueue_script('fullcalendar', 'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js',  array('jquery'), '1.0', true);
    }

    $page_template =  mb_substr(get_page_template_slug(), 0, -4); // get template file name and cut last 4 symbols
    $css_file_path = get_template_directory_uri() . '/build/css/pages/' . $page_template . '.css';
    $js_file_path = get_template_directory_uri() . '/build/js/pages/' . $page_template . '.js';
    $media = '(min-width:1024px)';

    $is_singular = is_singular('news') || is_singular('products') || is_singular('tips');

    if (!$is_singular && !is_404() && !is_search()) {
      wp_enqueue_style( $page_template, $css_file_path );
      wp_enqueue_script($page_template, $js_file_path,  array('jquery'), '1.0', true);
    }


  
}

add_action('wp_enqueue_scripts', 'my_assets');
