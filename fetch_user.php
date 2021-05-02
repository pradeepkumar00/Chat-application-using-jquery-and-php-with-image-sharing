<?php

//fetch_user.php

include('database_connection.php');

session_start();

$query = "
SELECT * FROM login 
WHERE user_id != '".$_SESSION['user_id']."' 
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$output = ' ';

foreach($result as $row)
{
 $status = '';
 $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
 $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
 $user_last_activity = fetch_user_last_activity($row['user_id'], $connect);
 if($user_last_activity > $current_timestamp)
 {
  $status = '<i class="glyphicon glyphicon-user w3-text-orange"></i>';
 }
 else
 {
  $status = '<i class="glyphicon glyphicon-user "></i>';
 }
 $output .= '

  <div class="column" style="background-color:#00ffcc;">
    <h2>'.$row['username'].' '.count_unseen_message($row['user_id'], $_SESSION['user_id'], $connect).' '.fetch_is_type_status($row['user_id'], $connect).'</h2>
  </div>
  <div class="column1" style="background-color:#00ffcc;">
    <h2>'.$status.'</h2>
  </div>
  <div class="column2" style="background-color:#00ffcc;">
    <h2><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['user_id'].'"data-tousername="'.$row['username'].'">Start Chat</button>
    </h2>
    <h2><button type="button" class="btn btn-info btn-xs start_chat1" data-touserid="'.$row['user_id'].'"data-tousername="'.$row['username'].'">Start Chat</button>
    </h2>
  </div>
<br><br><br><br><br><br>
 ';
}


echo $output;

?>