<?php
  session_start();
  include "../lib/lib.php";
  require '../pdo/classes/Database.php';
  $database = new Database;
  $JSON_responce = '{';
  
  if (isset($_SESSION['logged_in'])){

    //New comment handeler
    if (isset($_POST['comment']) && $_POST['comment'] != "" && $_POST['video_id']!="") {
      $user_id = $_SESSION['data']['id'];
      $item_q = "INSERT INTO item (`user_id`) VALUE (:user_id)";
      $bind = array(':user_id' => $user_id );
      $database->execute($item_q,$bind);

      $item_id = $database->lastId();

      $video_id= $_POST['video_id'];
      $content = $_POST['comment'];

      $comment_q = "INSERT INTO comment (`item_id`,`user_id`,`video_id`,`content`) VALUES (:item_id, :user_id , :video_id, :content)";
      $bind  = array(':item_id' => $item_id ,':user_id' => $user_id,':video_id' => $video_id,':content' => $content );
      $database->execute($comment_q , $bind);

      $JSON_responce .= '"success":1,"message":"comment successful","item_id":'.$item_id.'}';
    }
    //end of New comment handeler

    //sentiment Handler
    else if (isset($_POST['sentiment'])) {
      $item_id = $_POST['item_id'];
      $user_id = $_SESSION['data']['id'];
      $value = $_POST['value'];

      $sentiment_q = "SELECT * FROM sentiment WHERE item_id=:item_id && user_id = :user_id";
      $bind  = array(':item_id' => $item_id ,':user_id' => $user_id);
      $row = $database->resultset($sentiment_q,$bind);

      if (!empty($row)) {
        if ($row[0]['value'] == $value) {
          $JSON_responce .= '"success":0,"message":"same responce is not valid"}';
          echo $JSON_responce;
          die();
        }
        $sentiment_q_update = "UPDATE sentiment SET `value` = :value WHERE  item_id=:item_id && user_id = :user_id";
        $bind  = array( ':value' => $value ,':item_id' => $item_id ,':user_id' => $user_id );
        $database->execute($sentiment_q_update , $bind);
        if($database->execute($sentiment_q_update , $bind)){
            $JSON_responce .= '"success":1,';
          }
          else {
            $JSON_responce .= '"success":0,"message":"Something went worong. Please try again later."}';
            echo $JSON_responce;
            die();
          }
      }
      else{
        $sentiment_q_insert = "INSERT INTO sentiment(`item_id` , `user_id` ,`value`) VALUES (:item_id,:user_id,:value)";
        $bind  = array(':item_id' => $item_id ,':user_id' => $user_id , ':value' => $value);
        if($database->execute($sentiment_q_insert , $bind)){
            $JSON_responce .= '"success":1,';
        }
        else {
          $JSON_responce .= '"success":0,"message":"Something went worong. Please try again later."}';
          echo $JSON_responce;
          die();
        }
      }
      $sentiment_q = "SELECT (SELECT count(value) FROM sentiment WHERE item_id = :item_id AND value = 1) as likes , (SELECT count(value) FROM sentiment WHERE item_id = :item_id AND value = 0) as dislikes";
      $bind  = array(':item_id' => $item_id ,':item_id' => $item_id);
      $row = $database->resultset($sentiment_q,$bind)[0];
      if ($value) {
        $JSON_responce .= '"message":"liked","likes":'.$row['likes'].',"dislikes":'.$row['dislikes'].'}';
      }
      else {
        $JSON_responce .= '"message":"disliked","likes":'.$row['likes'].',"dislikes":'.$row['dislikes'].'}';
      }
    }
    //end of sentiment Handler

    else{
      $JSON_responce .= '"success":0,"message":"Something went wrong with POST data"}';
    }
  } else {
    $JSON_responce .= '"success":0,"message":"User not authorized to access to comment"}';
  }

