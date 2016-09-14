<?PHP
//session_start();
//if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
  //header ("Location: login.php");
//}

//set the session variable to 1, if the user signs up. That way, they can use the site straight away
//do you want to send the user a confirmation email?
//does the user need to validate an email address, before they can use the site?
//do you want to display a message for the user that a particular username is already taken?
//test to see if the u and p are long enough
//you might also want to test if the users is already logged in. That way, they can't sign up repeatedly without closing down the browser
//other login methods - set a cookie, and read that back for every page
//collect other information: date and time of login, ip address, etc
//don't store passwords without encrypting them
$data = json_decode(file_get_contents('php://input'));
//$uname = "";
$uname = mysql_real_escape_string($data->fname);
$pass = mysql_real_escape_string($data->lname);
$email = mysql_real_escape_string($data->email);
$pwd = mysql_real_escape_string($data->pwd);

$errorMessage = "";
$num_rows = 0;

function quote_smart($value, $handle) {

   if (get_magic_quotes_gpc()) {
       $value = stripslashes($value);
   }

   if (!is_numeric($value)) {
       $value = "'" . mysql_real_escape_string($value, $handle) . "'";
   }
   return $value;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  //====================================================================
  //  GET THE CHOSEN U AND P, AND CHECK IT FOR DANGEROUS CHARCTERS
  //====================================================================
  $uname = htmlspecialchars($uname);
  $pword = htmlspecialchars($pwd);

  //====================================================================
  //  CHECK TO SEE IF U AND P ARE OF THE CORRECT LENGTH
  //  A MALICIOUS USER MIGHT TRY TO PASS A STRING THAT IS TOO LONG
  //  if no errors occur, then $errorMessage will be blank
  //====================================================================

  $uLength = strlen($uname);
  $pLength = strlen($pwd);

  if ($uLength >= 3 && $uLength <= 20) {
    $errorMessage = "";
  }
  else {
    $errorMessage = $errorMessage . "Username must be between 10 and 20 characters" . "<BR>";
  }

  if ($pLength >= 3 && $pLength <= 16) {
    $errorMessage = "";
  }
  else {
    $errorMessage = $errorMessage . "Password must be between 8 and 16 characters" . "<BR>";
  }


//test to see if $errorMessage is blank
//if it is, then we can go ahead with the rest of the code
//if it's not, we can display the error

  //====================================================================
  //  Write to the database
  //====================================================================
  if ($errorMessage == "") {

  $user_name = "root";
  $pass_word = "";
  $database = "webauth";
  $server = "127.0.0.1";

  $db_handle = mysql_connect($server, $user_name, $pass_word);
  $db_found = mysql_select_db($database, $db_handle);

  if ($db_found) {

    $uname = quote_smart($uname, $db_handle);
    $pword = quote_smart($pword, $db_handle);

  //====================================================================
  //  CHECK THAT THE USERNAME IS NOT TAKEN
  //====================================================================

    $SQL = "SELECT * FROM user_pwd WHERE name = $uname";
    $result = mysql_query($SQL);
    $num_rows = mysql_num_rows($result);

    if ($num_rows > 0) {
      $errorMessage = "Username already taken";
    }
    
    else {

      $SQL = "INSERT INTO user_pwd (name, pass) VALUES ($uname, md5($pword))";
   //TODO FIX HASHING MD5 IS insecure   
      //$SQL = "INSERT INTO user_pwd (name, pass) VALUES ($uname, password_hash($pword, PASSWORD_DEFAULT))";
      //echo password_hash($pword, PASSWORD_DEFAULT);
      $result = mysql_query($SQL);

      mysql_close($db_handle);

    //=================================================================================
    //  START THE SESSION AND PUT SOMETHING INTO THE SESSION VARIABLE CALLED login
    //  SEND USER TO A DIFFERENT PAGE AFTER SIGN UP
    //=================================================================================

      session_start();
      $_SESSION['login'] = "1";

    }

  }
  else {
    $errorMessage = "Database Not Found";
  }




  }

}


?>
