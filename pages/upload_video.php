<?php
session_start();
if (isset($_SESSION['logged_in'])) {
include "../lib/lib.php";
require '../pdo/classes/Database.php';
$database = new Database;
if (isset($_POST['submit'])) {

  if (isset($_FILES['file'])) {
      $vid =array("mp4", "3gp", "mov", "avi", "mwv", "mpeg", "mpg", "flv", "ogg" ,"vob" ,"mkv","webm", "mpv", "m4p","webm");
      $location = "/res/videos/";
      $name = $_FILES['file']['name'];
      $size = $_FILES['file']['size'];
      $type = $_FILES['file']['type'];
      $extension = strtolower(substr($name , strrpos($name, '.') + 1));
      $temp_name = $_FILES['file']['tmp_name'];
      $name = genVidName();
      mkdir("..".$location.$name);
      $vid_config = array('location' => $temp_name,'save_loaction' => "..".$location.$name.'/' , 'quality' => 'high' ,'name' => $name.'.jpg' );
      if(in_array($extension, $vid)){
        if(encodeVideo($vid_config)){
          $user_id = $_SESSION['data']['id'];

          $item_q = "INSERT INTO item (`user_id`) VALUE (:user_id)";
          $bind  = array(':user_id' => $user_id );
          $database->execute($item_q,$bind);
          $item_id = $database->lastId();



          $doc_q = "SELECT doctor.id as id FROM `doctor`, `user` WHERE user.id = doctor.user_id and doctor.user_id = :id";
          $bind  = array(':id' => $user_id );
          $result = $database->resultset($doc_q,$bind);
          //print_r($result);
          $doc_id = $result[0]['id'];
          $thumbnail = "/res/img/thumbnail/".$name.'.jpg';
          $url = $location.$name.'/';

          $video_q = "INSERT INTO video (`item_id`,`doctor_id`,`unique_id`,`thumbnail`,`url_low`,`url_medium`,`url_high`) VALUES (:i_id, :d_id,:unique_id, :thumb, :low, :med, :high)";
          $bind_new = array(":i_id" => $item_id, ":d_id" => $doc_id, ":unique_id"=> $name ,":thumb" => $thumbnail, ":low" => $url.'low.mp4', ":med" => $url.'med.mp4', ":high" => $url.'high.mp4');
          $database->execute($video_q , $bind_new);
          move_uploaded_file($temp_name,"..".$location.$name.'/high.'.$extension);
          echo '{"success":1,"message":"vedio conversion successful","vid_name":"'.$name.'"}';
        }
      }
      else {
        echo '{"success":1,"message":"vedio conversion successful"}';
      }
    }
}else {
include "../lib/header.php";
 ?>
    <!-- Main Body -->
    <div class="container-fluid" style="height: calc(100vh - 62px);">
      <div class="row" style="height:100%">
        <!-- Side Menu -->
        <div class="hide" id="side-menu" >
          <div class="container-fluid" style="overflow-x: hidden;">
            <div class="row">
              <a href="#" class="no-style"><div class="col-12 menu-list-item"><i class="flaticon-home font-s pad" ></i>Home</div></a>
            </div>
            <div class="row">
              <a href="#" class="no-style"><div class="col-12 menu-list-item"><i class="flaticon-increasing-chart font-s pad" ></i>Trending</div></a>
            </div>
            <div class="row">
              <a href="#" class="no-style"><div class="col-12 menu-list-item"><i class="flaticon-open-book font-s pad" ></i>Library</div></a>
            </div>
            <div class="row">
              <div class="col-12 menu-separator"></div>
            </div>
            <div class="row">
              <a href="#" class="no-style"><div class="col-12 menu-list-item"><i class="flaticon-history font-s pad" ></i>History</div></a>
            </div>
            <div class="row">
              <a href="#" class="no-style"><div class="col-12 menu-list-item"><i class="flaticon-mail font-s pad" ></i>Subscriptions</div></a>
            </div>
            <div class="row">
              <a href="#" class="no-style"><div class="col-12 menu-list-item"><i class="flaticon-computer font-s pad" ></i>Browse Chennels</div></a>
            </div>
            <div class="row">
              <div class="col-12 menu-separator"></div>
            </div>
            <div class="row">
              <a href="#" class="no-style"><div class="col-12 menu-list-item"><i class="flaticon-settings-gears font-s pad" ></i>Settings</div></a>
            </div>
            <div class="row">
              <a href="#" class="no-style"><div class="col-12 menu-list-item"><i class="flaticon-help-web-button font-s pad" ></i>Help</div></a>
            </div>
            <div class="row">
              <a href="#" class="no-style"><div class="col-12 menu-list-item"><i class="flaticon-speech-bubble-with-text-lines font-s pad" ></i>Feedback</div></a>
            </div>
            <div class="row">
              <div class="col-12 menu-separator"></div>
            </div>
            <div class="row">
              <div class="col-12 font-xs" style="line-height:50px;min-width:240px;text-align:center;color:rgba(100,100,100,0.3);">&copy; 2018 Tulsi Care</div>
            </div>
          </div>
        </div>
        <!-- End of Side Menu -->
        <div class="wide" id="container-vid" style="overflow: hidden;">
          <!-- Progress Bar -->
          <div class="progress" style="opacity:0;text-align:center;color:#ccc;">
          	<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%;background:#ff9d17;">
              <div class="progressSpeed">
                0KB/s
              </div>
  				  </div>
  				</div>
          <!-- End of Progress Bar -->
          <div class="upload-main">
            <div class="upload-file">
              <div class="file-upload-container">
                <div style="text-align: center;">
                  <i class="flaticon-arrow" style="font-size:100px;color:#bbb;position: relative;left: 10px;"></i>
                </div>
                <div class="file-upload-text">
                  Select video to upload
                </div>
                <form id="myForm" class="no-outline" method="post" enctype="multipart/form-data"  >
                  <input class="no-outline" type="file" name="file" onchange="triger()"><br>
                  <input id="submit" class="no-outline" type="submit" name="submit" value="Send" >
                </form>
              </div>

              <div class="">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<!-- End of Main Body -->
<script src="../js/popper.min.js"></script>
<script src="../js/jquery.form.js"></script>
    <script type="text/javascript">
      var progress;
      var progressbar;
      var progressSpeed;
      var send;
      var d;
      var oldTime;
      var oldpercentComplete;
      var c;

         $("#myForm").ajaxForm(
           {
            type : "POST",
            beforeSend: function() {
              progress = $(".progress");
              progressbar     = $('.progress-bar');
              progressSpeed     = $('.progressSpeed');
              send = 0;
              d = new Date();
              oldTime = d.getTime();
              oldpercentComplete =0;
              c = 0;
              progress.css("opacity","1");
              progressSpeed.css("color","#555");
              progressbar.css("background-color","#ff9d17");
              progressbar.width('0%');
              progressSpeed.text('0%');
            },
            // target : $('#responce'),
            uploadProgress: function (event, position, total, percentComplete) {
              progressSpeed.text(percentComplete + '%');
              if (percentComplete > oldpercentComplete){
                progressbar.width(percentComplete + '%');

                oldpercentComplete = percentComplete;
               }
             },
             resetForm :true,
             forceSync :true,
             url : 'upload_video.php',
             success:function(responseText) {
              console.log(responseText);
              var data = JSON.parse(responseText);
               if (data.success) {
                 window.open("./video_studio.php?video_id="+data.vid_name , "_self");
               }
            }
          });
          var progress = $(".progress");
          var progressbar     = $('.progress-bar');
          var progressSpeed     = $('.progressSpeed');
          // setInterval(function(){
          //   $.ajax({
          //     url : "processing_update.php",
          //     type : "POST",
          //     success : function(result){
          //       //console.log(result);
          //       var data = JSON.parse(result);
          //
          //       if (data.progress > 0) {
          //         if(data.progress <= 99){
          //           progressSpeed.text('Processing video '+(data.progress+1)+"%");
          //         }
          //         else{
          //           progressSpeed.text('Processing video '+data.progress+"%");
          //         }
          //         progress.css("background","#ff9d17");
          //         progressbar.width(data.progress + '%');
          //         progressbar.css("background-image","linear-gradient(45deg,rgba(255,255,255,0.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,0.15) 50%,rgba(255,255,255,0.15) 75%,transparent 75%,transparent)");
          //         progressbar.css("background-color","#428bca");
          //         progressbar.css("color","#fff");
          //       }
          //     }
          //   });
          // },1000);
          function triger(){
            $('#submit').click();
            $('.file-upload-container').html('<div style="text-align:center;color:#555;font-size:20px;">Uploading...</div>');
          }
      </script>
  </body>
</html>
<?php }
}
else{
  header('Location: ../index.php');
  die();
}?>
