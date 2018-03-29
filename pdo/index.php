<?php
require 'classes/Database.php';
$database = new Database;

//print_r($rows);
$post = @filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if (@$post['submit']==true) {
  $title=$post['title'];
  $body = $post['body'];
  $q = "INSERT INTO posts (title , body) VALUES (:title, :body)";

  //$database->bind(":title",$title);
  //$database->bind(":body",$body);
  $bind = array(":title"=>$title, ":body"=>$body);
  $database->execute($q , $bind);
  echo $database->lastId();
}
$q1 = "select * from posts ";
//$database->bind(":id",2);
$rows = $database->resultset($q1);
print_r($rows);

 ?>
<h1>ADD POST</h1>

<form  action="<?php $_SERVER['PHP_SELF'];?>" method="post">

  <h3>Title</h3><input type="text" name="title" value="">
  <h3>Post</h3>
  <textarea name="body" rows="8" cols="80"></textarea><br><br>
  <input type="submit" name="submit" value="POST">
</form>
