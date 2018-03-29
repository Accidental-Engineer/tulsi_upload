<?php
session_start();
include "../lib/lib.php";
require '../pdo/classes/Database.php';
$database = new Database;
if (isset($_SESSION['logged_in'])) {
  if (isset($_POST['title']) || isset($_POST['thumbnail'])) {
    $JSON_responce ='{';
    if ( $_POST['title'] !='' && $_POST['description'] !="" ) {
      $u_id = $_POST['vid_id'];
      $title = $_POST['title'];
      $des = $_POST['description'];
      $category = $_POST['category'];
      $tags = $_POST['tags'];
      $lang = $_POST['lang'];

      $categoryiId = $categoryMap[$category];


      $video_q = "UPDATE video set `title`= :title ,`description`=:description,`category` = :category,`tags`= :tags WHERE `unique_id` = :u_id" ;
      $bind_new = array(":title" => $title, ":description" => $des, ":category" => $categoryiId, ":tags" => $tags, ":u_id" => $u_id);
      $database->execute($video_q , $bind_new);
      $JSON_responce .= '"success":1,"message":"saved"';
    }
    else{
      $JSON_responce .= '"success":0,"message":"More than one empty fields"';
    }
      $JSON_responce .='}';
      echo $JSON_responce;
  }
else{
    if (isset($_GET['video_id']) && $_GET['video_id']!='') {
      $id =$_GET['video_id'];
      $vid_q = "SELECT * FROM video Where unique_id= :id;";
      $bind = array(":id" => $id);
      $row =$database->resultset($vid_q,$bind)[0];
    }else {
      header("Location:profile.php");
      die();
    }
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
            <div class="wide" id="container-vid" style="overflow-y: scroll;">
              <div class="studio-main" style="height:auto !important;">
                <div class="studio-container" style="height:auto !important;margin-top:20px; margin-bottom: 20px;">
                  <div class="studio-title">
                    <span class='title-span'>Untitled Video</span>
                    <span><span id="save" onclick="submit()">Save</span></span>
                  </div>
                  <div class="container-fluid studio-video">
                    <div class="row">
                      <div class="col-6 stutio-video-section" style="min-width:510px;max-width:510px;">
                        <div class="studio-vid-container">
                          <video id="video" data-id="<?php echo $id; ?>" width="480" height="270.4"  poster="../res/img/thumbnail/<?php echo $id; ?>.jpg">
                            <source src="../res/videos/<?php echo $id; ?>/high.mp4" type="video/mp4">
                            <!-- <source src="../res/videos/<?php echo $id; ?>/low.mp4" type="video/mp4"> -->
                              Your browser does not support the video tag.
                          </video>
                          <div class="studio-vid-overlay">
                            <div class="studio-vid-overlay-bar">
                              <a class="no-style" href="./watchvideo.php?watch_id=<?php echo $row['unique_id'] ?>"><span class='title-span'>Untitled Video</span></a>
                              <span><i class="flaticon-share-connection-sing hover-icon" style="position:absolute;right:0px;"></i></span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-6 stutio-video-property">
                        <div class="studio-thumbnail">
                          <img src="../res/img/thumbnail/<?php echo $id; ?>.jpg" style="width:100%;">
                        </div>
                        <div class="studio-thumbnail" >
                          <img src="../res/img/thumbnail/<?php echo $id; ?>.jpg" style="width:100%;">
                        </div>
                        <div class="studio-thumbnail" style="border:none;">
                          <div style="overflow: hidden;position: relative;">
                            <button class="form" type="button" name="button" style="margin: 0;width: 160px;">Custom thumbnail</button>
                            <form id="myForm" method="post" enctype="multipart/form-data">
                              <input class="no-outline" type="file" name="file" onchange="triger()"><br>
                              <input id="submit" class="no-outline" type="submit" name="submit" value="Send" >
                            </form>
                          </div>

                          <span style="font-size:10px;color:#aaa">Maximum file size 2 MB.</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="studio-form">
                    <div class="edit-basic-info" >
                      <span>Edit basic info</span>
                    </div>
                    <div class="inner studio-edit">
                      <!-- Form Area -->
                      <div class="studio-edit-form">
                        <!-- Form -->
                        <form id="studio-edit-vid" method="post">
                          <!-- Left Inputs -->
                          <div class="row">
                            <div class="col-6 wow animated slideInLeft" data-wow-delay=".5s" style="margin-top: 25px;">
                              <input type="text" value="<?php echo $row['title'] ?>" name="title" id="title" required="required" class="form" placeholder="Title" onchange="changeTitle()"  onkeyup="changeTitle()"/>
                              <textarea name="description"  id="description" class="form textarea" placeholder="Description"><?php echo $row['description']?></textarea>
                              <textarea name="tags"  id="tags" class="form textarea" placeholder="Tags (semicolone separated)"><?php echo $row['tags'] ?></textarea>
                            </div>
                            <!-- End Left Inputs -->
                            <!-- Right Inputs -->
                            <div class="col-6 wow animated slideInRight" data-wow-delay=".5s" style="margin-top: 25px;">
                              <select class="form" name='category' id="category" >
                                <option value="Category">category</option>
                                <option value="Health">Health</option>
                                <option value="Life Style">Life Style</option>
                                <option value="Aaurveda">Aaurveda</option>
                              </select>
                              <select class="form" name="lang" id="lang">
                                <option value="language">Language</option>
                                <option value="english">English</option>
                                <option value="hindi">Hindi</option>
                                <option value="other">Other</option>
                              </select>
                            </div>
                          <!-- End Right Inputs -->
                          </div>
                          <!-- Clear -->
                          <div class="clear"></div>
                        </form>

                        <!-- Your Mail Message -->
                        <div class="mail-message-area">
                          <!-- Message -->
                          <div class="alert gray-bg mail-message not-visible-message">
                            <strong>Thank You !</strong> Your email has been delivered.
                          </div>
                        </div>

                      </div>
                      <!-- End studio-edit Form Area -->
                    </div>
                    <!-- End Inner -->
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
          function changeTitle(){
            $('.title-span').html($('#title').val());
          }
          function triger(){
            $('#submit').click();
            $('.file-upload-container').html('<div style="text-align:center;color:#555;font-size:20px;">Uploading...</div>');
          }
          function submit(){
            $.ajax({
              url: "video_studio.php",
              type: "POST",
              data: "vid_id="+$('#video').attr('data-id')+"&title="+$('#title').val()+"&description="+$('#description').val()+"&tags="+$('#tags').val()+"&category="+$('#category').val()+"&lang="+$('#lang').val(),
              success : function(result){
                console.log(result);
                var data = JSON.parse(result);
                if (data.success) {
                  console.log("done");
                }
                else {
                  console.log("failed");
                }
              }
            })

          }

              $(document).ready(function(){
               $('html').css('min-width','1080px');
               $('.title-span').html($('#title').val());
              });

          </script>
      </body>
    </html>
    <?php
    }
}
else{
  header('Location: ../index.php');
  die();
}
?>
