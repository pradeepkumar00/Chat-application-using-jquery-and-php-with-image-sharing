<?php

include('database_connection.php');

session_start();

$message = '';
$msg=2;
if(isset($_SESSION['user_id']))
{
 header('location:index.php');
}

if(isset($_POST["login"]))
{
 $query = "SELECT * FROM login WHERE username = :username";
   $statement = $connect->prepare($query);
   $statement->execute(array(':username' => $_POST["username"]));
  $count = $statement->rowCount();
  if($count > 0)
 {
  $result = $statement->fetchAll();
    foreach($result as $row)
    {
      if($_POST["password"] == $row["password"])
      {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $sub_query = "INSERT INTO login_details (user_id) VALUES ('".$row['user_id']."')";
        $statement = $connect->prepare($sub_query);
        $statement->execute();
        $_SESSION['login_details_id'] = $connect->lastInsertId();
        $msg=1;
        header("location:index.php");
      }
      else
      {
       $message = "<label style='color: white'>Wrong Password</label>";
       $msg=0;
      }
    }
 }
 else
 {
  $message = "<label style='color: white'>Wrong Username</labe>";
  $msg=0;
 }
}

?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <script data-ad-client="ca-pub-3907182106244944" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Sikaredu</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">


  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  
    <style>
        .name{
            width: 300px;
        }
        .name input{
            width: 298px;
            height: 40px;
            border-radius: 5px;
            border: none;
        }
        .btn{
            height: 30px;
            width: 80px;
            background: #fff;
            margin: 10px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            
        }
    </style>
</head>

<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    <!-- header-start -->


        <!-- bradcam_area_start -->
       <div align="center" style="width: 100%; background: #0ffccc;font-size: 50px;">
            <h3>Login</h3>
        </div>
        <!-- bradcam_area_end -->
<div class="popup_box" style="width:100%; background: #0ffccc; " align="center">
            <div class="popup_inner"">
                 <?php
				  if($msg==1){
				  	echo '<script type="text/javascript">
  					swal("", "Registration successful", "success");
  					</script>';
  				}
  				elseif($msg==0) {
				  	echo '<script type="text/javascript">
  					swal("", "Something missing!", "info");
  					</script>';
				  }
                ?>

                <h3 style="text-align: center">Sign in</h3>
                <form method="post">
					<p style="color: white; text-align: center;"><?php echo $message; ?></p>
                    <div align="center">
                        <div class="name">
                            <input name="username" id="username" type="text"  placeholder="Enter username">
                        </div><br>
                        <div class="name">
                            <input name="password" id="password" type="password" placeholder="Password">
                        </div>
                        
						<div class="btn1" style="margin: auto">
                                <button type="submit" name="login" class="btn">Sign in</button>
                            </div></div>
                    </div>
                </form>
                <p class="doen_have_acc">Don’t have an account? <a href="signup.php">Sign Up</a>
                </p>
            </div>
        </div>
		
</body>

</html>
