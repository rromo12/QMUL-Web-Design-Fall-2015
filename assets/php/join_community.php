<?php
include 'config.php';

$data = json_decode(file_get_contents('php://input'));

$communityid = $data->communityid;
$userid = $data->userid;

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  
  $userid = htmlspecialchars($userid);
  $communityid = htmlspecialchars($communityid);
 

  if ($errorMessage == "") {

	  $db_handle = mysql_connect($server, $user_name, $pass_word);
	  $db_found = mysql_select_db($database, $db_handle);

	  if ($db_found) 
	  {

		    $userid  = quote_smart($userid, $db_handle);
		    $communityid   = quote_smart($communityid, $db_handle);
		           //= quote_smart( , $db_handle);

		    $SQL = "INSERT INTO communities_joined (userid, communityid) VALUES ($userid, $communityid)";
		    $result = mysql_query($SQL);
		    mysql_close($db_handle);
   	  }

  }
  else {
    	
    	$errorMessage = "Database Not Found";
  }



  }




?>









