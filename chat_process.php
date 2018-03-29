<?php
if (isset($_POST['userResponse']) && $_POST['userResponse'] !="") {
  $JSON_responce = array('{"question":"Do you have headache?","options":["Yes","No","Not Sure"]}',
  '{"question":"How long has this been troubling you?","options":["Less than one day","One day to one week","One week to one month","One month to one yesr","More than one year"]}',
  '{"question":"Is your headache mainly located on on or both side of the head?","options":["Both side","One side","Not Sure"]}',
  '{"question":"Is it throbbing headache?","options":["Yes","No","Not Sure"]}'
  ,'{"question":"How does bending forward affect your headache?","options":["Worsens","No effect","Not Sure"]}'
  ,'{"question":"how would you describe the intensity of your headache?","options":["Mild","Moderate","Severe","I don\'t know"]}'
  ,'{"question":"Do you have other symptoms?","options":["Yes","No"]}'
  );
  //$val = rand(10,100);
  echo $JSON_responce[rand(0,6)];
  //echo $_POST['userResponse'];
}
?>
