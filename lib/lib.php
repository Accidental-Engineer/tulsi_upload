<?php

$categoryMap = array('category' => 0,'Health' => 1,'Life Style' => 2,'Aaurveda' => 3 );
date_default_timezone_set('Asia/Calcutta');

//function for view count
function viewCount($val){
  if ($val>=0 && $val < 1000) {
    echo $val." views";
  }
  if ($val>=1000 && $val < 1000000) {
    if (number_format((float)$val/1000, 1, '.', '') < 10) {
      echo number_format((float)$val/1000, 1, '.', '')."K views";
    }
    else {
      echo number_format((float)$val/1000)."K views";
    }
  }
  if ($val>=1000000 && $val < 1000000000) {
    if (number_format((float)$val/1000, 1, '.', '') < 10) {
      echo number_format((float)$val/1000000, 1, '.', '')."M views";
    }
    else {
      echo number_format((float)$val/1000000)."M views";
    }

  }
  if ($val>=1000000000) {
    if (number_format((float)$val/1000, 1, '.', '') < 10) {
      echo number_format((float)$val/1000000000, 1, '.', '')."B views";
    }
    else {
      echo number_format((float)$val/1000000000)."B views";
    }

  }
}

//Time ago function
function timeAgo($val){
  $days = (time()-strtotime($val))/60/60/24;
  if ($days < 1) {
    $time = (time()-strtotime($val))/60/60;
    if ($time*60 < 1) {

      $time ="Just now";
    }
    elseif ($time < 1) {
       $time = floor((time()-strtotime($val))/60);
       if ($time==1) {
         $time .=" mins ago";
       }
       else {
         $time .=" mins ago";
       }
    }
    else {
      $time = floor((time()-strtotime($val))/60/60);
      if ($time == 1) {
        $time .=" hour  ago";
      }
      else {
        $time .=" hours  ago";
      }
    }
  }
  elseif ($days < 30 && $days >= 1) {
    $time = floor((time()-strtotime($val))/60/60/24);
    if ($time==1) {
      $time .=" day  ago";
    }
    else {
      $time .=" days  ago";
    }
  }
  elseif ($days < 365 && $days >= 30) {
    $time = floor((time()-strtotime($val))/60/60/24/30);
    if ($time==1) {
      $time .=" month  ago";
    }
    else {
      $time .=" months  ago";
    }
  }
  elseif ($days > 365) {
    $time = floor((time()-strtotime($val))/60/60/24/365);
    if ($time==1) {
      $time .= " year  ago";
    }
    else {
      $time .= " years  ago";
    }
  }
  return $time;
}

//For video processing
require '/vendor_ffmpeg/autoload.php';
function encodeVideo($file_config){
  $ffmpeg = FFMpeg\FFMpeg::create(array(
      'ffmpeg.binaries'  => 'C:/ffmpeg/bin/ffmpeg.exe',
      'ffprobe.binaries' => 'C:/ffmpeg/bin/ffprobe.exe',
  	  'timeout'          => 3600, // The timeout for the underlying process
      'ffmpeg.threads'   => 36,   // The number of threads that FFMpeg should use
  ));
  $i=0;
  $p=0;
  $base_progress_percent = 33.33;
  $quality_type = $file_config["quality"];
  $file_name = $file_config["name"];
  $location = $file_config["location"];
  $save = $file_config["save_loaction"];
  $thumbnail = "../res/img/thumbnail/".$file_name;
  if ($quality_type == "all") {
    $q  = array("high", "low" ,"med");
    $_SESSION['vid_q'] = 3 ;
    $_SESSION['vid_c'] = 0 ;
  }
  else {
    $q  = array($quality_type);
    $_SESSION['vid_q'] = 1 ;
  }
  foreach ($q as  $value) {
    $quality = $value;
    $width = 0;
    $height = 0;
    $bitrate =0;
    $audio_channel = 2;
    $audio_bitrate = 0;


    if ($quality == "high") {
      $width = 1280;
      $height = 720;
      $bitrate = 1856;
      $audio_bitrate = 128;
      $save_location = $save."high.mp4";
    }
    else if ($quality == "med") {
      $width = 848;
      $height = 480;
      $bitrate = 1216;
      $audio_bitrate = 64;
      $save_location = $save."med.mp4";
    }
    else if ($quality == "low") {
      $width = 424;
      $height = 240;
      $bitrate = 576;
      $audio_bitrate = 64;
      $save_location = $save."low.mp4";
    }
    $video = $ffmpeg->open($location);
    $video
        ->filters()
        ->resize(new FFMpeg\Coordinate\Dimension($width, $height))
        ->synchronize();
    if ($quality=="high"){
      $video
          ->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(10))
          ->save($thumbnail);
    }


    // $format = new FFMpeg\Format\Video\X264();
    // $format->on('progress', function ($video, $format, $percentage) {
    //   @session_start();
    //   if ($_SESSION['vid_q']==3) {
    //     $percentage = ($_SESSION['vid_c']*33.33)+($percentage/3);
    //   }
    //   $_SESSION['progress_percent'] = ceil($percentage);
    //   @session_write_close();
    // });
    // $format->setAudioCodec("libmp3lame")
    // 		->setKiloBitrate($bitrate)
    //     ->setAudioChannels($audio_channel)
    //     ->setAudioKiloBitrate($audio_bitrate);
    // $video
    //     ->save($format,$save_location);
    if ($quality_type == "all") {
    $t = $_SESSION['vid_c'] ;
    @session_start();
    $_SESSION['vid_c'] = $t+1;
  }
    }
    return 1;
}

//generation video name
function genVidName(){
    $string='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefhijklmnopqrstuvwxyz1234567890';
    $string_shuff=str_shuffle($string);
    $name = substr($string_shuff,0,16);
    return $name;
}


?>
