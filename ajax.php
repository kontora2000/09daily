<?php
  class elbrus_ajax {
    public function ajax_error($error_msg='Ошибка') {
      echo json_encode(['error'=>$error_msg]);
      die();
    }

    public function ajax_success($success_msg) {
      echo json_encode(['success'=>$success_msg]);
      die();
    }

    public function ajax_response($array) {
      echo json_encode($array);
      die();
    }

  }
?>