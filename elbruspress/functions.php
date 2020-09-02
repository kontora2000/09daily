<?php


 /*
  ////////////////////////////////////////////////////////////////////////////////////
  _____THEME SUPPORT_________________________________________________________________
  ////////////////////////////////////////////////////////////////////////////////////
  */
  
  include(get_template_directory().'/classes/rest.php');
  $rest =  new elbrus_rest();



  function elbrus_theme_support() {
    add_theme_support( 'post-thumbnails', array( 'post' ) );
    add_theme_support( 'menus' );
    // Set post thumbnail size.
    set_post_thumbnail_size( 1200, 9999 );
    add_theme_support( 'title-tag' );
    show_admin_bar(false);

  }
  add_action( 'after_setup_theme', 'elbrus_theme_support' );

    /**
  * Регистрирование стилей
  */

  function elbrus_register_styles() {
    wp_enqueue_style( 'my-style', get_template_directory_uri(). '/style.css', '1.0.0' );
  }
  add_action( 'wp_enqueue_scripts', 'elbrus_register_styles' );


  /**
  * Регистрирование скриптов
  */
  function elbrus_register_scripts() { 
    wp_enqueue_script( 'elbrus-vue', 'https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js', array(), '2.6.11', false );
    wp_enqueue_script( 'elbrus-axios', 'https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js', array(), '0.19.2', false );
    wp_enqueue_script( 'elbrus-common', get_template_directory_uri().'/assets/js/common.js', array(), '1.0.0', false );

  }
  
  add_action( 'wp_enqueue_scripts', 'elbrus_register_scripts' );





  //add_filter( 'allowed_block_types', 'denresp_allowed_block_types', 10, 2 );


  function elbruss_allowed_block_types( $allowed_blocks, $post ) {

    $allowed_blocks = array(
      'core/paragraph',
      'core/heading',
      'core/list',
      'core/table',
      'core/preformatted',
      'core/freeform',
      'core-embed/instagram',
      'core-embed/youtube',
      'core-embed/instagram',
      'core-embed/twitter',
      'block-lab/block-221',
      'lazyblock/post-image',
      'lazyblock/post-gallery',
      'lazyblock/post-quote',
      'lazyblock/post-file',
      'lazyblock/secondheader',
      'lazyblock/subtitle'
      
    );
    
    return $allowed_blocks;
  }

  function elbrusspress_disable_metaboxes () {
    // remove_meta_box('authordiv', 'custom_post_type', 'normal' );
    // // remove_meta_box('commentstatusdiv', 'post', 'side' );
    // // remove_meta_box('commentsdiv', 'post', 'side' );
    // remove_meta_box('postexcerpt', 'post', 'normal' );
    remove_post_type_support( 'post', 'excerpt' );
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'post', 'author' );
    remove_meta_box('commentstatusdiv', 'post', 'side' );
    remove_meta_box('commentsdiv', 'post', 'side' );

  }

  add_action( 'init', 'create_author_taxonomy' );
  add_action( 'admin_init', 'elbrusspress_disable_metaboxes' );

  function create_author_taxonomy(){
    register_taxonomy( 'authors', [ 'post' ], [ 
      'label'                 => '', // определяется параметром $labels->name
      'labels'                => [
        'name'              => 'Авторы',
        'singular_name'     => 'Автор',
        'search_items'      => 'Искать автора',
        'all_items'         => 'Все авторы',
        'view_item '        => 'Просмотр автора',
        'parent_item'       => '',
        'parent_item_colon' => ':',
        'edit_item'         => 'Редактировать данные автора',
        'update_item'       => 'Обновить данные автора',
        'add_new_item'      => 'Добавить нового автора',
        'new_item_name'     => 'Имя нового автора',
        'menu_name'         => 'Авторы',
      ],
      'description'           => '', // описание таксономии
      'public'                => true,
      'hierarchical'          => false,
      
      'rewrite'               => true,
      'query_var'             => true, 
      'capabilities'          => array(),
      'meta_box_cb'           => null, 
      'show_admin_column'     => true, 
      'show_in_rest'          => null, 
      'rest_base'             => null, ]
    );
  }

//ajax

  function eb_add_postview() {
    $meta_key       = 'views'; 
    $exclude_bots   = false;            
    $id = $_GET['post_id'];
    echo $id;
    $post_views = (int) get_post_meta($id,$meta_key, true);
      if( !update_post_meta($id, $meta_key, ($post_views+1)) ) 
      add_post_meta($id, $meta_key, 1, true);
    die();
  }




?>