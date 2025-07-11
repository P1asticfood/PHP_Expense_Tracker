<?php 

session_start();
ob_start();

function redirect($uri){
    $uri = trim($uri, '/');
    header("Location: ".base_url($uri));
    exit();
}
function base_url($uri=""){
    $uri = trim($uri, '/');
      $http_s=$_SERVER['REQUEST_SCHEME'];
      $serverName=$_SERVER['SERVER_NAME'];
     return $http_s.'://'.$serverName.'/expense_tracker/'.$uri;
     
}

function messages(){
  $output='';
  if(isset($_SESSION['success'])){
    $output .= '<div class="alert alert-success">'.$_SESSION['success'].'</div>';
    unset($_SESSION['success']);
  }
  if(isset($_SESSION['error'])){
    $output .= '<div class="alert alert-danger">'.$_SESSION['error'].'</div>';
    unset($_SESSION['error']);
  }
  return $output;

}

