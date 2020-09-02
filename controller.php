<?php 
  class elbrus_controller {
    function __construct(){
      return ;
    }
  
  
    public function is_mobile() {
      return wp_is_mobile();
    }
    
    public function is_tablet() {
      return wp_is_mobile();
    }

    public function get_browser() {
      return get_browser();
    }
  }
?>
