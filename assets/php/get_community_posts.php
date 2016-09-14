<?php
include 'config.php';
//add logic for either or both
    $communityid = $_GET['communityid'];
ChromePhp::log($communityid);


    $connection = mysqli_connect($server,$user_name,$pass_word,$database) or die("Error " . mysqli_error($connection));

    //fetch table rows from mysql db
    if($communityid != "*"){
        $sql = "SELECT * FROM community_posts WHERE communityid=$communityid";
        }
    else{
        $sql = "SELECT * FROM community_posts";
      }

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