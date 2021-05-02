<?php
session_start();
include('database_connection.php');

$message = '';
$msg=0;
if(isset($_SESSION['user_id']))
{
 header('location:index.php');
}

if(isset($_POST["register"])){
	 $email = trim($_POST["email"]);
	 $username = trim($_POST["username"]);
	 $password = trim($_POST["password"]);
	 $check_query = "SELECT * FROM login WHERE username = :username";
	 $statement = $connect->prepare($check_query);
	 $check_data = array(':username'  => $username);
 
 
	if($statement->execute($check_data)) {
		if($statement->rowCount() > 0){
			$message .= '<p><label>Username already taken</label></p>';
			$msg=1;
		}
		else{
			if(empty($username)){
				$message .= '<p><label>Username is required</label></p>';
				$msg=2;
			}
			if(empty($password)){
				$message .= '<p><label>Password is required</label></p>';
				$msg=2;
			}
			else{
				if($password != $_POST['confirm_password']){
					$message .= '<p><label>Password not match</label></p>';
					$msg=2;
				}
			}
			if($message == ''){
				$data = array(':email'  => $email,':username'  => $username,':password'  => $password);

				$query = "INSERT INTO login (email, username, password) VALUES (:email, :username, :password)";
				$statement = $connect->prepare($query);
				
				if($statement->execute($data)){
					$message = "<label>Registration Completed</label>";
					$msg=3;
				}
			}
		}
	}
}
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Sikaredu</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
   
    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  
    <style>
        .name{
            width: 300px;
        }
    </style>
</head>

<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    <!-- header-start -->
   
    <!-- header-end -->

        <!-- bradcam_area_start -->
        <div class="bradcam_area breadcam_bg overlay2">
            <h3>Sign Up</h3>
        </div>
        <!-- bradcam_area_end -->

<div class="popup_box" style="width:100%" align="center">


                <form method="post">
				<?php echo $message; ?>
				
				 <?php
				  if($msg==3){
				  	echo '<script type="text/javascript">
  					swal("", "Registration successful", "success");
  					</script>';
  				}
  				elseif($msg==2) {
				  	echo '<script type="text/javascript">
  					swal("", "Something missing!", "info");
  					</script>';
				  }
				  elseif($msg==1) {
				  	echo '<script type="text/javascript">
  					swal("", "Username already taken please change it!", "info");
  					</script>';
				  }
                ?>
                    <div >
                        <div class="name">
                            <input name="email" type="email" placeholder="Enter email" required="">
                        </div>
                        <div class="name">
                            <input name="username" type="text" placeholder="username" required="">
                        </div>

                        <div class="name">
                            <input name="password" type="password" placeholder="Password" required="">
                        </div>
						<div class="name">
                            <input name="confirm_password" type="password" placeholder="Confirm Password" required="">
                        </div>
                        <div class="btn">
                            <button type="submit" name="register" class="boxed_btn_orange">Sign Up</button>
                        </div>
                    </div>
                </form>
				<p class="doen_have_acc">Already have an account? <a href="login.php">Login</a>
                </p>
            </div>
</body>
</html>