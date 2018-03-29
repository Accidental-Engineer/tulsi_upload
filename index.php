<?php
session_start();
require 'pdo/classes/Database.php';
require 'lib/lib.php';
$database = new Database;
include "./lib/header.php";
$Recent_Uploads_q = "SELECT d.*,v.*,v.date_time as published, concat(u.first_name,' ',u.last_name) as name FROM video v, doctor d, user u Where v.doctor_id = d.id AND d.user_id=u.id  ORDER BY v.date_time desc LIMIT 6;";
$Most_Popular_q = "SELECT d.*,v.*,v.date_time as published, concat(u.first_name,' ',u.last_name) as name , temp_likes likes , views + 10*temp_likes as score FROM video v, doctor d, user u Where v.doctor_id = d.id AND d.user_id=u.id  ORDER BY score DESC LIMIT 6;";
$Trending_q = "SELECT d.*,v.*,v.date_time as published, concat(u.first_name,' ',u.last_name) as name , views/TIMESTAMPDIFF(SECOND, v.date_time, NOW()) as score FROM video v, doctor d, user u Where v.doctor_id = d.id AND d.user_id=u.id  ORDER BY  score DESC LIMIT 6;";
$Most_Liked_q = "SELECT d.*,v.*,v.date_time as published, concat(u.first_name,' ',u.last_name) as name,(SELECT count(value) FROM sentiment WHERE item_id = v.item_id AND value = 1) as likes FROM video v, doctor d, user u Where v.doctor_id = d.id AND d.user_id=u.id  ORDER BY likes DESC LIMIT 6;";
$row_type = array('Recent Uploads' => $Recent_Uploads_q, 'Most Popular' => $Most_Popular_q, 'Trending' => $Trending_q, 'Most Liked'=> $Most_Liked_q );
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
      <div class="wide" id="container-vid">
        <?php foreach ($row_type as $key => $value) { ?>
        <!-- Videos Rows -->
        <div class="container vid-row" style="margin-top: 20px;display: flex;justify-content: center;flex-direction: row;flex-wrap: wrap;" >
          <div class="row vid-row-title">
            <div class="col-12 font-m no-pad" style="display:inline;text-align:left;">
              <?php echo $key; ?>
            </div>
          </div>
          <div class="row vid-inner-container" style="display:inline; margin:15px;">
            <div class="col-12" style="padding: 0px; color:#777;">
              <!-- Nav arrow -->
              <div class="vid-slide-left" style="text-align:center;line-height:50px;" onclick="less(this)">
                <b><i class="flaticon-back" style="position:relative;left:10px;"></i></b>
              </div>
              <div class="vid-slide-right" style="text-align:center;line-height:50px;" onclick="more(this)">
                <b><i class="flaticon-next" style="position:relative;left:10px;"></i></b>
              </div>
              <!-- End Nav arrow -->
              <div class="col-12 vid no-pad" style="display: flex;overflow-x:hidden;" >
                <!-- Vid Cards -->
                <div class="vid-slide" style="display: flex;position:relative;">
                  <!-- End new card -->
                  <?php
                  //$database->bind(":id",2);
                  $rows = $database->resultset($value);
                  //print_r($rows);
                  foreach ($rows as $row) {
                   ?>
                   <a href="./pages/watchvideo.php?watch_id=<?php echo $row['unique_id'] ?>">
                    <div class="vid-card">
                      <div class="">
                        <img src="./<?php echo $row["thumbnail"]; ?> " alt="" class="vid-thumbnail">
                      </div>
                      <div style="height:40.935%;padding-top: 5px;">
                        <div style="height:32px;line-height:16px;padding-left:2px;padding-right:10px;font-size: 01em;font-weight: bold;">
                          <?php echo $row["title"]; ?>
                        </div>
                        <div class="font-xxs" style="height:32px;line-height:16px;padding-left:2px;padding-right:10px;">
                          <br><?php echo $row["name"]; ?>
                        </div>
                        <div class="font-xxs" style="line-height:16px;padding-left:2px;padding-right:10px;">
                          <?php viewCount($row['views']);?> <b>&#183;</b> <?php echo timeAgo($row['published']); ?>
                        </div>
                      </div>
                    </div>
                  </a>
                  <?php } ?>
                  <!-- End new card -->
                </div>
                <!-- End of Vid Cards -->
              </div>
            </div>
          </div>
          <div class="row separator">
            <div class="col-12" style="border-top: 1px solid rgba(170,170,170,0.3);">

            </div>
          </div>
        </div>
        <!-- End of Videos Rows-->
        <?php } ?>
      </div>
    </div>
  </div>
  <!-- End of Main Body -->


  </body>
</html>
