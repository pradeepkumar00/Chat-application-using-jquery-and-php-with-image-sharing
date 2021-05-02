<?php

include('database_connection.php');

session_start();

if(!isset($_SESSION['user_id']))
{
 header("location:login.php");
}

unset($_SESSION['imgname']);

?>

<html>  
    <head>  
        <title>Hi - <?php echo $_SESSION['username'];  ?></title>  
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
         <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 
    <style>
* {
  box-sizing: border-box;
}
.mm{
    width: 90%;
    margin: 10px;
}
.colmr {
  float: right;
  width: 60%;
  height: 60px;
  padding: 0px;
  height: 80%;
  background: #bbb;
    position: fixed;
  height: 80% !important;
  bottom: 30;
  right: 30;/* Should be removed. Only for demonstration */
}
  .colnr{
      width: 30%;
       position: fixed;
  height: 80% !important;
  overflow-y: scroll;
  bottom: 30;
  left: 30;
  }
  .column {
  float: left;
  width: 60%;
  height: 60px;
  padding: 10px;
  /* Should be removed. Only for demonstration */
}
.column h2 {
    margin-top: 5px;
    white-space: nowrap
}
.column1 {
  float: left;
  width: 15%;
  height: 60px;
  padding: 0px; /* Should be removed. Only for demonstration */
}
.column2 {
  float: left;
  width: 25%;
  height: 60px;
  padding: 0px; /* Should be removed. Only for demonstration */
}
.btn{
    margin-top: 0px !important;
    font-size: 13px;
}
.start_chat{
    display: none;
}
.start_chat1{
    display: block;
}
.ups{
    display: block; 
    width: 91px;
}
@media only screen and (max-width: 1000px){
  .colmr {
  display: none;
  
}
  .colnr{
      width: 93%;
  }
  .column {
  float: left;
  width: 60%;
  height: 80px;
  padding: 10px;
  /* Should be removed. Only for demonstration */
}
.column h2 {
    margin-top: 5px;
    font-size: 40px;
}
.column1 {
  float: left;
  width: 15%;
  height: 80px;
  padding: 0px; /* Should be removed. Only for demonstration */
}
.column2 {
  float: left;
  width: 25%;
  height: 80px;
  padding: 0px; /* Should be removed. Only for demonstration */
}
.btn{
    margin: auto;
    margin-top: 0px !important;
    width: 150px;
    height: 50px;
    font-size: 30px;
}
.start_chat{
    display: block;
}
.start_chat1{
    display: none;
}
.ui-dialog{
    height: 98% !important;
    width: 98% !important;
    background-color: #fff;
    position: fixed;
    top: 2 !important;
    font-size: 40px;
    display: block;

}
.wr{
    height: auto !important;
}
.ups{
    display: block; 
    width: 150px;
    margin-right: 15px;
}
.ui-dialog .ui-dialog-titlebar-close {
    width: 40px !important;
    height: 40px !important;
}
.chat_d{
    height: 75%; 
    border:1px solid #ccc; 
    overflow-y: scroll; 
    margin-bottom:2px; 
    padding:16px;
}
}
@media screen and (max-height: 1000px) {
  .ui-dialog{
    height: 100% !important;
  }
  .chat_d{
    height: 55%; 
    border:1px solid #ccc; 
    overflow-y: scroll; 
    margin-bottom:2px; 
    padding:16px;
}
}



</style>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>

    </head>  
    <body>  
       
   <div align="center" style="background-color: #00ffcc; width: 300px; margin: 10px auto; border-radius: 10px;padding: 5px;">
   <h3>Chat Boot Application</a></h3>
    <p align="center">Hi - <?php echo $_SESSION['username'];  ?> - <a href="logout.php">Logout</a></p>
   </div>
   
    <div class="mm">
    <div id="user_details" class="colnr"></div>
    <div class="colmr">
    <div id="user_model_details" ><div style="text-align: center; margin-top: 50px; color: #fff"><i class="glyphicon glyphicon-home w3-text-white w3-xxxlarge"></i><br>
    <h2>Ciick to start chat</h2></div></div></div>
    </div>
    </body>  
