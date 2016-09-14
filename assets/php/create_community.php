<?PHP
include 'config.php';
$data = json_decode(file_get_contents('php://input'));
$cname = $data->cname;
$adminid = $data->adminid;
$picture = $data->picture;
$country = $data->country;
$city = $data->city;
$description = $data->description;


$errorMessage = "";
$num_rows = 0;


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  
  $cname = htmlspecialchars($cname);
  $adminid = htmlspecialchars($adminid);
  $picture = htmlspecialchars($picture);
  $country = htmlspecialchars($country);
  $city = htmlspecialchars($city);
  $description = htmlspecialchars($description);
  
  if ($errorMessage == "") {

  $db_handle = mysql_connect($server, $user_name, $pass_word);
  $db_found = mysql_select_db($database, $db_handle);

  if ($db_found) {

    $cname   = quote_smart($cname, $db_handle);
    $adminid   = quote_smart($adminid, $db_handle);
    $picture   = quote_smart($picture, $db_handle);
    $country = quote_smart($country , $db_handle);
    $city    = quote_smart($city , $db_handle);
    $description     = quote_smart($description , $db_handle);
           //= quote_smart( , $db_handle);

  //====================================================================
  //  CHECK THAT THE NAME IS NOT TAKEN
  //====================================================================

    $SQL = "SELECT * FROM community_info WHERE community_name = $cname";
    $result = mysql_query($SQL);
    $num_rows = mysql_num_rows($result);
    if ($num_rows > 0) {
      $errorMessage = " Community name already taken";
    }
    else {
      $SQL = "INSERT INTO community_info (community_name, community_adminid, community_picture, community_country, community_city, community_description) VALUES ($cname, $adminid, $picture, $country, $city, $description)";
      $result = mysql_query($SQL);
      mysql_close($db_handle);

    }

  }
  else {
    $errorMessage = "Database Not Found";
  }




  }

}
?>
