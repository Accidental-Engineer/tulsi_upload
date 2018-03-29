<?php
session_start();
//if(!isset($_SESSION['id'])) header('Location: ./login.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Profile</title>
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
    <!--<link rel="stylesheet" href="css/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../res/font/icon/flaticon.css">
  <!-- End of CSS -->

  <link rel = "stylesheet" href = "https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- JavaScript -->
    <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
  <!-- End of JavaScript -->

  <!-- Color theme -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/form.css">
  <!-- End of Color Theme -->
  <style>
  .social-icons{
    border-top: 5px solid #1abc9c;
    padding: 10px;
    width: 200px;
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
    text-align: center;
    margin-left: auto;
  	margin-right: auto;
  	display: block;
  }
  .social-icons i{
    color: #1abc9c;
    margin: 5px;
    padding: 5px;
    background: white;
    border-radius: 50%;
    height: 30px;
    width: 30px;
    line-height: 20px;
  }
  .utility-icons{
    padding: 10px;
    width: 200px;
    text-align: center;
    margin-left: auto;
  	margin-right: auto;
  	display: block;
  }
  .utility-icons i{
    color: white;
    margin: 2px;
    padding: 7px;
    background: #1abc9c;
    border-radius: 5px;
    height: 34px;
    width: 34px;
    line-height: 20px;
  }
  .profile-pic-container{
    padding: 15px;
  }
  .profile-pic-container img{
    border: 5px solid #1abc9c;
    height: 150px;
    width: 150px;
    border-radius: 75px;
    margin-left: auto;
  	margin-right: auto;
  	display: block;
  }
  .profile-name{
    font-size: 150%;
    text-align: center;
  }
  .profile-designation{
    font-size: 90%;
    text-align: center;
  }
  .bar{
    width: 30%;
    height: 1px;
    background: #1abc9c;
    margin-left: auto;
  	margin-right: auto;
  	display: block;
  }
  .profile-info-container{
    background: white;
    min-height: 50px;
    border-top: 5px solid #1abc9c;
  }
  .prolink{
    padding-right: 15px;
    letter-spacing: 2px;
    color: #32465a;
  }
  .prolink:hover{
    color: #1abc9c;
    text-decoration: none;
  }
  </style>
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-sm bg-light navbar-light sticky-top" style="box-shadow: 0 0 8px rgba(0,0,0,0.5);">
    <div class="container-fluid">
      <div class="col-md-8 col-5">
        <ul class="navbar-nav" style="flex-direction: row;">
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
        </ul>
      </div>
      <!-- Links -->
        <div class="col-md-4 col-7" style="padding: 0px;">
          <ul class="navbar-nav " id="links" style="float:right; flex-direction: row;" >
            <li class="nav-item">
              <a class="navbar-brand dark-icon no-pad-l no-pad-r" href="#">
                <i class="flaticon-button-of-three-vertical-squares font-xs" ></i>
              </a>
            </li>

          </ul>
        </div>
      <!-- End of Links -->
    </div>
  </nav>
  <!-- End of Navigation Bar -->

  <div class="container-fluid" style = "position: absolute; top: 75px; min-width: 100%; background: #ecf0f1; min-height: 500px;">
    <div class = "row">
    <div class = "col-md-3 col-sm-4 col-xs-12" >
      <div class = "social-icons" style= "background: #16a085;"><i class = "fa fa-facebook"></i><i class = "fa fa-google-plus"></i><i class = "fa fa-twitter"></i></div>
      <div class = "profile-pic-container" style = ""><img src = "https://lh6.googleusercontent.com/-ZQnzMVcsF80/AAAAAAAAAAI/AAAAAAAAAIM/tF0uN5Kjek0/s96-c/photo.jpg"></div>
      <div class = "profile-name">SHIVAM<br>KUMAR</div>
      <hr class = "bar">
      <div class = "profile-designation">Neurologist</div>
      <div class = "utility-icons"><i class = "fa fa-upload"></i><i class = "fa fa-flag"></i><i class = "fa fa-eye"></i></div>
      <hr class = "bar">
    </div>
    <div class = "col-md-9 col-sm-8 col-xs-12">
      <div style = "width: 91%; margin-left: 2%; margin-right: 7%; border-top: 5px solid #1abc9c;">
          <div style = "min-width: 100%; padding-top: 15px; padding-bottom: 15px;"><a href = "#" class = "prolink">Profile</a><a href = "#" class = "prolink">Videos</a><a href = "#" class = "prolink">Blog</a><a href = "#" class = "prolink">Contact</a></div>
          <div style = "text-align: right; font-size: 130%; letter-spacing: 2px;">PROFILE</span>&nbsp;&nbsp;<i class = "fa fa-user-circle" aria-hidden = "true"></i></div>
          <div class = "profile-info container-fluid" style = "background: #fbfbfb;">
            <div class = "row">
              <div class = "col-md-6 col-xs-12" style = "text-align: center; border-right: 2px solid #ecf0f1; padding: 15px;">
                <h5><i class = "fa fa-user-circle"></i>&nbsp;&nbsp;Basic Information</h5>
                <small>Shivam Kumar<br>M.Sc - Anatomy<br>Genereal Physician<br>12 years experience<br></small>
              </div>
              <div class = "col-md-6 col-xs-12" style = "text-align: center; border-left: 2px solid #ecf0f1; padding: 10px;">
                <h5><i class = "fa fa-info-circle"></i>&nbsp;&nbsp;Profile Statement</h5>
                <p style = "text-align: justify;">I have served in variety of clinical branches and have extensive clinical experience. I have worked in the Department of Surgery and Department of Gynacology for five years.</p>
              </div>
            </div>
          </div>
          <div style = "text-align: right; font-size: 130%; letter-spacing: 2px;">VIDEOS</span>&nbsp;&nbsp;<i class = "fa fa-image" aria-hidden = "true"></i></div>
          <div class = "profile-info" style = "background: #fbfbfb;">Videos: dsjghjxksl</div>
          <div style = "text-align: right; font-size: 130%; letter-spacing: 2px;">BLOG</span>&nbsp;&nbsp;<i class = "fa fa-comment" aria-hidden = "true"></i></div>
          <div class = "profile-info" style = "background: #fbfbfb;">Blog: dsjghjxksl</div>
      </div>
    </div>

  </div>
  </div>
</body>
</html>
