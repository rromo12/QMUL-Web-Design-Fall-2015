<?PHP
include 'config.php';
$userid = $_GET['userid'];
  ChromePhp::log($userid);

$data = json_decode(file_get_contents('php://input'));
$song = $data->spotifyURI;
$quote = $data->quote;
$video= $data->youtubeURL;
$image = $data->imageURL;

$errorMessage = "";
$num_rows = 0;
//ChromePhp::log($userid);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  //====================================================================
  //  AND CHECK FOR DANGEROUS CHARCTERS
  //====================================================================
  $userid = htmlspecialchars($userid);
  $song = htmlspecialchars($song);
  $quote = htmlspecialchars($quote);
  $video = htmlspecialchars($video);
  $image = htmlspecialchars($image);


  

  //====================================================================
  //  Write to the database
  //====================================================================
  if ($errorMessage == "") {
    $db_handle = mysql_connect($server, $user_name, $pass_word);
    $db_found = mysql_select_db($database, $db_handle);

    if ($db_found) {

      $song = quote_smart($song, $db_handle);
      $quote = quote_smart($quote, $db_handle);
      $video = quote_smart($video, $db_handle);
      $image = quote_smart($image, $db_handle);


      $SQL = "SELECT * FROM user_info WHERE userid = $userid";
      $result = mysql_query($SQL);
      $num_rows = mysql_num_rows($result);



      if ($num_rows > 0) {
        $SQL = "UPDATE user_info SET user_song = $song, user_quote=$quote, user_video = $video, user_picture=$image WHERE userid=$userid";
        
        $result = mysql_query($SQL);
        }
    else {
      $errorMessage = "UPDATE FAILED";
      }
      }
  else {
  
     $errorMessage = "Database Not Found";
  }
  }

}




?>
