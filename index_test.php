<!DOCTYPE html>
<html>
  <head>
    <!-- CSS -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- End of CSS -->

    <!-- Icon -->
      <link rel="icon" href="./res/img/icon.png">
    <!-- End of Icon -->

    <!-- Title -->
      <title>Tulsi Care</title>
    <!-- End of Title -->

    <!-- CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="./res/font/icon/flaticon.css">
    <!-- End of CSS -->

    <!-- JavaScript -->
      <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    <!-- End of JavaScript -->

    <!-- Color theme -->
      <link rel="stylesheet" href="./css/style.css">
    <!-- End of Color Theme -->
    <!-- Script -->
    <script>
      $(document).ready(function(){
          $("#menu").click(function(){
            $("#side-menu").fadeToggle(20);
          });
          console.log($(".vid-slide"));
          var vid_body = $(".vid").width()+30;
          var max_vid_width = $(".vid-slide").width();
          console.log(vid_body);
          console.log(max_vid_width);
          if(max_vid_width < vid_body){
            $(".vid-slide-right").css("display","none");
            $(".vid-slide-left").css("display","none");
          }
          else {
            $(".vid-slide-right").css("display","block");
          }
      });
      function more(element) {
        var e =$(element).parent().children(".vid").children(".vid-slide");
        var total_vid=e.width()/218;
        var vid_body = $(".vid").width();
        console.log(vid_body);
        var max_vid_width = e.width();
        var vid_hidden=(max_vid_width-vid_body)/218;
        var check =vid_hidden*218;
        if( check!= e.css("left").slice(0,-2)*-1 && check > e.css("left").slice(0,-2)*-1 ){
          e.animate({left:'-=218px'},200);
          $(element).siblings(".vid-slide-left").css("display","block");
        }
        if (check < e.css("left").slice(0,-2)*-1) {
          e.animate({left:(-1*check)+"px"},200);
          $(element).css("display","none");
        }
        if(check  -  e.css("left").slice(0,-2)*-1 <= 218 ){
          e.animate({left:(-1*check)+"px"},200);
          $(element).css("display","none");
        }
      }
      function less(element) {
        var e =$(element).parent().children(".vid").children(".vid-slide");
        var total_vid=e.width()/218;
        var vid_body = $(".vid").width();
        var max_vid_width = e.width();
        var vid_hidden=(max_vid_width-vid_body)/218;
        var check = 0;
        if( check!=  e.css("left").slice(0,-2) && check >  e.css("left").slice(0,-2) ){
           e.animate({left:'+=218px'},200);
          $(element).siblings(".vid-slide-right").css("display","block");
        }
        if(check <  e.css("left").slice(0,-2) ){
           e.animate({left:'0px'},200);
          $(element).css("display","none");
        }
        if(check -  e.css("left").slice(0,-2) <= 218 ){
           e.animate({left:(0)+"px"},200);
          $(element).css("display","none");
        }
      }
    </script>
    <!-- End of Script-->
  </head>
  <body>

  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-sm bg-light navbar-light sticky-top" style="box-shadow: 0 0 8px rgba(0,0,0,0.5);">
    <div class="container-fluid" style="height: 46px;">
      <div class="  col-md-8 col-5">
        <ul class="navbar-nav" style="flex-direction: row;">
          <li class="nav-item">
            <!-- Tulsi MENU -->
            <a class="navbar-brand dark-icon" id="menu">
              <i class="flaticon-line-menu font-xs"></i>
            </a>
          </li>
          <!-- End of Tulsi MENU -->
          <!-- Tulsi LOGO -->
          <li class="nav-item">
            <a class="navbar-brand" href="#" style="margin-right:5px;">
              <img src="./res/img/icon.png" alt="Logo" style="width:1.8em;margin-left:1em;">
            </a>
          </li>
          <!-- End of Tulsi LOGO -->
          <!-- Tulsi Title -->
          <li class="nav-item">
            <a class="navbar-brand" id="brand-title" href="#">Tulsi Care</a>
          </li>
          <!-- End of Tulsi Tulsi -->
          <!-- Search Bar -->
          <li class="nav-item" style="width:50%;line-height: 46px;" >
            <form class="form-inline  show-search" id="search" action="/action_page.php" >
              <div class="input-group" style="width:100%;">
                <input type="text" class="form-control" placeholder="Search"/>
                <button class="input-group-addon" type="submit" style="cursor:pointer;padding: 5px;"> <i class="flaticon-search font-xxs" style="position:relative;left:10px;color:#777;"></i></button>
              </div>
            </form>
          </li>
          <!-- End of Search Bar -->
        </ul>
      </div>
      <!-- Links -->
        <div class="  col-md-4 col-7" style="padding: 0px;">
          <ul class="navbar-nav " id="links" style="float:right; flex-direction: row;" >
            <!-- Search Button -->
            <li class="nav-item search-icon">
              <a class="navbar-brand dark-icon no-pad-l no-pad-r" href="#">
                <i class="flaticon-search font-xs"></i>
              </a>
            </li>
            <!-- End of Search Button -->
            <li class="nav-item btn-group">
              <a class="navbar-brand dark-icon dropdown-toggle-split no-pad-l no-pad-r" data-toggle="dropdown">
                <i class="flaticon-shapes font-xs" ></i>
              </a>
                <div class="dropdown-menu dropdown-menu-right " style="top:49px;">
                  <h5 class="dropdown-header font-m">Categories</h5>
                  <a class="dropdown-item" href="#">Cardiology</a>
                  <a class="dropdown-item" href="#">Endocrinology</a>
                  <a class="dropdown-item" href="#">Gastroenterology</a>
                  <a class="dropdown-item" href="#">Geriatrics</a>
                  <a class="dropdown-item" href="#">Hematology</a>
                  <a class="dropdown-item" href="#">Microbiology </a>
                  <a class="dropdown-item" href="#">neurology</a>
                  <a class="dropdown-item" href="#">Radiobiology</a>
                </div>

            </li>
            <li class="nav-item">
              <a class="navbar-brand dark-icon no-pad-l no-pad-r" href="#">
                <i class="flaticon-arrow font-xs"></i>
              </a>
            </li>
            <li class="nav-item btn-group">
              <a class="navbar-brand dark-icon dropdown-toggle-split no-pad-l no-pad-r" data-toggle="dropdown">
                <i class="flaticon-button-of-three-vertical-squares font-xs" ></i>
              </a>
                <div class="dropdown-menu dropdown-menu-right" style="top:49px;">
                  <a class="dropdown-item" href="#">Update Profile</a>
                  <a class="dropdown-item" href="#">Add Family Member</a>
                  <a class="dropdown-item" href="#">Clinical Record</a>
                  <a class="dropdown-item" href="#">Subscriptions</a>
                  <a class="dropdown-item" href="#">Privacy Policy</a>
                  <a class="dropdown-item" href="#">Terms and Conditions</a>
                  <a class="dropdown-item" href="#">Support</a>
                  <a class="dropdown-item" href="#">FAQs</a>
                  <a class="dropdown-item" href="#">Sign Out</a>
                </div>

            </li>
            <li class="nav-item active no-pad-l no-pad-r">
              <a class="nav-link" href="#" style="padding-left: 5px  !important;">SIGN IN</a>
            </li>
          </ul>
        </div>
      <!-- End of Links -->
    </div>
  </nav>
  <!-- End of Navigation Bar -->
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
        <!-- Videos Row 1-->
        <div class="container vid-row" style="margin-top: 20px;display: flex;justify-content: center;flex-direction: row;flex-wrap: wrap;" >
          <div class="row vid-row-title">
            <div class="col-12 font-m no-pad" style="display:inline;text-align:left;">
              News Feed
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
                  <div class="vid-card">
                    <div class="">
                      <img src="./res/img/thumbnail/di1.webp" alt="" class="vid-thumbnail">
                    </div>
                    <div style="height:40.935%;padding-top: 5px;">
                      <div style="height:32px;line-height:16px;padding-left:2px;padding-right:10px;font-size: 01em;font-weight: bold;">
                        The perfect treatment for diabetes and weight loss
                      </div>
                      <div class="font-xxs" style="height:32px;line-height:16px;padding-left:2px;padding-right:10px;">
                        <br>Dr. K.P. Singh
                      </div>
                      <div class="font-xxs" style="line-height:16px;padding-left:2px;padding-right:10px;">
                        1.2K views <b>&#183;</b> 3 months ago
                      </div>
                    </div>
                  </div>
                  <!-- End new card -->
                  <!-- End new card -->
                  <div class="vid-card">
                    <div class="">
                      <img src="./res/img/thumbnail/di1.webp" alt="" class="vid-thumbnail">
                    </div>
                    <div style="height:40.935%;padding-top: 5px;">
                      <div style="height:32px;line-height:16px;padding-left:2px;padding-right:10px;font-size: 01em;font-weight: bold;">
                        The perfect treatment for diabetes and weight loss
                      </div>
                      <div class="font-xxs" style="height:32px;line-height:16px;padding-left:2px;padding-right:10px;">
                        <br>Dr. K.P. Singh
                      </div>
                      <div class="font-xxs" style="line-height:16px;padding-left:2px;padding-right:10px;">
                        1.2K views <b>&#183;</b> 3 months ago
                      </div>
                    </div>
                  </div>
                  <!-- End new card -->
                  <!-- new card -->
                  <div class="vid-card">
                    <div class="">
                      <img src="./res/img/thumbnail/di.webp" alt="" class="vid-thumbnail">
                    </div>
                    <div style="height:40.935%;padding-top: 5px;">
                      <div style="height:32px;line-height:16px;padding-left:2px;padding-right:10px;font-size: 01em;font-weight: bold;">
                        Expert Advise to Diabetics
                      </div>
                      <div class="font-xxs" style="height:32px;line-height:16px;padding-left:2px;padding-right:10px;">
                        <br>Dr. K.P. Singh
                      </div>
                      <div class="font-xxs" style="line-height:16px;padding-left:2px;padding-right:10px;">
                        1.2K views <b>&#183;</b> 3 months ago
                      </div>
                    </div>
                  </div>
                  <!-- End new card -->
                  <!-- new card -->
                  <div class="vid-card">
                    <div class="">
                      <img src="./res/img/thumbnail/deep.webp" alt="" class="vid-thumbnail">
                    </div>
                    <div style="height:40.935%;padding-top: 5px;">
                      <div style="height:32px;line-height:16px;padding-left:2px;padding-right:10px;font-size: 01em;font-weight: bold;">
                        Deep Learning Frameworks Compared
                      </div>
                      <div class="font-xxs" style="height:32px;line-height:16px;padding-left:2px;padding-right:10px;">
                        <br>Dr. N.P. Singh
                      </div>
                      <div class="font-xxs" style="line-height:16px;padding-left:2px;padding-right:10px;">
                        4.6K views <b>&#183;</b> 1 day ago
                      </div>
                    </div>
                  </div>
                  <!-- End new card -->
                  <!-- new card -->
                  <div class="vid-card">
                    <div class="">
                      <img src="./res/img/thumbnail/cold.webp" alt="" class="vid-thumbnail">
                    </div>
                    <div style="height:40.935%;padding-top: 5px;">
                      <div style="height:32px;line-height:16px;padding-left:2px;padding-right:10px;font-size: 01em;font-weight: bold;">
                        How to Cure a Cold Fast
                      </div>
                      <div class="font-xxs" style="height:32px;line-height:16px;padding-left:2px;padding-right:10px;">
                        <br>Dr. Joe Alex
                      </div>
                      <div class="font-xxs" style="line-height:16px;padding-left:2px;padding-right:10px;">
                        1M views <b>&#183;</b> 2 year ago
                      </div>
                    </div>
                  </div>
                  <!-- End new card -->
                  <!-- new card -->
                  <div class="vid-card">
                    <div class="">
                      <img src="./res/img/thumbnail/hair.webp" alt="" class="vid-thumbnail">
                    </div>
                    <div style="height:40.935%;padding-top: 5px;">
                      <div style="height:32px;line-height:16px;padding-left:2px;padding-right:10px;font-size: 01em;font-weight: bold;">
                        What to eat for healthy hair
                      </div>
                      <div class="font-xxs" style="height:32px;line-height:16px;padding-left:2px;padding-right:10px;">
                        <br> Dr. Rajput
                      </div>
                      <div class="font-xxs" style="line-height:16px;padding-left:2px;padding-right:10px;">
                        17K views <b>&#183;</b> 8 months ago
                      </div>
                    </div>
                  </div>
                  <!-- End new card -->
                </div>
                <!-- End of Vid Cards -->
              </div>
            </div>
          </div>
          <div class="row separator" style="margin-left: 19px;">
            <div class="col-12" style="border-top: 1px solid rgba(170,170,170,0.3);">

            </div>
          </div>
        </div>
        <!-- End of Videos Row 1-->

      </div>
    </div>
  </div>
  <!-- End of Main Body -->
  </body>
</html>
