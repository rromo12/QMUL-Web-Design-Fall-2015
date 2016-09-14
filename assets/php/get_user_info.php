<?php
include 'config.php';
  
  $userid = $_GET['userid'];
    $connection = mysqli_connect($server,$user_name,$pass_word,$database) or die("Error " . mysqli_error($connection));

    //fetch specific user provided by url db
     if($userid != "*"){
        $sql = "SELECT * FROM user_info WHERE userid=$userid";
      }
      else {
        $sql = "SELECT * FROM user_info";
     
     }
  //fetch all users
	//$sql = "SELECT * FROM user_info";
    $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));

    //create an array
    $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray[] = $row;
    }
    echo json_encode($emparray);

    //close the db connection
    mysqli_close($connection);



?>
