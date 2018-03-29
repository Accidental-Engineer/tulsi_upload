<!DOCTYPE html>
<html>
  <head>
    <!-- CSS -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- End of CSS -->

    <!-- Icon -->
      <link rel="icon" href="../res/img/icon.png">
    <!-- End of Icon -->

    <!-- Title -->
      <title>Tulsi Care</title>
    <!-- End of Title -->

    <!-- CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="../res/font/icon/flaticon.css">
    <!-- End of CSS -->

    <!-- JavaScript -->
      <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    <!-- End of JavaScript -->

    <!-- Color theme -->
      <link rel="stylesheet" href="../css/style.css">
      <link rel="stylesheet" href="../css/form.css">
      <style>
        .profile-pic-box{
          background: white;
          width: 120px;
          padding: 10px;
          box-sizing: border-box;
          box-shadow: 0 0 2px gray;
          margin: 25px;
        }
        .container-class > div {
          box-shadow: 0 0 2px gray;
          box-sizing: border-box;
        }
      </style>
    <!-- End of Color Theme -->
    <!-- Script -->
    <script>
      $(document).ready(function(){
          $("#menu").click(function(){
            $("#side-menu").fadeToggle(20);
          });
          console.log($(".vid-slide").width()/218);
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
              <img src="../res/img/icon.png" alt="Logo" style="width:1.8em;margin-left:1em;">
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
            <form class="form-inline  show-search" id="search" action="../action_page.php" >
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
                <div class="dropdown-menu dropdown-menu-right">
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
                <div class="dropdown-menu dropdown-menu-right">
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
    <div class = "row container-class">
    <div class = "col-md-4 col-sm-6 col-xs-12">
      <center><div class = "profile-pic-box">
        <img class = "img img-respopnsive" src = "http://graph.facebook.com/1205259932907949/picture?type=normal"/><!-- https://lh6.googleusercontent.com/-ZQnzMVcsF80/AAAAAAAAAAI/AAAAAAAAAIM/tF0uN5Kjek0/s96-c/photo.jpg-->
        <div class = "user-name">@skshivam64</div>
      </div></center>
    </div>
    <div class = "col-md-4 col-sm-6 col-xs-12">
      <div class = "form-2 row col-md-12 container-fluid" id = "contact">

          <div class="group">
            <input required="" type="text"><span class="highlight"></span><span class="bar"></span><label>First Name</label>
          </div>
          <div class="group">
            <input required="" type="text"><span class="highlight"></span><span class="bar"></span><label>Last Name</label>
          </div>
          <div class="group">
            <input required="" type="text"><span class="highlight"></span><span class="bar"></span><label>Email</label>
          </div>
          <div class="group">
            <input required="" type="password"><span class="highlight"></span><span class="bar"></span><label>Password</label>
          </div>
          <div class="group">
            <input required="" type="password"><span class="highlight"></span><span class="bar"></span><label>Retype Password</label>
          </div>
          <!--<div class="group">
            <input required="" type="date"><span class="highlight"></span><span class="bar"></span><label>D.O.B.</label>
          </div>-->
          <input id="sendMessage" name="sendMessage" type="submit" value="Register">
    </div>

    </div>
    <div class = "col-md-4 col-sm-6 col-xs-12">
      <div class = "form-2 row col-md-12 container-fluid" id = "contact">

          <div class="group">
            <input required="" type="text"><span class="highlight"></span><span class="bar"></span><label>First Name</label>
          </div>
          <div class="group">
            <input required="" type="text"><span class="highlight"></span><span class="bar"></span><label>Last Name</label>
          </div>
          <div class="group">
            <input required="" type="text"><span class="highlight"></span><span class="bar"></span><label>Email</label>
          </div>
          <div class="group">
            <input required="" type="password"><span class="highlight"></span><span class="bar"></span><label>Password</label>
          </div>
          <div class="group">
            <input required="" type="password"><span class="highlight"></span><span class="bar"></span><label>Retype Password</label>
          </div>
          <!--<div class="group">
            <input required="" type="date"><span class="highlight"></span><span class="bar"></span><label>D.O.B.</label>
          </div>-->
          <input id="sendMessage" name="sendMessage" type="submit" value="Register">

    </div>
    </div>
  </div>
  </div>
  <!-- End of Main Body -->
  </body>
</html>
