<?php

use function PHPSTORM_META\type;

class elbrus_rest {
  function __construct() {
    include_once('load.php');
    $this->load = new elbrus_load();
    $this->model = $this->load->model();
    $this->init();
  }
  
  public $load;
  public $model;

  private function init() {
    add_action( 'rest_api_init', array($this, 'prefix_register_news_routes'));
  }

  //getters
  function eb_get_news(WP_REST_Request $request) {
    $paged = (int)$request->get_param('page');
    // $count = ($paged === 1) ? 20 : 10;
    $posts = $this->model->get_mainpage_posts($paged, 20);
    return $posts;
  }


  function eb_get_attached_posts(WP_REST_Request $request) {
    $paged = (int) $request->get_param('page');
    $posts = $this->model->get_attached_posts(4);
    return $posts;
  }


  function eb_get_last_posts(WP_REST_Request $request) {
    $paged = (int) $request->get_param('page');
    $posts = $this->model->get_mainpage_posts($paged, 10, false);
    return $posts;
  }



  function eb_get_category_posts(WP_REST_Request $request) {
    $paged = (int) $request->get_param('page');
    $slug = (string) $request->get_param('slug');
    // $count = ($paged === 1) ? 20 : 10;
    $posts = $this->model->get_category_posts($paged, 20, $slug);
    return $posts;
  }


  function eb_get_post(WP_REST_Request $request) {
    $post_slug = $request->get_param('slug');
    $post = $this->model->get_post_by_slug($post_slug);
    return $post;
  }

  function eb_set_postview(WP_REST_Request $request) {
    $meta_key       = 'views'; 
    $id = $request->get_param('id');
    $post_views = false;
    if ($id!==null) {
      $post_views = (int) get_field('views', $id);
      update_field('views', $post_views+1, $id ); 
      // add_post_meta($id, $meta_key, 1, true);
    }
    return $post_views; 
  }

  function eb_get_search_posts(WP_REST_Request $request) {
    $tags = array();
    $authors = array();
    $words = array();
    $s='';
    $page = $request->get_param('page');   
    if ($request->get_param('t') !== null) {
      $tags = $request->get_param('t');
    }  
    if ($request->get_param('w') !== null) {
      $words = $request->get_param('w');
      if (!empty($words))
        $s = implode(' ', $words);
    } 
    if ($request->get_param('a') !== null) {
      $authors = $request->get_param('a');
    }  
    $posts = $this->model->get_posts_by_search_string($s, $page, 20, $tags, $authors);
    return $posts;
  }


  function eb_rest_get_menu(WP_REST_Request $request) {
    $menu = $this->model->get_nav_menu();
    return $menu;
  }

  //registring routes

  function prefix_register_news_routes() {
      //all unattached posts
      register_rest_route( 'elbruspress/v1', '/posts/(?P<page>\d+)', array(
          'methods'  => WP_REST_Server::READABLE,
          'page' => array(
            'id' => array(
              'type'    => 'integer', 
              'default' => 1,        
            )
          ),
          'callback' => array($this, 'eb_get_news'),
      ));

      //attached posts
      register_rest_route( 'elbruspress/v1', '/attached/(?P<page>\d+)', array(
        'methods'  => WP_REST_Server::READABLE,
        'args' => array(
          'page' => array(
            'type'    => 'integer', 
            'default' => 1,        
          )
          ),
        'callback' => array($this, 'eb_get_attached_posts'),
    ));

       //last posts
       register_rest_route( 'elbruspress/v1', '/last/(?P<page>\d+)', array(
        'methods'  => WP_REST_Server::READABLE,
        'args' => array(
          'page' => array(
            'type'    => 'integer', 
            'default' => 1,        
          )
          ),
        'callback' => array($this, 'eb_get_last_posts'),
    ));

       //category posts
       register_rest_route( 'elbruspress/v1', '/category/(?P<slug>[a-zA-Z0-9-]+)/(?P<page>\d+)', array(
        'methods'  => WP_REST_Server::READABLE,
        'args' => array(
          'slug' => array(
            'type'    => 'string', 
            'default' => 'news',        
          ),
          'page'=> array(
            'type'    => 'integer', 
            'default' => 1
          )
        ),
        'callback' => array($this, 'eb_get_category_posts'),
    ));

     //search
     register_rest_route( 'elbruspress/v1', '/search/(?P<s>[a-zA-Z0-9-]+)', array(
      'methods'  => WP_REST_Server::READABLE,
      'args' => array(
        's' => array(
          'type' => 'string',
          'required' => true,
          'validate_callback' => function($param, $request, $key) { return ($param === 's'); }
        ),
        't' => array(
          'type' => 'array',
          'required' => false,
          'items' => array('type' => 'string')
        ),
        'a' => array(
          'type' => 'array',
          'required' =>  false,
          'items' => array('type' => 'string')
        ),
        'w' => array(
          'type' => 'array',
          'required' =>  false,
          'items' => array('type' => 'string')
        ),
        'page'=> array(
          'type'    => 'integer', 
          'default' => 1,
          'required' => true
        )
      ),
      'callback' => array($this, 'eb_get_search_posts'),
  ));


      //menu
      register_rest_route( 'elbruspress/v1', '/menu/', array(
        'methods'  => WP_REST_Server::READABLE,
        'callback' => array($this, 'eb_rest_get_menu'),
    ));

      //single post
      register_rest_route( 'elbruspress/v1', '/single/(?P<slug>[a-zA-Z0-9-]+)', array(
        'methods'  => WP_REST_Server::READABLE,
        'args' => array(
          'slug' => array(
            'type' => 'string',
            'required' => true        
          )
          ),
        'callback' => array($this, 'eb_get_post'),
    ));

    register_rest_route( 'elbruspress/v1', '/postview/(?P<id>\d+)', array(
      'methods'  => WP_REST_Server::CREATABLE,
      'args' => array(
        'id' => array(
          'type' => 'integer',
          'required' => true        
          )
        ),
    'callback' => array($this, 'eb_set_postview')
  ));
  

  register_rest_route( 'elbruspress/v1', '/adv/(?P<type>\d+)', array(
    'methods'  => WP_REST_Server::READABLE,
    'args' => array(
      'type' => array(
        'type' => 'integer',
        'required' => true        
        )
      ),
    'callback' => array($this, 'eb_get_adv')
  ));

  }

  public function eb_get_adv(WP_REST_Request $request) {
    $type = $request->get_param('type');
    if ($type === null)
      return false;
    $adv = $this->model->get_adv_by_type($type);
    return $adv;
  }


}
?>