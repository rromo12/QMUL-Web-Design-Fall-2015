<?php
include 'config.php';

$data = json_decode(file_get_contents('php://input'));

$post = $data->post;
$userid = $data->userid;
$public = $data->public;

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  
  $post   = htmlspecialchars($post);
  $userid = htmlspecialchars($userid);
  $public = htmlspecialchars($public);
 

  if ($errorMessage == "") {

	  $db_handle = mysql_connect($server, $user_name, $pass_word);
	  $db_found = mysql_select_db($database, $db_handle);

	  if ($db_found) 
	  {

		    $post   = quote_smart($post, $db_handle);
		    $userid  = quote_smart($userid, $db_handle);
		    $public   = quote_smart($public, $db_handle);
		           //= quote_smart( , $db_handle);

		    $SQL = "INSERT INTO user_posts (userid, post, public) VALUES ($userid, $post, $public)";
		    $result = mysql_query($SQL);
		    mysql_close($db_handle);
   	  }

  }
  else {
    	
    	$errorMessage = "Database Not Found";
  }



  }




?>









