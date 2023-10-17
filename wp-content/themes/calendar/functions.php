<?php
// Functions parts
include_once 'functions-parts/_assets.php';
include_once 'functions-parts/_post-types-registration.php';
include_once 'functions-parts/_taxonomies-registration.php';
include_once 'functions-parts/_ajax.php';



/*
 * REMOVE EMOJI ICONS
 * */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');


add_action( 'admin_menu', 'remove_menu_pages' );

function remove_menu_pages() {
    remove_menu_page('edit.php'); 
}


/*
 * Удаление "мусора"
 * */
remove_action('wp_head', 'feed_links_extra', 3); // убирает ссылки на rss категорий
remove_action('wp_head', 'feed_links', 2); // минус ссылки на основной rss и комментарии
remove_action('wp_head', 'rsd_link');  // сервис Really Simple Discovery
remove_action('wp_head', 'wlwmanifest_link'); // Windows Live Writer
remove_action('wp_head', 'wp_generator');  // скрыть версию wordpress
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('template_redirect', 'rest_output_link_header', 11, 0);


/*
 * Удаление пунктов меню (убрать комментарий для нужного пункта)
 * */
function remove_menus()
{
//    remove_menu_page('index.php');                  //Консоль
//    remove_menu_page('edit.php');                   //Записи
//    remove_menu_page('upload.php');                 //Медиафайлы
//    remove_menu_page('edit.php?post_type=page');    //Страницы
//    remove_menu_page('edit-comments.php');          //Комментарии
//    remove_menu_page('themes.php');                 //Внешний вид
//    remove_menu_page('plugins.php');                //Плагины
//    remove_menu_page('users.php');                  //Пользователи
//    remove_menu_page('tools.php');                  //Инструменты
//    remove_menu_page('options-general.php');        //Настройки

//    remove_menu_page('admin.php?page=pmxi-admin-import');
//    remove_menu_page('edit.php?post_type=acf-field-group');
//        remove_menu_page( 'admin.php?page=Wordfence' );
//        remove_menu_page( 'admin.php?page=pmxi-admin-import' );
//        remove_menu_page( 'admin.php?page=wpseo_dashboard' );
}
add_action('admin_menu', 'remove_menus');

/*
 * Страница опций
 * */
add_action('acf/init', 'my_acf_op_init');
function my_acf_op_init() {

    // Check function exists.
    if( function_exists('acf_add_options_sub_page') ) {

        // Add parent.
        $parent = acf_add_options_page(array(
            'page_title'  => 'Налаштування теми',
            'menu_title'  => 'Налаштування теми',
            'redirect'    => false,
            'capability'  => 'activate_plugins'
        ));


        $child = acf_add_options_sub_page(array(
            'page_title'  => 'Конструктор',
            'menu_title'  => 'Конструктор',
            'parent_slug' => $parent['menu_slug'],
        ));
    }
}

/*
 * Поддержка SVG
 * */
function my_myme_types($mime_types)
{
    $mime_types['svg'] = 'image/svg+xml';
    return $mime_types;
}
add_filter('upload_mimes', 'my_myme_types', 1, 1);


/*
 * Add Menu Wp
 * */
register_nav_menus(
    array(
        'Header menu' => 'Header menu',
    )
);


add_theme_support('menus');
add_theme_support( 'post-thumbnails' );
add_image_size( 'full_hd', 1920, 1080 );


