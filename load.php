<?php
class elbrus_load
{
  function __construct()
  {
    $this->dir  = get_template_directory();
  }
  
  private $dir;
  
  
  public function template($path, $data = array())
  {
    if (!is_array($data))
    return;
    if (!is_string($path) || trim($path) === '')
    return;
    $file = "{$this->dir}/{$path}.php";
    extract($data);
    ob_start();
    require($file);
    return;
  }

  

  public function header($data = null) {
    $file = "{$this->dir}/header.php";
    if (is_array($data))
      extract($data);
    ob_start();
    require($file);
  }

  public function footer($data = null) {
    $file = "{$this->dir}/footer.php";
    if (is_array($data))
      extract($data);
    ob_start();
    require($file);
  }
  


  public function script($path, $v= '1.0.0') {
    if (strpos($path, 'https:')<= 0) 
    $path = get_template_directory_uri().'/assets/js/'.$path;
    wp_enqueue_script( 'elbruss-'.str_replace($path, '.js', ''), $path, $v  );
  }
  
  public function style($path, $v= '1.0.0') {
    if (strpos($path, 'https:')<= 0) 
      $path = get_template_directory_uri().'/assets/css/'.$path;
    wp_enqueue_style( 'ebrus-style-'.str_replace($path, '.css', ''), $path );
  }
  
  
  public function model() {
    include_once('model.php');
    $model =  new elbrus_model();
    return $model;
  }
  
  public function utils() {
    include_once('utils.php');
    return new elbrus_utils(); 
  }
  
  // public function ajax() {
  //   include_once('rest.php'); 
  //   return new elbrus_rest();
  // }
  
  public function controller() {
    include_once('controller.php'); 
    return new elbrus_controller();
  }
}