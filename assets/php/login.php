<?PHP
include 'config.php';


  $data = json_decode(file_get_contents('php://input'));
  $uname = $data->email;
  $pword = $data->password;

  $uname = htmlspecialchars($uname);
  $pword = htmlspecialchars($pword);

  $db_handle = mysql_connect($server, $user_name, $pass_word);
  $db_found = mysql_select_db($database, $db_handle);

  if ($db_found) {

    $uname = quote_smart($uname, $db_handle);
    //$pword = quote_smart($pword, $db_handle);

    $SQL = "SELECT * FROM user_info WHERE user_email = $uname AND user_password = md5($pword)";
    $result = mysql_query($SQL);
    $num_rows = mysql_num_rows($result);
    $value = mysql_fetch_object($result);

  //====================================================
  //  CHECK TO SEE IF THE $result VARIABLE IS TRUE
  //====================================================

    if ($result) {
      if ($num_rows > 0) {
        session_start();
        //ChromePhp::log($value->userid);
        //$_SESSION['userid'] = $userid;
        ChromePhp::log('Valid login');
        ChromePhp::log($value);
        echo "json_encode($value)";
       }
      else {
        session_start();
        $_SESSION['login'] = "";
        $_SESSION['userid'] = "";
        //$_SESSION['userid'] = $userid;
        //header ("Location: http://webprojects.eecs.qmul.ac.uk/rgr30/BeOne/assets/php/get_user_info.html");
        ChromePhp::log('Try Again');

      } 
    }
    else {
      $errorMessage = "Error logging on";
    }

  mysql_close($db_handle);

  }

  else {
    $errorMessage = "Error logging on";
  }













?>