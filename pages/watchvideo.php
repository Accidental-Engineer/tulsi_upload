<?php
session_start();
include "../lib/lib.php";
require '../pdo/classes/Database.php';
$database = new Database;
if (isset($_GET['watch_id']) && $_GET['watch_id']!='') {
  $id = $_GET['watch_id'];

  if (isset($_SESSION['logged_in'])) {
    $video_q = "SELECT v.* , DATE_FORMAT(v.date_time, '%d %b, %Y')  as date_published , concat(u.first_name,' ',u.last_name) as name, d.qualification1 as q1, u.profile_pic_url as pro_pic ,(SELECT count(value) FROM sentiment WHERE item_id = v.item_id AND value = 1) as likes , (SELECT count(value) FROM sentiment WHERE item_id = v.item_id AND value = 0) as dislikes, IFNULL((SELECT value FROM sentiment WHERE item_id = v.item_id and user_id = :user_id ),-1) as sentiment FROM video v, doctor d, user u Where d.user_id = u.id and  v.unique_id = :id" ;
    $bind = array(":user_id" => $_SESSION['data']['id'], ":id" => $id);
  }
  else{
    $video_q = "SELECT v.* , DATE_FORMAT(v.date_time, '%d %b, %Y')  as date_published , concat(u.first_name,' ',u.last_name) as name, d.qualification1 as q1, u.profile_pic_url as pro_pic ,(SELECT count(value) FROM sentiment WHERE item_id = v.item_id AND value = 1) as likes , (SELECT count(value) FROM sentiment WHERE item_id = v.item_id AND value = 0) as dislikes, -1 as sentiment FROM video v, doctor d, user u Where d.user_id = u.id and  v.unique_id = :id" ;
    $bind = array(":id" => $id);
  }

  $row = @$database->resultset($video_q , $bind)[0];

  // $comment_q = "SELECT c.* , u.*, c.id as com_id, c.date_time as date_commented,(SELECT count(value) FROM sentiment WHERE item_id = c.item_id AND value = 1) as likes , (SELECT count(value) FROM sentiment WHERE item_id = c.item_id AND value = 0) as dislikes FROM comment c, user u WHERE c.user_id = u.id && c.video_id = :video_id ORDER BY c.date_time desc;";
  // $bind = array(":video_id" => $row['id']);
  // $row_comment = $database->resultset($comment_q , $bind);
  // //print_r($row_comment);
  //
  $comment_count_q = "SELECT c.id ,count(c.id) + (SELECT count(r.id) FROM reply r , comment c1 WHERE r.comment_id = c1.id && c1.video_id = :vid_id) as num_comment FROM comment c WHERE c.video_id = :video_id ";
  $bind = array(":vid_id" => $row['id'],":video_id" => $row['id']);
  $comment_count = $database->resultset($comment_count_q , $bind)[0]['num_comment'];

  // echo timeAgo($row_comment[0]['date_time']);

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
        <div class="wide" id="container-vid" >
          <div class="container-fluid no-pad" style="display:flex;justify-content:center;">
            <div class="row" style="display:flex;justify-content: center;width: 100%;margin-top:20px !important;margin:0px;">
              <div class="col-12" style="display: flex;justify-content: center;">
                <div class="container-fluid">
                  <div class="row" style="justify-content: center;">
                    <div style="width:848px;display: flex;justify-content: center;">
                      <video  id="vid1" width="848" height="477" controls controlsList="fullscreen nodownload noremoteplayback"  style="background:black;" preload="none" poster="<?php echo "..".$row['thumbnail'] ?>">
                        <source src="<?php echo "..".$row['url_high'] ?>"  type="video/mp4"  controlsList="nodownload" autostart="false"/>
                           Your browser does not support the video tag.
                      </video>
                    </div>
                  </div>
                  <div class="row" style="justify-content: center;">
                    <div  class="font-m" style="width:848px;display: flex;margin-top:10px;">
                      <?php echo $row['title'] ?>
                    </div>
                  </div>
                  <div class="row" style="justify-content: center;">
                    <div  class="font-xs" style="width:848px;display: flex;margin-top:10px;color:#777">
                      <div class="row" style="justify-content: center;width:100%;line-height:32px;">
                        <div class="col-4" >
                          <?php echo number_format($row['views']); ?> views
                        </div>
                        <div class="col-8" style="text-align:right;margin:0px;padding:0px;">
                          <div style="right: -20px;position: absolute;">
                            <span><i data-sentiment="1" data-itemofitem="<?php  echo $row['item_id'];  ?>" class="flaticon-thumb-up-button hover-icon <?php if($row['sentiment']==1){echo "active-responce-positive";} ?>" style="position:relative;left:10px;" onclick="likes_handler(this)"></i><span class="setiment-value"><?php echo $row['likes']; ?></span></span>
                            <span><i data-sentiment="0" data-itemofitem="<?php  echo $row['item_id'];  ?>" class="flaticon-hands hover-icon <?php if($row['sentiment']==0){echo 'active-responce-negetive';} ?>" style="position:relative;left:10px;" onclick="likes_handler(this)"></i><span class="setiment-value"><?php echo $row['dislikes']; ?></span></span>
                            <span><i class="flaticon-share-connection-sing hover-icon" style="position:relative;left:10px;"></i></span>
                            <span><i class="flaticon-three-dots-more-indicator hover-icon" style="position:relative;left:10px;"></i></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row" style="justify-content: center;margin-top:15px;">
                    <div style="height:1px;width:848px;background:#ddd;"></div>
                  </div>
                  <div class="row" style="justify-content: center;margin-top:15px;">
                    <div style="width:848px;display: flex;">
                      <div class="col-8" style="padding: 0px;">
                        <div style="display: flex;line-height: 1 !important;">
                          <div class="pro-info"><img src="../<?php echo $row['pro_pic']; ?>" style="width: 50px;height: 50px;"></div>
                          <div style="padding: 0px 10px 0px 10px;"><span class="font-m" style="line-height:1;color:#444"><?php echo $row['name']?></span><br><span class="font-xxs" style="line-height:0.9;color:#777"><?php echo $row['q1']?></span></div>
                        </div>
                      </div>
                      <div class="col-4" style="text-align:right;line-height: 50px;">
                        <i class="flaticon-speech-bubble-with-text-lines font-m" style="line-height:50px;color: #5ea12c;"></i>
                        <button type="button" class="btn subscribe" style="margin-top:-10px;">Subscribe</button>
                      </div>
                    </div>
                  </div>
                  <div class="row" style="justify-content: center;margin-top:15px;">
                    <div style="width:848px;display: flex;">
                      <div class="col-12" style="padding: 0px;">
                        <div style="display: flex;line-height: 1 !important;">
                          <div style="padding: 0px 10px 0px 10px;"><span class="font-xs" style="line-height:1;color:#444"><strong>Published on : </strong><?php echo $row['date_published']; ?></span><br><span class="font-xs" style="line-height:1;color:#444"><strong>category : </strong><?php echo array_search($row['category'],$categoryMap); ?></span><br></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row" style="justify-content: center;margin-top:15px;">
                    <div style="width:848px;display: flex;">
                      <div class="col-12" style="padding: 0px;">
                        <div style="display: flex;line-height: 1 !important;">
                          <div  class="" style="padding: 0px 10px 0px 10px;">
                            <div id='demo' class="font-xs collapse" style="line-height:1;color:#444">
                              <p><?php echo $row['description'] ?></p>
                            </div>
                            <span class="read_more" data-toggle="collapse" data-target="#demo" style="border:1px solid rgba(50,50,50,0.5); padding:2px 10px;">READ DESCRIPTION</span>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- End of Description -->

                  <div class="row" style="justify-content: center;margin-top:15px;">
                    <div style="width:848px;">
                      <div class="row" style="width:100%;">
                        <div class="col-12">
                          <span class="font-s">Comming Up</span>
                        </div>
                      </div>
                      <div class="row" style="width:100%;">
                        <?php
                          $video_q = "SELECT d.*,v.*,v.date_time as published, concat(u.first_name,' ',u.last_name) as name FROM video v, doctor d, user u Where v.doctor_id = d.id AND d.user_id=u.id AND unique_id != :unique_id  ORDER BY v.date_time desc LIMIT 4;";
                          $bind = array("unique_id" => $id);
                          $rows = $database->resultset($video_q,$bind);
                          foreach ($rows as $row) {
                         ?>

                        <div class="col-lg-3 col-md-12" style="line-height: 50px;">
                          <div class="vid-card vid-card-watch">
                            <div class="">
                              <a class="no-style" href="./watchvideo.php?watch_id=<?php echo $row['unique_id']; ?>"><img src="..<?php echo $row['thumbnail']; ?>" alt="" class="vid-thumbnail vid-thumbnail-watch"></a>
                            </div>
                            <div style="height:40.935%;padding-top: 5px;">
                              <div style="height:32px;line-height:16px;padding-left:2px;padding-right:10px;font-size: 01em;font-weight: bold;">
                                <a class="no-style" href="./watchvideo.php?watch_id=<?php echo $row['unique_id']; ?>"><?php echo $row['title']; ?></a>
                              </div>
                              <div class="font-xxs" style="height:32px;line-height:16px;padding-left:2px;padding-right:10px;">
                                <br><?php echo $row['name']; ?>
                              </div>
                              <div class="font-xxs" style="line-height:16px;padding-left:2px;padding-right:10px;">
                                <?php echo viewCount($row['views']); ?> views <b>&#183;</b> <?php echo timeAgo($row['published']); ?>
                              </div>
                            </div>
                          </div>
                        </div>

                        <?php } ?>
                      </div>
                    </div>
                  </div>


                  <div class="row" style="justify-content: center;margin-top:15px;">
                    <div style="width:848px;display: flex;">
                      <div class="col-12" style="padding: 0px;">
                        <div style="height:41px;display: flex;line-height: 1 !important;border-bottom: 2px solid rgba(86, 86, 86, 0.7);">
                          <div style="padding: 10px;border-bottom: 5px solid #5ea12c;position:absolute;">
                            <span class="read_more" ><strong><?php echo $comment_count; ?> Comments</strong></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row" style="justify-content: center;">
                    <div  class="font-xs" style="width:848px;display: flex;margin-top:10px;color:#777">
                      <div class="row" style="justify-content: center;width:100%;line-height:32px;">
                        <div class="col-4" style="color:#aaa" >
                          <strong>Recomended</strong>
                        </div>
                        <div class="col-8" style="text-align:right;margin:0px;padding:0px;">
                          <div style="right: -20px;position: absolute;color:#aaa;">
                            <div class="dropdown">
                              <span  class="dropdown-toggle" data-toggle="dropdown">
                                <strong>Sort by</strong>
                              </span>
                              <div class="dropdown-menu" style="z-index:11111;">
                                <a class="dropdown-item active" href="#">Most Recent</a>
                                <a class="dropdown-item" href="#">Top Comments</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row" style="justify-content: center;margin-top:15px;">
                    <div style="width:848px;display: flex;">
                      <div class="col-12" style="padding: 0px;">
                        <div style="display: flex;line-height: 1 !important;">
                          <div class="pro-info"><img src="../<?php if(isset($_SESSION['logged_in'])){echo $_SESSION['data']['profile_pic_url'];}else {echo "res/img/default.png";}?>" style="width: 50px;height: 50px;"></div>
                          <div style="padding: 0px 10px 0px 10px;width: 100%;z-index: 0;">
                            <input id="comment" class="comment" type="text" name="comment" placeholder="Leave a comment ..." onkeypress="return comment(event)">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Comments -->
                  <div id="comments">

                  </div>
                  <!-- Comments -->
                  <div class="row" style="justify-content: center;margin-top:15px;">
                    <div style="height:1px;width:848px;background:#ddd;"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

         <!-- Script For Video Player -->
         <script type="text/javascript">
         $(document).ready(function(){
           $.ajax({
             url: "comment_handler.php",
             type: "POST",
             data: "video_id="+<?php echo $row['id'];?>+"&load_comment=1",
             success : function(result){
                 var comments = $('#comments').html(result);
                 $('.comment-setting').click(function(){
                      $(this).toggleClass("active-setting");
                 });
                 $('html').click(function(e){
                   if($(e.target) !== $('.comment-setting'))
                        {
                          //console.log("jghggfdg");
                          $('.comment-setting').removeClass("active-setting");
                        }
                 });
             }
           });
         });
         // Linke handler function
         function likes_handler(e){
           //console.log("item_id="+$(e).attr("data-itemofitem")+"&sentiment="+$(e).attr('data-sentiment'));
           $.ajax({
             url: "comment_handler.php",
             type: "POST",
             data: "item_id="+$(e).attr("data-itemofitem")+"&value="+$(e).attr('data-sentiment')+"&sentiment=1",
             success : function(result){
               console.log(result);
                var data = JSON.parse(result);
                if (data.success) {
                  //console.log(data.message);
                  if (data.message=="liked") {
                    $(e).addClass('active-responce-positive');
                    $(e).next().html(data.likes);
                    $(e).parent().next().children().removeClass('active-responce-negetive');
                    $(e).parent().next().find('span').html(data.dislikes);

                  }
                  else if (data.message=="disliked"){
                    $(e).addClass('active-responce-negetive');
                    $(e).next().html(data.dislikes);
                    $(e).parent().prev().children().removeClass('active-responce-positive');
                    $(e).parent().prev().find('span').html(data.likes);
                  }
                }
                else if(data.success==0){
                  if (data.message=="User not authorized to access to comment") {
                    window.open('./userAuthUI.php','_self');
                }
             }
              }
           });
       }


         function comment_function(){

           console.log("working");
         }

         function comment(e){
            var keynum;
            if(window.event) { // IE
              keynum = e.keyCode;
            } else if(e.which){ // Netscape/Firefox/Opera
              keynum = e.which;
            }

            if (keynum == 13) {
            <?php if (isset($_SESSION['logged_in'])) : ?>
              //alert($('#comment').val());
              var com = $('#comment').val();
              var comments = $('#comments').html();
              $.ajax({
                url: "comment_handler.php",
                type: "POST",
                data: "video_id="+<?php echo $row['id'];?>+"&comment="+com,
                beforeSend: function() {
                  var new_comments = '<div data-item="0" class="row" style="justify-content: center;margin-top:30px;"><div class="comments" style="width:848px;display: flex;"><div class="col-10" style="padding: 0px;"><div style="display: flex;line-height: 1 !important;">'+
                              '<div class="pro-info"><img src="../<?php echo $_SESSION['data']['profile_pic_url']; ?>" style="width: 50px;height: 50px;"></div>'+
                              '<div style="padding: 0px 10px 0px 10px;">'+
                                '<span class="font-xs" style="line-height:1;color:#444"><strong><?php echo $_SESSION['data']['first_name']; ?></strong></span>'+
                                '<span id="time" class="font-xxs" style="line-height:0.9;color:#777;margin-left:20px">Posting...</span>'+
                                '<span class="font-xs" style="color:#333;">'+
                                  '<p style="margin-top:10px;">'+com+
                                  '</p>'+
                                '</span>'+
                                '<span class="font-xs " style="line-height:0.9;color:#777;margin-right:4px;"><i class="flaticon-thumb-up-button font-xs hover-icon" style="margin:0px;"></i> 0 |</span>'+
                                '<span class="font-xs " style="line-height:0.9;color:#777;margin-right:4px;"><i class="flaticon-hands font-xs hover-icon" style="margin:0px;"></i> 0 <b>&#183;</b> </span>'+
                                '<span class="font-xs " style="line-height:0.9;color:#777;margin-right:4px;">Reply</span>'+
                              '</div>'+
                            '</div>'+
                          '</div>'+
                          '<div class="col-2" style="text-align:right;">'+
                            '<div class="comment-setting"><i class="flaticon-button-of-three-vertical-squares font-xs" style="margin:0px;"></i></div>'+
                          '</div>'+
                        '</div>'+
                      '</div>';
                  new_comments +=  comments;
                  $('#comments').html(new_comments);
                },
                success : function(result){
                  console.log(result);
                  var data = JSON.parse(result);
                  if (data.success) {
                    console.log("done");
                    $('#comment').val('');
                    var new_comments = '<div data-item="'+data.item_id+'" class="row" style="justify-content: center;margin-top:30px;"><div class="comments" style="width:848px;display: flex;"><div class="col-10" style="padding: 0px;"><div style="display: flex;line-height: 1 !important;">'+
                                '<div class="pro-info"><img src="../<?php echo $_SESSION['data']['profile_pic_url']; ?>" style="width: 50px;height: 50px;"></div>'+
                                '<div style="padding: 0px 10px 0px 10px;">'+
                                  '<span class="font-xs" style="line-height:1;color:#444"><strong><?php echo $_SESSION['data']['first_name']; ?></strong></span>'+
                                  '<span id="time" class="font-xxs" style="line-height:0.9;color:#777;margin-left:20px">Just now</span>'+
                                  '<span class="font-xs" style="color:#333;">'+
                                    '<p style="margin-top:10px;">'+com+
                                    '</p>'+
                                  '</span>'+
                                  '<span class="font-xs " style="line-height:0.9;color:#777;margin-right:4px;"><i class="flaticon-thumb-up-button font-xs hover-icon" style="margin:0px;"></i> 0 |</span>'+
                                  '<span class="font-xs " style="line-height:0.9;color:#777;margin-right:4px;"><i class="flaticon-hands font-xs hover-icon" style="margin:0px;"></i> 0 <b>&#183;</b> </span>'+
                                  '<span class="font-xs " style="line-height:0.9;color:#777;margin-right:4px;">Reply</span>'+
                                '</div>'+
                              '</div>'+
                            '</div>'+
                            '<div class="col-2" style="text-align:right;">'+
                              '<div class="comment-setting"><i class="flaticon-button-of-three-vertical-squares font-xs" style="margin:0px;"></i></div>'+
                            '</div>'+
                          '</div>'+
                        '</div>';
                    new_comments +=  comments;
                    $('#comments').html(new_comments);
                  }
                  else {
                    console.log("failed");
                    alert("Unable to comment right now. Please try again latter.");
                  }
                }
              });
              <?php else: ?>
                alert("Please login to comment");
              <?php endif ?>
            }
          }

         function goFullscreen(id) {
          var element = document.getElementById(id);
          if (element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
          } else if (element.webkitRequestFullScreen) {
            element.webkitRequestFullScreen();
          }
        }
        var pause = 0;
       document.getElementById('vid1').addEventListener('loadedmetadata', function() {
       this.currentTime = 5;
       this.play();
       }, false);

       document.getElementById('vid1').addEventListener('click', function() {
         this.currentTime = 5;
         if(pause == 0){
           this.pause();
           pause = 1;
         }
         else{
           this.play();
           pause = 0;
         }
      }, false);

          function myKeyPress(e){
               var keynum;
               if(window.event) { // IE
                 keynum = e.keyCode;
               } else if(e.which){ // Netscape/Firefox/Opera
                 keynum = e.which;
               }
               var obj = document.getElementById('vid1');
               if(keynum == 32){
                 if(pause == 0){
                   obj.pause();
                   pause = 1;
               }
               else{
                 obj.play();
                 pause = 0;
               }
              }
            }
         </script>
         <!-- Script For Video Player -->
        </div>
      </div>
    </div>
    <!-- End of Main Body -->
    </body>
  </html>
<?php
}
  else {
    header('Location: ../index.php');
    die();
  }
?>
