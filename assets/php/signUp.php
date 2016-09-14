<?PHP
include 'config.php';
//ChromePhp::log('Hello console!');
//ChromePhp::warn('something went wrong!');
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

$fname = $data->fname;
$lname = $data->lname;
$uname = $data->email;
$email = $data->email;
$pword = $data->pwd;
$country = $data->country;
$city = $data->city;
$dob = $data->dob;
$sex = $data->sex;
$goal = $data->goal;

$errorMessage = "";
$num_rows = 0;


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  //====================================================================
  //  GET THE CHOSEN U AND P, AND CHECK IT FOR DANGEROUS CHARCTERS
  //====================================================================
  
  $uname = htmlspecialchars($uname);
  $pword = htmlspecialchars($pword);
  $fname = htmlspecialchars($fname);
  $lname = htmlspecialchars($lname);
  $email = htmlspecialchars($email);
  $country = htmlspecialchars($country);
  $city = htmlspecialchars($city);
  $dob = htmlspecialchars($dob);
  $sex = htmlspecialchars($sex);
  $goal = htmlspecialchars($goal);

  //====================================================================
  //  CHECK TO SEE IF U AND P ARE OF THE CORRECT LENGTH
  //  A MALICIOUS USER MIGHT TRY TO PASS A STRING THAT IS TOO LONG
  //  if no errors occur, then $errorMessage will be blank
  //====================================================================
//test to see if $errorMessage is blank
//if it is, then we can go ahead with the rest of the code
//if it's not, we can display the error

  //====================================================================
  //  Write to the database
  //====================================================================
  if ($errorMessage == "") {

  $db_handle = mysql_connect($server, $user_name, $pass_word);
  $db_found = mysql_select_db($database, $db_handle);

  if ($db_found) {

    $uname   = quote_smart($uname, $db_handle);
    ChromePhp::log($uname);

    $pword   = quote_smart($pword, $db_handle);
    $fname   = quote_smart($fname, $db_handle);
    $lname   = quote_smart($lname , $db_handle);
    $email   = quote_smart($email , $db_handle);
    $country = quote_smart($country , $db_handle);
    $city    = quote_smart($city , $db_handle);
    $dob     = quote_smart($dob , $db_handle);
    $sex     = quote_smart($sex , $db_handle);
    $goal    = quote_smart($goal , $db_handle);
           //= quote_smart( , $db_handle);

  //====================================================================
  //  CHECK THAT THE USERNAME IS NOT TAKEN
  //====================================================================

    $SQL = "SELECT * FROM user_info WHERE user_email = $email";
    $result = mysql_query($SQL);
    $num_rows = mysql_num_rows($result);
    if ($num_rows > 0) {
      $errorMessage = "Username already taken";

    }
    else {
      $SQL = "INSERT INTO user_info (user_password, user_fname, user_lname, user_email, user_country, user_city, user_birthdate,user_sex,user_goal) VALUES (md5($pword),$fname, $lname, $email, $country, $city, $dob, $sex,$goal)";
      $result = mysql_query($SQL);
      $SQL = "SELECT * FROM user_info WHERE $user_email = $email";
      $result = mysql_query($SQL);
      $value = mysql_fetch_object($result); 
      echo json_encode($value);
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