</html> 
<script>  
$(document).ready(function(){

 fetch_user();

 setInterval(function(){
  update_last_activity();
  fetch_user();
  update_chat_history_data();
 }, 5000);

 function fetch_user()
 {
  $.ajax({
   url:"fetch_user.php",
   method:"POST",
   success:function(data){
    $('#user_details').html(data);
   }
  })
 }

 function update_last_activity()
 {
  $.ajax({
   url:"update_last_activity.php",
   success:function()
   {

   }
  })
 }
  function make_chat_dialog_box(to_user_id, to_user_name)
 {
  var modal_content = '<div id="user_dialog_'+to_user_id+'" title="You have chat with '+to_user_name+'">';
  modal_content+='<h4 style="margin-left: 20px; color: #fff;">You have chat with '+to_user_name+'</h4>';
  modal_content += '<div style="height: 75%; border:1px solid #ccc; overflow-y: scroll; margin-bottom:2px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
  modal_content += '</div>';
  modal_content += '<div class="form-group">';
  modal_content+= '<form id="uploaded_image" method="post" action="upload.php" style="margin:0px 15px; width: 120px; float: left;" enctype="multipart/form-data">';
  modal_content+= '<input type="file" name="file" id="file" accept=".jpg, .png" style="display: block; width: 91px;"/></form>';
  modal_content += '<textarea name="chat_message_'+to_user_id+'" style="width: 80%; height: 60px; float: right; resize: none; margin-right: 10px;" id="chat_message_'+to_user_id+'" class="form-control"></textarea>';
  modal_content += '</div><br><br><br><div class="form-group" align="right">';
  modal_content+= '<button type="button" style="margin-right: 40px; height: 50px;" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat">Send</button></div></div>';
  $('#user_model_details').html(modal_content);
    
 }
  function make_chat_dialog_box1(to_user_id, to_user_name)
 {
  var modal_content = '<div id="user_dialog_'+to_user_id+'" class="wr" title="You have chat with '+to_user_name+'">';
  modal_content+='<h4 style="margin-left: 20px; color: #fff;">You have chat with '+to_user_name+'</h4>';
  modal_content += '<div class="chat_history chat_d" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
  modal_content += '</div>';
  modal_content += '<div class="form-group">';
  modal_content += '<textarea name="chat_message_'+to_user_id+'" style="width: 80%; height: 120px; float: right; resize: none; margin-right: 10px;" id="chat_message_'+to_user_id+'" class="form-control"></textarea>';
  modal_content += '</div>';
  modal_content+= '<form id="uploaded_image" method="post" action="upload.php" style="margin:0px 15px; width: 120px; float: left;" enctype="multipart/form-data">';
  modal_content+= '<input type="file" name="file" id="file" accept=".jpg, .png" class="ups"/></form>';
  modal_content+= '<div class="form-group" align="right"><button type="button" style="margin: 20px !important; height: 80px;" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat">Send</button></div></div>';
  $('#user_model_details').html(modal_content);
    
 }
 $(document).on('click', '.start_chat1', function(){
  var to_user_id = $(this).data('touserid');
  var to_user_name = $(this).data('tousername');
  fetch_user_chat_history(to_user_id)
  make_chat_dialog_box(to_user_id, to_user_name);
  $.ajax({
   url:"reset.php",
  })
  
  });
  
  $(document).on('click', '.start_chat', function(){
  var to_user_id = $(this).data('touserid');
  var to_user_name = $(this).data('tousername');
  make_chat_dialog_box1(to_user_id, to_user_name);
  $.ajax({
   url:"reset.php",
  })
  $("#user_dialog_"+to_user_id).dialog({
   autoOpen:false,
   width:400
  });
  $('#user_dialog_'+to_user_id).dialog('open');
 });
 
 
 $(document).on('click', '.send_chat', function(){
  var to_user_id = $(this).attr('id');
  var chat_message = $('#chat_message_'+to_user_id).val();
  $.ajax({
   url:"insert_chat.php",
   method:"POST",
   data:{to_user_id:to_user_id, chat_message:chat_message},
   success:function(data)
   {
    $('#chat_message_'+to_user_id).val('');
    $('#chat_history_'+to_user_id).html(data);
    $('#uploaded_image').html('<input type="file" name="file" id="file" accept=".jpg, .png" style="display: block; width: 91px;"/>');
   }
  })
 });
 function fetch_user_chat_history(to_user_id)
 {
  $.ajax({
   url:"fetch_user_chat_history.php",
   method:"POST",
   data:{to_user_id:to_user_id},
   success:function(data){
    $('#chat_history_'+to_user_id).html(data);
   }
  })
 }
 function update_chat_history_data()
 {
  $('.chat_history').each(function(){
   var to_user_id = $(this).data('touserid');
   fetch_user_chat_history(to_user_id);
  });
 }

 $(document).on('click', '.ui-button-icon', function(){
  $('.user_dialog').dialog('destroy').remove();
 });
  $(document).on('focus', '.form-control', function(){
  var is_type = 'yes';
  $.ajax({
   url:"update_is_type_status.php",
   method:"POST",
   data:{is_type:is_type},
   success:function()
   {

   }
  })
 });

 $(document).on('blur', '.form-control', function(){
  var is_type = 'no';
  $.ajax({
   url:"update_is_type_status.php",
   method:"POST",
   data:{is_type:is_type},
   success:function()
   {
    
   }
  })
 });
 $(document).on('change', '#file', function(){
  var name = document.getElementById("file").files[0].name;
  var form_data = new FormData();
  var ext = name.split('.').pop().toLowerCase();
  if(jQuery.inArray(ext, ['png','jpg','jpeg']) == -1) 
  {
      Swal.fire("File extanstion is not a jpg, png or jpeg", "Please upload a jpg, png or jpeg!", "error");
  }
  else{
  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("file").files[0]);
  var f = document.getElementById("file").files[0];
  var fsize = f.size||f.fileSize;
  if(fsize > 2000000)
  {
      Swal.fire("File size is greater than 2MB", "Please upload below 2MB file!", "error");
  }
  else
  {
   form_data.append("file", document.getElementById('file').files[0]);
   $.ajax({
    url:"upload.php",
    method:"POST",
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend:function(){
     $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
    },
    success:function(data)
    {
     $('#uploaded_image').html(data);
    }
   });
  }
  }
 });

});  
</script>