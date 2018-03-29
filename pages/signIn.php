<?php
      require("../pdo/classes/Database.php");
      $database = new Database;
      $response = '';
      $email = $_POST['email'];
      $pass = $_POST['password'];

      $email = filter_var($email, FILTER_SANITIZE_EMAIL);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $response = $response.'0';
      }else{
              $pass = sha1($pass);
              $sql = "SELECT * FROM `user` WHERE email = :email AND password = :pass";
              $bind = array(":email"=>$email, ":pass"=>$pass);
              $rows = $database->resultset($sql,$bind);
              if(count($rows)>0){
                  $dataObj = $rows[0];
                  session_start();
                  $_SESSION['logged_in'] = 1;
                  $_SESSION['data'] = $dataObj;
                  $response = $response.'2';
              } else {
                  $response = $response.'1';
              }
    }
      echo $response;

?>