//Comment Loader
  if (isset($_POST['load_comment']) && $_POST['video_id']!="") {
    if (isset($_SESSION['logged_in'])) {
      $comment_q = "SELECT c.* , u.*, c.id as com_id, c.date_time as date_commented,(SELECT count(value) FROM sentiment WHERE item_id = c.item_id AND value = 1) as likes , (SELECT count(value) FROM sentiment WHERE item_id = c.item_id AND value = 0) as dislikes, IFNULL((SELECT value FROM sentiment WHERE item_id = c.item_id and user_id = :user_id ),-1) as sentiment FROM comment c, user u WHERE c.user_id = u.id && c.video_id = :video_id  ORDER BY c.date_time desc;";
      $bind = array(":user_id" => $_SESSION['data']['id'],":video_id" => $_POST['video_id']);
    }
    else{
      $comment_q = "SELECT c.* , u.*, c.id as com_id, c.date_time as date_commented,(SELECT count(value) FROM sentiment WHERE item_id = c.item_id AND value = 1) as likes , (SELECT count(value) FROM sentiment WHERE item_id = c.item_id AND value = 0) as dislikes, -1 as sentiment FROM comment c, user u WHERE c.user_id = u.id && c.video_id = :video_id  ORDER BY c.date_time desc;";
      $bind = array(":video_id" => $_POST['video_id']);
    }
    $row_comment = $database->resultset($comment_q , $bind);

    date_default_timezone_set('Asia/Calcutta');
    foreach ($row_comment as $com) { ?>
    <div data-item="<?php echo $com['item_id']; ?>" class="row" style="justify-content: center;margin-top:30px;">
      <div class="comments" style="width:848px;display: flex;">
        <div class="col-10" style="padding: 0px;">
          <div style="display: flex;line-height: 1 !important;">
            <div class="pro-info"><img src="../<?php echo $com['profile_pic_url']; ?>" style="width: 50px;height: 50px;"></div>
            <div style="padding: 0px 10px 0px 10px;">
              <span class="font-xs" style="line-height:1;color:#444"><strong><?php echo $com['first_name']; ?></strong></span>
              <span class="font-xxs" style="line-height:0.9;color:#777;margin-left:20px"><?php echo timeAgo($com['date_commented']); ?></span>
              <span class="font-xs" style="color:#333;">
                <p style="margin-top:10px;"><?php echo $com['content']; ?>
                </p>
              </span>
              <span class="font-xs " style="line-height:0.9;color:#777;margin-right:4px;"><i  data-sentiment="1" data-itemofitem="<?php  echo $com['item_id'];  ?>" class="flaticon-thumb-up-button font-xs hover-icon <?php if($com['sentiment']==1){echo "active-responce-positive";} ?>" style="margin:0px;" onclick="likes_handler(this)"></i> <span class="setiment-value"><?php echo $com['likes'];?></span> |</span>
              <span class="font-xs " style="line-height:0.9;color:#777;margin-right:4px;"><i data-sentiment="0" data-itemofitem="<?php  echo $com['item_id'];  ?>" class="flaticon-hands font-xs hover-icon <?php if($com['sentiment']==0){echo "active-responce-negetive";} ?>" style="margin:0px;" onclick="likes_handler(this)"></i> <span class="setiment-value"><?php echo $com['dislikes']; ?></span> <b>&#183;</b> </span>
              <span class="font-xs " style="line-height:0.9;color:#777;margin-right:4px;">Reply</span>
            </div>
          </div>
        </div>
        <div class="col-2" style="text-align:right;">
          <div class="comment-setting dropdown-toggle-split " data-toggle="dropdown" >
            <i class="flaticon-button-of-three-vertical-squares font-xs " style="margin:0px;" ></i>
          </div>
          <div class="dropdown-menu dropdown-menu-right " style="top:49px;">
            <?php if (isset($_SESSION['logged_in'])) :
                    if ($com['user_id']==$_SESSION['data']['id']) :?>
                      <a data-itemofitem="<?php  echo $com['item_id'];  ?>" class="dropdown-item" onclick="comment_function()">Edit</a>
                      <a data-itemofitem="<?php  echo $com['item_id'];  ?>" class="dropdown-item" onclick="comment_function()">Delete</a>
              <?php else :?>
                <a data-itemofitem="<?php  echo $com['item_id'];  ?>" class="dropdown-item" onclick="comment_function()">Report</a>
                <a data-itemofitem="<?php  echo $com['item_id'];  ?>" class="dropdown-item" onclick="comment_function()">Spam</a>
              <?php endif; else : ?>
                <a data-itemofitem="<?php  echo $com['item_id'];  ?>" class="dropdown-item" onclick="comment_function()">Report</a>
                <a data-itemofitem="<?php  echo $com['item_id'];  ?>" class="dropdown-item" onclick="comment_function()">Spam</a>
            <?php  endif; ?>
          </div>
        </div>
      </div>
    </div>
    <!-- Comment reply -->
    <?php
    if (isset($_SESSION['logged_in'])) {
      $comment_reply_q = "SELECT r.* , u.*, r.date_time as date_commented,(SELECT count(value) FROM sentiment WHERE item_id = r.item_id AND value = 1) as likes , (SELECT count(value) FROM sentiment WHERE item_id = r.item_id AND value = 0) as dislikes, IFNULL((SELECT value FROM sentiment WHERE item_id = r.item_id and user_id = :user_id ),-1) as sentiment FROM reply r, user u WHERE r.user_id = u.id && r.comment_id = :comment_id ORDER BY r.date_time;";
      $bind = array(":user_id" => $_SESSION['data']['id'],":comment_id" => $com['com_id']);
    }
    else{
      $comment_reply_q = "SELECT r.* , u.*, r.date_time as date_commented,(SELECT count(value) FROM sentiment WHERE item_id = r.item_id AND value = 1) as likes , (SELECT count(value) FROM sentiment WHERE item_id = r.item_id AND value = 0) as dislikes,-1 as sentiment FROM reply r, user u WHERE r.user_id = u.id && r.comment_id = :comment_id ORDER BY r.date_time;";
      $bind = array(":comment_id" => $com['com_id']);
    }
    $row_comment_reply = $database->resultset($comment_reply_q , $bind);
        foreach ($row_comment_reply as $com_reply) {
    ?>
    <div data-item="<?php echo $com_reply['item_id']; ?>" class="row " style="justify-content: center;margin-top:30px;">
      <div class="comments comment-reply" style="width:848px;display: flex;">
        <div class="col-10" style="padding: 0px;">
          <div style="display: flex;line-height: 1 !important;">
            <div class="pro-info"><img src="../<?php echo $com_reply['profile_pic_url']; ?>" style="width: 50px;height: 50px;"></div>
            <div style="padding: 0px 10px 0px 10px;">
              <span class="font-xs" style="line-height:1;color:#444"><strong><?php echo $com_reply['first_name']; ?></strong></span>
              <span class="font-xxs" style="line-height:0.9;color:#777;margin-left:20px"><?php echo timeAgo($com_reply['date_commented']); ?></span>
              <span class="font-xs" style="color:#333;">
                <p style="margin-top:10px;">
                  <?php echo $com_reply['content']; ?>
                </p>
              </span>
              <span class="font-xs " style="line-height:0.9;color:#777;margin-right:4px;"><i data-sentiment="1" data-itemofitem="<?php  echo $com_reply['item_id'];  ?>" class="flaticon-thumb-up-button font-xs hover-icon <?php if($com_reply['sentiment']==1){echo "active-responce-positive";} ?>" style="margin:0px;" onclick="likes_handler(this)"></i> <span class="setiment-value"><?php echo $com_reply['likes']; ?></span> |</span>
              <span class="font-xs " style="line-height:0.9;color:#777;margin-right:4px;"><i data-sentiment="0" data-itemofitem="<?php  echo $com_reply['item_id'];  ?>" class="flaticon-hands font-xs hover-icon <?php if($com_reply['sentiment']==0){echo "active-responce-negetive";} ?>" style="margin:0px;" onclick="likes_handler(this)"></i> <span class="setiment-value"><?php echo $com_reply['dislikes']; ?></span> <b>&#183;</b> </span>
              <span class="font-xs " style="line-height:0.9;color:#777;margin-right:4px;">Reply</span>
            </div>
          </div>
        </div>
        <div class="col-2" style="text-align:right;">
          <div class="comment-setting dropdown-toggle-split" data-toggle="dropdown">
            <i class="flaticon-button-of-three-vertical-squares font-xs" style="margin:0px;"></i></div>

          <div class="dropdown-menu dropdown-menu-right " style="top:49px;">
            <?php if (isset($_SESSION['logged_in'])) :
                    if ($com_reply['user_id']==$_SESSION['data']['id']) :?>
                      <a data-itemofitem="<?php  echo $com_reply['item_id'];  ?>" class="dropdown-item" onclick="comment_function()">Edit</a>
                      <a data-itemofitem="<?php  echo $com_reply['item_id'];  ?>" class="dropdown-item" onclick="comment_function()">Delete</a>
              <?php else :?>
                <a data-itemofitem="<?php  echo $com_reply['item_id'];  ?>" class="dropdown-item" onclink="comment_function(this)">Report</a>
                <a data-itemofitem="<?php  echo $com_reply['item_id'];  ?>" class="dropdown-item" onclink="comment_function(this)">Spam</a>
              <?php endif; else : ?>
                <a data-itemofitem="<?php  echo $com_reply['item_id'];  ?>" class="dropdown-item" onclink="comment_function(this)">Report</a>
                <a data-itemofitem="<?php  echo $com_reply['item_id'];  ?>" class="dropdown-item" onclink="comment_function(this)">Spam</a>
            <?php  endif; ?>
          </div>
        </div>
      </div>
    </div>
    <!-- End of Comment  reply -->
  <?php } }
  die();
  }
//Comment Loader

  echo $JSON_responce;
?>
