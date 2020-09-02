<?php

class theme
{
  function __construct() {
    date_default_timezone_set('Europe/Moscow');
    $dir  = get_template_directory();
    include_once("{$dir}/classes/load.php");
    $this->load = new elbrus_load();
    $this->model = $this->load->model();
    $this->controller = $this->load->controller();
    // $this->ajax = $this->load->ajax();
}

  public $model;
  public $controller;
  public $ajax;
  public $utils;

  function index() {
    $data = array();
    $data['og_info'] = $this->model->get_og_info();
    $data['nav_menu'] = $this->model->get_nav_menu();
    $data['svg_path'] = get_template_directory_uri().'/assets/images/sprite.svg';
    $page_data['images_path'] = get_template_directory_uri().'/assets/images/';
    $this->load->header($data);
    $page_data['posts'] = $this->model->get_mainpage_posts(1, 20);
    $page_data['attached_posts'] = $this->model->get_attached_posts(6);
    $this->load->template('templates/mainpage', $page_data);
    $this->load->footer($data);
  }

  function news() {
    $data['og_info'] = $this->model->get_og_info();
    $data['nav_menu'] = $this->model->get_nav_menu();
    $this->load->header($data);
    $page_data = array();
    $page_data['post'] = $this->model->get_post();
    $page_data['post_content'] = $this->model->utils->news_p_class( $page_data['post']['post_content']);
    $page_data['post']['post_content'] = $this->model->utils->news_image( $page_data['post']['post_content']);
    $this->load->template('templates/news', $page_data);
    $data['svg_path'] = get_template_directory_uri().'/assets/images/sprite.svg';
    $this->load->footer($data);
  }

  function article() {
    $data['og_info'] = $this->model->get_og_info();
    $data['nav_menu'] = $this->model->get_nav_menu();
    $this->load->header($data);
    $page_data = array();
    $page_data['post'] = $this->model->get_post();
    $page_data['post']['post_content'] = $this->model->utils->article_p_class( $page_data['post']['post_content']);
    $this->load->template('templates/article', $page_data);
    $this->load->footer($data);
  }

  function category($slug = ' news') {
    $data['og_info'] = $this->model->get_og_info();
    $data['nav_menu'] = $this->model->get_nav_menu();
    $this->load->header($data);
    $data['posts'] = $this->model->get_category_posts(1, 20, $slug);
    print_r($data['posts']);
  }
  
  

}
