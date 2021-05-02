<?php
    session_start(); 
//upload.php
if($_FILES["file"]["name"] != '')
{
 $test = explode('.', $_FILES["file"]["name"]);
 $ext = end($test);
 $name = rand(100, 99999) . '.' . $ext;
 
 $location = './upload/' . $name;
 move_uploaded_file($_FILES["file"]["tmp_name"], $location);
 echo '<img src="'.$location.'" width="225" class="img-thumbnail" />';
 $_SESSION['imgname']= '<img src="'.$location.'" width="225" class="img-thumbnail" />';
}
?>